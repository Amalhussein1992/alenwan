<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeriesResource\Pages;
use App\Filament\Resources\SeriesResource\RelationManagers;
use App\Models\Series;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?string $navigationLabel = 'المسلسلات';

    protected static ?string $modelLabel = 'مسلسل';

    protected static ?string $pluralModelLabel = 'المسلسلات';

    protected static ?string $navigationGroup = 'إدارة المحتوى';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title.ar')
                            ->label('العنوان بالعربية')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) =>
                                !$get('slug') ? $set('slug', Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('title.en')
                            ->label('العنوان بالإنجليزية')
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('category_id')
                            ->label('الفئة')
                            ->relationship('category', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', 'ar'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'ongoing' => 'مستمر',
                                'completed' => 'منتهي',
                                'upcoming' => 'قريباً',
                            ])
                            ->default('ongoing')
                            ->required(),
                        Forms\Components\TextInput::make('rating')
                            ->label('التقييم')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.1),
                    ])->columns(2),
                Forms\Components\Section::make('الوصف')
                    ->schema([
                        Forms\Components\RichEditor::make('description.ar')
                            ->label('الوصف بالعربية')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description.en')
                            ->label('الوصف بالإنجليزية')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('الصورة المصغرة')
                            ->image()
                            ->directory('series/thumbnails'),
                        Forms\Components\FileUpload::make('poster')
                            ->label('البوستر')
                            ->image()
                            ->directory('series/posters'),
                        Forms\Components\Toggle::make('is_premium')
                            ->label('Premium')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('مميز')
                            ->default(false),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('الصورة')
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'ar'))
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة')
                    ->getStateUsing(fn ($record) => $record->category?->getTranslation('name', 'ar'))
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'ongoing' => 'مستمر',
                        'completed' => 'منتهي',
                        'upcoming' => 'قريباً',
                        default => $state,
                    })
                    ->badge(),
                Tables\Columns\IconColumn::make('is_premium')
                    ->label('Premium')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->label('المحذوفة'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                    Tables\Actions\RestoreBulkAction::make()->label('استعادة'),
                    Tables\Actions\ForceDeleteBulkAction::make()->label('حذف نهائي'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSeries::route('/create'),
            'edit' => Pages\EditSeries::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeasonResource\Pages;
use App\Filament\Resources\SeasonResource\RelationManagers;
use App\Models\Season;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeasonResource extends Resource
{
    protected static ?string $model = Season::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'المواسم';

    protected static ?string $modelLabel = 'موسم';

    protected static ?string $pluralModelLabel = 'المواسم';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الموسم')
                    ->schema([
                        Forms\Components\Select::make('series_id')
                            ->label('المسلسل')
                            ->relationship('series', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('title', 'ar'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('season_number')
                            ->label('رقم الموسم')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('title.ar')
                            ->label('العنوان بالعربية')
                            ->required(),

                        Forms\Components\TextInput::make('title.en')
                            ->label('العنوان بالإنجليزية')
                            ->required(),

                        Forms\Components\Textarea::make('description.ar')
                            ->label('الوصف بالعربية')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.en')
                            ->label('الوصف بالإنجليزية')
                            ->rows(3),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('الصورة')
                            ->image()
                            ->directory('seasons/thumbnails'),

                        Forms\Components\TextInput::make('release_year')
                            ->label('سنة الإصدار')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 2),

                        Forms\Components\TextInput::make('order')
                            ->label('الترتيب')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('الصورة')
                    ->size(50),

                Tables\Columns\TextColumn::make('series.title')
                    ->label('المسلسل')
                    ->getStateUsing(fn ($record) => $record->series?->getTranslation('title', 'ar'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('season_number')
                    ->label('الموسم')
                    ->formatStateUsing(fn ($state) => "الموسم {$state}")
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'ar'))
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('episodes_count')
                    ->label('الحلقات')
                    ->counts('episodes')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('release_year')
                    ->label('السنة')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('series_id')
                    ->label('المسلسل')
                    ->relationship('series', 'title')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('title', 'ar'))
                    ->multiple()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('النشط فقط')
                    ->falseLabel('غير النشط فقط'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('season_number', 'asc');
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
            'index' => Pages\ListSeasons::route('/'),
            'create' => Pages\CreateSeason::route('/create'),
            'edit' => Pages\EditSeason::route('/{record}/edit'),
        ];
    }
}

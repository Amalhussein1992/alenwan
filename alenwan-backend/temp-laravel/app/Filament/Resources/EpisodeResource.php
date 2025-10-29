<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Filament\Resources\EpisodeResource\RelationManagers;
use App\Models\Episode;
use App\Models\Season;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationIcon = 'heroicon-o-play';

    protected static ?string $navigationLabel = 'الحلقات';

    protected static ?string $modelLabel = 'حلقة';

    protected static ?string $pluralModelLabel = 'الحلقات';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الحلقة')
                    ->schema([
                        Forms\Components\Select::make('season_id')
                            ->label('الموسم')
                            ->relationship('season', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                $record->series?->getTranslation('title', 'ar') . ' - الموسم ' . $record->season_number
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('episode_number')
                            ->label('رقم الحلقة')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('title.ar')
                            ->label('العنوان بالعربية')
                            ->required(),

                        Forms\Components\TextInput::make('title.en')
                            ->label('العنوان بالإنجليزية')
                            ->required(),

                        Forms\Components\RichEditor::make('description.ar')
                            ->label('الوصف بالعربية')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description.en')
                            ->label('الوصف بالإنجليزية')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الفيديو والصور')
                    ->schema([
                        Forms\Components\TextInput::make('vimeo_id')
                            ->label('Vimeo ID')
                            ->helperText('معرف الفيديو على Vimeo (اختياري)'),

                        Forms\Components\TextInput::make('vimeo_url')
                            ->label('رابط Vimeo')
                            ->url(),

                        Forms\Components\TextInput::make('video_url')
                            ->label('رابط الفيديو')
                            ->url()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('الصورة المصغرة')
                            ->image()
                            ->directory('episodes/thumbnails')
                            ->imageEditor(),

                        Forms\Components\TextInput::make('duration')
                            ->label('المدة (بالدقائق)')
                            ->numeric()
                            ->minValue(0)
                            ->suffix('دقيقة'),

                        Forms\Components\DatePicker::make('release_date')
                            ->label('تاريخ النشر')
                            ->default(now()),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('الترتيب')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),

                        Forms\Components\TextInput::make('views_count')
                            ->label('عدد المشاهدات')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('الصورة')
                    ->size(50),

                Tables\Columns\TextColumn::make('season.series.title')
                    ->label('المسلسل')
                    ->getStateUsing(fn ($record) => $record->season?->series?->getTranslation('title', 'ar'))
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('season.season_number')
                    ->label('الموسم')
                    ->formatStateUsing(fn ($state) => "م{$state}")
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('episode_number')
                    ->label('الحلقة')
                    ->formatStateUsing(fn ($state) => "ح{$state}")
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'ar'))
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('duration')
                    ->label('المدة')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} د" : '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('release_date')
                    ->label('تاريخ النشر')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('season_id')
                    ->label('الموسم')
                    ->relationship('season', 'title')
                    ->getOptionLabelFromRecordUsing(fn ($record) =>
                        $record->series?->getTranslation('title', 'ar') . ' - الموسم ' . $record->season_number
                    )
                    ->multiple()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('النشط فقط')
                    ->falseLabel('غير النشط فقط'),

                Tables\Filters\TrashedFilter::make()
                    ->label('المحذوفة'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
                Tables\Actions\RestoreAction::make()->label('استعادة'),
                Tables\Actions\ForceDeleteAction::make()->label('حذف نهائي'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                    Tables\Actions\RestoreBulkAction::make()->label('استعادة المحدد'),
                    Tables\Actions\ForceDeleteBulkAction::make()->label('حذف نهائي'),
                ]),
            ])
            ->defaultSort('episode_number', 'asc');
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
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
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

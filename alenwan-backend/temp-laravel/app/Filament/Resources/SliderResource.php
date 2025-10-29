<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'السلايدر';
    }

    public static function getModelLabel(): string
    {
        return 'سلايد';
    }

    public static function getPluralModelLabel(): string
    {
        return 'السلايدر';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('filament.fields.title'))
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.fields.description'))
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\FileUpload::make('image')
                            ->label(__('filament.fields.poster'))
                            ->image()
                            ->directory('sliders')
                            ->required()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->maxSize(2048),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('الربط')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label(__('filament.fields.type'))
                            ->options([
                                'movie' => __('filament.resources.movies.label'),
                                'series' => __('filament.resources.series.label'),
                                'category' => __('filament.resources.categories.label'),
                                'url' => 'رابط خارجي',
                            ])
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => [
                                $set('movie_id', null),
                                $set('series_id', null),
                                $set('category_id', null),
                                $set('url', null),
                            ]),
                        Forms\Components\Select::make('movie_id')
                            ->label(__('filament.resources.movies.label'))
                            ->relationship('movie', 'title')
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('type') === 'movie'),
                        Forms\Components\Select::make('series_id')
                            ->label(__('filament.resources.series.label'))
                            ->relationship('series', 'title')
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('type') === 'series'),
                        Forms\Components\Select::make('category_id')
                            ->label(__('filament.resources.categories.label'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('type') === 'category'),
                        Forms\Components\TextInput::make('url')
                            ->label(__('filament.fields.url'))
                            ->url()
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('type') === 'url'),
                        Forms\Components\TextInput::make('button_text')
                            ->label('نص الزر')
                            ->maxLength(255)
                            ->placeholder('شاهد الآن'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('filament.fields.is_active'))
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->label(__('filament.fields.order'))
                            ->numeric()
                            ->default(0)
                            ->helperText('الترتيب (الأقل أولاً)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament.fields.poster'))
                    ->size(100),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.fields.title'))
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament.fields.type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'movie' => __('filament.resources.movies.label'),
                        'series' => __('filament.resources.series.label'),
                        'category' => __('filament.resources.categories.label'),
                        'url' => 'رابط خارجي',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'movie' => 'success',
                        'series' => 'info',
                        'category' => 'warning',
                        'url' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('filament.fields.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('filament.fields.order'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('filament.fields.type'))
                    ->options([
                        'movie' => __('filament.resources.movies.label'),
                        'series' => __('filament.resources.series.label'),
                        'category' => __('filament.resources.categories.label'),
                        'url' => 'رابط خارجي',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('filament.fields.is_active')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}

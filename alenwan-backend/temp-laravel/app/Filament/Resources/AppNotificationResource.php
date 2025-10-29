<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppNotificationResource\Pages;
use App\Filament\Resources\AppNotificationResource\RelationManagers;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppNotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.configuration');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.resources.notifications.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament.resources.notifications.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.notifications.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.notifications.sections.basic_info'))
                    ->schema([
                        Forms\Components\TextInput::make('title.ar')
                            ->label(__('filament.fields.title_ar'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title.en')
                            ->label(__('filament.fields.title_en'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('body.ar')
                            ->label(__('filament.fields.description_ar'))
                            ->required()
                            ->rows(3),
                        Forms\Components\Textarea::make('body.en')
                            ->label(__('filament.fields.description_en'))
                            ->required()
                            ->rows(3),
                        Forms\Components\FileUpload::make('image')
                            ->label(__('filament.fields.poster'))
                            ->image()
                            ->directory('notifications'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('filament.resources.notifications.sections.targeting'))
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label(__('filament.fields.type'))
                            ->options([
                                'general' => __('filament.resources.notifications.types.general'),
                                'movie' => __('filament.resources.notifications.types.movie'),
                                'series' => __('filament.resources.notifications.types.series'),
                                'category' => __('filament.resources.notifications.types.category'),
                                'promotion' => __('filament.resources.notifications.types.promotion'),
                            ])
                            ->required()
                            ->reactive(),
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
                            ->maxLength(255),
                        Forms\Components\Toggle::make('send_to_all')
                            ->label(__('filament.resources.notifications.fields.send_to_all'))
                            ->default(true)
                            ->reactive(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('filament.resources.notifications.sections.scheduling'))
                    ->schema([
                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label(__('filament.fields.scheduled_at')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.ar')
                    ->label(__('filament.fields.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament.fields.type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __('filament.resources.notifications.types.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'info',
                        'movie' => 'success',
                        'series' => 'warning',
                        'category' => 'primary',
                        'promotion' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('send_to_all')
                    ->label(__('filament.resources.notifications.fields.send_to_all'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_sent')
                    ->label(__('filament.resources.notifications.fields.is_sent'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('sent_count')
                    ->label(__('filament.resources.notifications.fields.sent_count'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label(__('filament.fields.scheduled_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label(__('filament.resources.notifications.fields.sent_at'))
                    ->dateTime()
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
                        'general' => __('filament.resources.notifications.types.general'),
                        'movie' => __('filament.resources.notifications.types.movie'),
                        'series' => __('filament.resources.notifications.types.series'),
                        'category' => __('filament.resources.notifications.types.category'),
                        'promotion' => __('filament.resources.notifications.types.promotion'),
                    ]),
                Tables\Filters\TernaryFilter::make('is_sent')
                    ->label(__('filament.resources.notifications.fields.is_sent')),
                Tables\Filters\TernaryFilter::make('send_to_all')
                    ->label(__('filament.resources.notifications.fields.send_to_all')),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAppNotifications::route('/'),
            'create' => Pages\CreateAppNotification::route('/create'),
            'edit' => Pages\EditAppNotification::route('/{record}/edit'),
        ];
    }
}

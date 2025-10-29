<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PodcastResource\Pages;
use App\Filament\Resources\PodcastResource\RelationManagers;
use App\Models\Podcast;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PodcastResource extends Resource
{
    protected static ?string $model = Podcast::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'البودكاست';
    }

    public static function getModelLabel(): string
    {
        return 'بودكاست';
    }

    public static function getPluralModelLabel(): string
    {
        return 'البودكاست';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('filament.fields.title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_ar')
                            ->label(__('filament.fields.title_ar'))
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.fields.description'))
                            ->rows(3),
                        Forms\Components\Textarea::make('description_ar')
                            ->label(__('filament.fields.description_ar'))
                            ->rows(3),
                        Forms\Components\FileUpload::make('poster')
                            ->label(__('filament.fields.poster'))
                            ->image()
                            ->directory('podcasts/posters')
                            ->imageEditor(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الروابط والملفات')
                    ->schema([
                        Forms\Components\TextInput::make('audio_url')
                            ->label('رابط الصوت')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('video_url')
                            ->label(__('filament.fields.video_url'))
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('duration')
                            ->label('المدة (بالدقائق)')
                            ->numeric()
                            ->suffix('دقيقة'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('التصنيف والمقدم')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label(__('filament.fields.category'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('language_id')
                            ->label(__('filament.fields.language'))
                            ->relationship('language', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('host')
                            ->label('المقدم')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('host_ar')
                            ->label('المقدم (عربي)')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\DatePicker::make('release_date')
                            ->label('تاريخ الإصدار'),
                        Forms\Components\TextInput::make('season_number')
                            ->label('رقم الموسم')
                            ->numeric(),
                        Forms\Components\TextInput::make('episode_number')
                            ->label('رقم الحلقة')
                            ->numeric(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_premium')
                            ->label(__('filament.fields.is_premium'))
                            ->default(false),
                        Forms\Components\Toggle::make('is_published')
                            ->label('منشور')
                            ->default(true),
                        Forms\Components\TextInput::make('views_count')
                            ->label('عدد المشاهدات')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('likes_count')
                            ->label('عدد الإعجابات')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('poster')
                    ->label(__('filament.fields.poster'))
                    ->size(80),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.fields.title'))
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('host')
                    ->label('المقدم')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('filament.fields.category'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('المدة')
                    ->suffix(' دقيقة')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_premium')
                    ->label(__('filament.fields.is_premium'))
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label(__('filament.fields.category'))
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label(__('filament.fields.is_premium')),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('منشور'),
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
            'index' => Pages\ListPodcasts::route('/'),
            'create' => Pages\CreatePodcast::route('/create'),
            'edit' => Pages\EditPodcast::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ChannelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LiveStreamsRelationManager extends RelationManager
{
    protected static string $relationship = 'liveStreams';

    protected static ?string $title = 'البثوث المباشرة';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title.ar')
                    ->label('عنوان البث (عربي)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('title.en')
                    ->label('عنوان البث (إنجليزي)')
                    ->required(),

                Forms\Components\TextInput::make('slug')
                    ->label('المعرف')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Textarea::make('description.ar')
                    ->label('الوصف (عربي)')
                    ->rows(3),

                Forms\Components\Select::make('stream_type')
                    ->label('نوع البث')
                    ->options([
                        'live' => 'مباشر',
                        'recorded' => 'مسجل',
                        'upcoming' => 'قادم',
                    ])
                    ->default('live')
                    ->required(),

                Forms\Components\TextInput::make('youtube_video_id')
                    ->label('معرف الفيديو على YouTube')
                    ->helperText('مثال: dQw4w9WgXcQ'),

                Forms\Components\Toggle::make('is_live_now')
                    ->label('بث مباشر الآن')
                    ->default(false),

                Forms\Components\Toggle::make('is_published')
                    ->label('منشور')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('الصورة')
                    ->size(80),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('stream_type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'live' => 'مباشر',
                        'recorded' => 'مسجل',
                        'upcoming' => 'قادم',
                        default => $state,
                    })
                    ->color(fn ($state) => match($state) {
                        'live' => 'danger',
                        'recorded' => 'success',
                        'upcoming' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_live_now')
                    ->label('مباشر الآن')
                    ->boolean(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->formatStateUsing(fn ($state) => number_format($state)),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

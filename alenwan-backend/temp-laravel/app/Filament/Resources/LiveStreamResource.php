<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LiveStreamResource\Pages;
use App\Models\LiveStream;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class LiveStreamResource extends Resource
{
    protected static ?string $model = LiveStream::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return 'البثوث المباشرة';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')->schema([
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
                        ->unique(ignoreRecord: true)
                        ->helperText('سيتم إنشاؤه تلقائياً من العنوان'),

                    Forms\Components\Textarea::make('description.ar')
                        ->label('الوصف (عربي)')
                        ->rows(3),

                    Forms\Components\Textarea::make('description.en')
                        ->label('الوصف (إنجليزي)')
                        ->rows(3),

                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('صورة مصغرة')
                        ->image()
                        ->directory('live-streams/thumbnails')
                        ->imageEditor(),

                    Forms\Components\FileUpload::make('poster')
                        ->label('صورة الغلاف')
                        ->image()
                        ->directory('live-streams/posters')
                        ->imageEditor(),
                ])->columns(2),

                Forms\Components\Section::make('معلومات القناة')->schema([
                    Forms\Components\Select::make('channel_id')
                        ->label('القناة')
                        ->relationship('channel', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\Select::make('category_id')
                        ->label('التصنيف')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),

                    Forms\Components\Select::make('language_id')
                        ->label('اللغة')
                        ->relationship('language', 'name')
                        ->searchable()
                        ->preload(),
                ])->columns(3),

                Forms\Components\Section::make('إعدادات البث')->schema([
                    Forms\Components\Select::make('platform')
                        ->label('المنصة')
                        ->options([
                            'youtube' => 'YouTube',
                            'vimeo' => 'Vimeo',
                        ])
                        ->default('youtube')
                        ->required()
                        ->reactive(),

                    Forms\Components\Select::make('stream_type')
                        ->label('نوع البث')
                        ->options([
                            'live' => 'مباشر',
                            'recorded' => 'مسجل',
                            'upcoming' => 'قادم',
                        ])
                        ->default('live')
                        ->required(),

                    Forms\Components\TextInput::make('duration')
                        ->label('المدة (دقيقة)')
                        ->numeric()
                        ->helperText('للبثوث المسجلة فقط'),
                ])->columns(3),

                Forms\Components\Section::make('معلومات YouTube')->schema([
                    Forms\Components\TextInput::make('youtube_video_id')
                        ->label('معرف الفيديو')
                        ->helperText('مثال: dQw4w9WgXcQ'),

                    Forms\Components\TextInput::make('youtube_embed_url')
                        ->label('رابط التضمين')
                        ->url()
                        ->helperText('سيتم إنشاؤه تلقائياً من المعرف'),

                    Forms\Components\TextInput::make('youtube_watch_url')
                        ->label('رابط المشاهدة')
                        ->url()
                        ->helperText('سيتم إنشاؤه تلقائياً من المعرف'),
                ])->columns(3)->collapsible()->visible(fn ($get) => $get('platform') === 'youtube'),

                Forms\Components\Section::make('معلومات Vimeo')->schema([
                    Forms\Components\TextInput::make('vimeo_video_id')
                        ->label('معرف الفيديو')
                        ->helperText('مثال: 123456789'),

                    Forms\Components\TextInput::make('vimeo_embed_url')
                        ->label('رابط التضمين')
                        ->url()
                        ->helperText('سيتم إنشاؤه تلقائياً من المعرف'),

                    Forms\Components\TextInput::make('vimeo_player_url')
                        ->label('رابط المشغل')
                        ->url()
                        ->helperText('سيتم إنشاؤه تلقائياً من المعرف'),
                ])->columns(3)->collapsible()->visible(fn ($get) => $get('platform') === 'vimeo'),

                Forms\Components\Section::make('رابط مباشر')->schema([
                    Forms\Components\TextInput::make('stream_url')
                        ->label('رابط البث المباشر')
                        ->url()
                        ->helperText('رابط احتياطي للبث المباشر'),
                ])->collapsible(),

                Forms\Components\Section::make('المواعيد')->schema([
                    Forms\Components\DateTimePicker::make('scheduled_start_time')
                        ->label('موعد البدء المجدول')
                        ->helperText('للبثوث القادمة'),

                    Forms\Components\DateTimePicker::make('actual_start_time')
                        ->label('موعد البدء الفعلي'),

                    Forms\Components\DateTimePicker::make('end_time')
                        ->label('موعد الانتهاء'),
                ])->columns(3)->collapsible(),

                Forms\Components\Section::make('الإحصائيات')->schema([
                    Forms\Components\TextInput::make('views_count')
                        ->label('عدد المشاهدات')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('likes_count')
                        ->label('عدد الإعجابات')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('concurrent_viewers')
                        ->label('المشاهدين الحاليين')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('peak_viewers')
                        ->label('ذروة المشاهدين')
                        ->numeric()
                        ->default(0),
                ])->columns(4)->collapsible(),

                Forms\Components\Section::make('الإعدادات')->schema([
                    Forms\Components\Toggle::make('is_live_now')
                        ->label('بث مباشر الآن')
                        ->default(false),

                    Forms\Components\Toggle::make('is_premium')
                        ->label('بث مميز')
                        ->default(false),

                    Forms\Components\Toggle::make('is_published')
                        ->label('منشور')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('مميز في الصفحة الرئيسية')
                        ->default(false),

                    Forms\Components\Toggle::make('enable_chat')
                        ->label('تفعيل الدردشة')
                        ->default(true),

                    Forms\Components\Toggle::make('enable_notifications')
                        ->label('تفعيل الإشعارات')
                        ->default(true),
                ])->columns(3),

                Forms\Components\Section::make('SEO')->schema([
                    Forms\Components\TagsInput::make('tags')
                        ->label('الوسوم')
                        ->placeholder('أضف وسم'),

                    Forms\Components\TextInput::make('meta_title')
                        ->label('عنوان SEO')
                        ->maxLength(60),

                    Forms\Components\Textarea::make('meta_description')
                        ->label('وصف SEO')
                        ->maxLength(160)
                        ->rows(2),
                ])->columns(2)->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
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
                    ->limit(30)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('channel.name')
                    ->label('القناة')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('platform')
                    ->label('المنصة')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'youtube' => 'danger',
                        'vimeo' => 'info',
                        default => 'gray',
                    }),

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
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_live_now')
                    ->label('مباشر الآن')
                    ->boolean()
                    ->trueIcon('heroicon-o-signal')
                    ->trueColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('scheduled_start_time')
                    ->label('موعد البدء')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_premium')
                    ->label('مميز')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('channel_id')
                    ->label('القناة')
                    ->relationship('channel', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('platform')
                    ->label('المنصة')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('stream_type')
                    ->label('نوع البث')
                    ->options([
                        'live' => 'مباشر',
                        'recorded' => 'مسجل',
                        'upcoming' => 'قادم',
                    ])
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_live_now')
                    ->label('البث المباشر الآن')
                    ->placeholder('الكل')
                    ->trueLabel('مباشر فقط')
                    ->falseLabel('غير مباشر'),

                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label('المحتوى المميز')
                    ->placeholder('الكل')
                    ->trueLabel('مميز فقط')
                    ->falseLabel('عادي فقط'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('حالة النشر')
                    ->placeholder('الكل')
                    ->trueLabel('منشور')
                    ->falseLabel('مسودة'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLiveStreams::route('/'),
            'create' => Pages\CreateLiveStream::route('/create'),
            'edit' => Pages\EditLiveStream::route('/{record}/edit'),
        ];
    }
}

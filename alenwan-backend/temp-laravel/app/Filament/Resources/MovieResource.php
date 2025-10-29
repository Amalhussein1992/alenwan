<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationLabel = 'الأفلام';

    protected static ?string $modelLabel = 'فيلم';

    protected static ?string $pluralModelLabel = 'الأفلام';

    protected static ?string $navigationGroup = 'إدارة المحتوى';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('معلومات الفيلم')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('المعلومات الأساسية')
                            ->schema([
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('العنوان بالعربية')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set, $get) =>
                                        !$get('slug') ? $set('slug', Str::slug($state)) : null
                                    )
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('title.en')
                                    ->label('العنوان بالإنجليزية')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\Select::make('category_id')
                                    ->label('الفئة')
                                    ->relationship('category', 'name')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', 'ar'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name.ar')->label('الاسم بالعربية')->required(),
                                        Forms\Components\TextInput::make('name.en')->label('الاسم بالإنجليزية')->required(),
                                        Forms\Components\TextInput::make('slug')->label('الرابط')->required(),
                                    ]),

                                Forms\Components\RichEditor::make('description.ar')
                                    ->label('الوصف بالعربية')
                                    ->columnSpanFull()
                                    ->maxLength(5000),

                                Forms\Components\RichEditor::make('description.en')
                                    ->label('الوصف بالإنجليزية')
                                    ->columnSpanFull()
                                    ->maxLength(5000),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('الفيديو والصور')
                            ->schema([
                                Forms\Components\TextInput::make('vimeo_id')
                                    ->label('Vimeo ID')
                                    ->helperText('معرف الفيديو على Vimeo (اختياري)')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('vimeo_url')
                                    ->label('رابط Vimeo')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('video_url')
                                    ->label('رابط الفيديو')
                                    ->url()
                                    ->required()
                                    ->helperText('رابط الفيديو الرئيسي')
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('thumbnail')
                                    ->label('الصورة المصغرة')
                                    ->image()
                                    ->directory('movies/thumbnails')
                                    ->imageEditor()
                                    ->maxSize(5120),

                                Forms\Components\FileUpload::make('poster')
                                    ->label('البوستر')
                                    ->image()
                                    ->directory('movies/posters')
                                    ->imageEditor()
                                    ->maxSize(5120),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('التفاصيل')
                            ->schema([
                                Forms\Components\TextInput::make('duration')
                                    ->label('المدة (بالدقائق)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('دقيقة'),

                                Forms\Components\TextInput::make('release_year')
                                    ->label('سنة الإصدار')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y') + 2),

                                Forms\Components\TextInput::make('rating')
                                    ->label('التقييم')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(10)
                                    ->step(0.1)
                                    ->default(0)
                                    ->suffix('/ 10'),

                                Forms\Components\TextInput::make('imdb_id')
                                    ->label('IMDB ID')
                                    ->maxLength(255),

                                Forms\Components\TagsInput::make('genres')
                                    ->label('التصنيفات')
                                    ->placeholder('اضغط Enter بعد كل تصنيف')
                                    ->helperText('مثل: أكشن، دراما، كوميديا')
                                    ->columnSpanFull(),

                                Forms\Components\TagsInput::make('cast')
                                    ->label('الممثلون')
                                    ->placeholder('اضغط Enter بعد كل اسم')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('director.ar')
                                    ->label('المخرج (عربي)')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('director.en')
                                    ->label('المخرج (إنجليزي)')
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('الإعدادات')
                            ->schema([
                                Forms\Components\Toggle::make('is_premium')
                                    ->label('محتوى مميز (Premium)')
                                    ->default(false)
                                    ->inline(false)
                                    ->helperText('هل يحتاج المستخدم اشتراك Premium لمشاهدته؟'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('نشط')
                                    ->default(true)
                                    ->inline(false),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('مميز (Featured)')
                                    ->default(false)
                                    ->inline(false)
                                    ->helperText('سيظهر في قسم المميزات الرئيسية'),

                                Forms\Components\TextInput::make('views_count')
                                    ->label('عدد المشاهدات')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
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
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة')
                    ->getStateUsing(fn ($record) => $record->category?->getTranslation('name', 'ar'))
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('release_year')
                    ->label('السنة')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . '/10' : '-')
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 8 => 'success',
                        $state >= 6 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_premium')
                    ->label('Premium')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean()
                    ->trueIcon('heroicon-o-bookmark')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('info')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('الفئة')
                    ->relationship('category', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', 'ar'))
                    ->multiple()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label('Premium')
                    ->placeholder('الكل')
                    ->trueLabel('Premium فقط')
                    ->falseLabel('عادي فقط'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('المميز')
                    ->placeholder('الكل')
                    ->trueLabel('المميز فقط')
                    ->falseLabel('العادي فقط'),

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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
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

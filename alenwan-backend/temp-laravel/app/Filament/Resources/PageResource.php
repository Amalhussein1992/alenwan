<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'الصفحات';

    protected static ?string $modelLabel = 'صفحة';

    protected static ?string $pluralModelLabel = 'الصفحات';

    protected static ?string $navigationGroup = 'إدارة المحتوى';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('نوع الصفحة')
                            ->options(Page::getTypes())
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط (Slug)')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('سيتم إنشاؤه تلقائياً من العنوان الإنجليزي'),

                        Forms\Components\TextInput::make('icon')
                            ->label('الأيقونة')
                            ->maxLength(255)
                            ->placeholder('fas fa-info-circle')
                            ->helperText('استخدم أيقونات Font Awesome'),

                        Forms\Components\TextInput::make('order')
                            ->label('الترتيب')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Tabs::make('المحتوى')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('العربية')
                            ->schema([
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('العنوان')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('content.ar')
                                    ->label('المحتوى')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('meta_title.ar')
                                    ->label('عنوان SEO')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('meta_description.ar')
                                    ->label('وصف SEO')
                                    ->maxLength(160)
                                    ->rows(3),

                                Forms\Components\TextInput::make('meta_keywords.ar')
                                    ->label('كلمات مفتاحية')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('content.en')
                                    ->label('Content')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('meta_title.en')
                                    ->label('SEO Title')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('meta_description.en')
                                    ->label('SEO Description')
                                    ->maxLength(160)
                                    ->rows(3),

                                Forms\Components\TextInput::make('meta_keywords.en')
                                    ->label('Keywords')
                                    ->maxLength(255),
                            ]),
                    ])->columnSpanFull(),

                Forms\Components\Section::make('الصورة والإعدادات')
                    ->schema([
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('صورة البانر')
                            ->image()
                            ->directory('pages')
                            ->imageEditor()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('منشور')
                            ->default(true)
                            ->required(),

                        Forms\Components\Toggle::make('show_in_menu')
                            ->label('عرض في القائمة')
                            ->default(true)
                            ->required(),

                        Forms\Components\Toggle::make('show_in_footer')
                            ->label('عرض في التذييل')
                            ->default(true)
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->getTranslation('title', app()->getLocale())),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Page::getTypes()[$state] ?? $state),

                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('تم نسخ الرابط'),

                Tables\Columns\ImageColumn::make('banner_image')
                    ->label('الصورة')
                    ->square(),

                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->numeric()
                    ->sortable()
                    ->badge(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('show_in_menu')
                    ->label('في القائمة')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('show_in_footer')
                    ->label('في التذييل')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options(Page::getTypes()),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('منشور')
                    ->placeholder('الكل')
                    ->trueLabel('منشور')
                    ->falseLabel('غير منشور'),

                Tables\Filters\TernaryFilter::make('show_in_menu')
                    ->label('في القائمة')
                    ->placeholder('الكل')
                    ->trueLabel('نعم')
                    ->falseLabel('لا'),

                Tables\Filters\TrashedFilter::make()
                    ->label('المحذوفة'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
                Tables\Actions\ForceDeleteAction::make()
                    ->label('حذف نهائي'),
                Tables\Actions\RestoreAction::make()
                    ->label('استعادة'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('حذف نهائي'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->label('استعادة'),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}

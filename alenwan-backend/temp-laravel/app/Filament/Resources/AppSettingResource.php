<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppSettingResource\Pages;
use App\Models\AppSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppSettingResource extends Resource
{
    protected static ?string $model = AppSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'الإعدادات';

    protected static ?string $modelLabel = 'إعداد';

    protected static ?string $pluralModelLabel = 'الإعدادات';

    protected static ?string $navigationGroup = 'إدارة النظام';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات أساسية')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('المفتاح')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->disabled(fn ($record) => $record !== null)
                            ->helperText('المفتاح الفريد للإعداد (لا يمكن تعديله بعد الإنشاء)'),

                        Forms\Components\Select::make('type')
                            ->label('نوع البيانات')
                            ->required()
                            ->options([
                                'string' => 'نص',
                                'number' => 'رقم',
                                'boolean' => 'نعم/لا',
                                'json' => 'JSON',
                                'file' => 'ملف',
                                'url' => 'رابط',
                                'email' => 'بريد إلكتروني',
                            ])
                            ->default('string')
                            ->reactive(),

                        Forms\Components\Select::make('group')
                            ->label('المجموعة')
                            ->required()
                            ->options([
                                'general' => 'عام',
                                'payment' => 'الدفع',
                                'email' => 'البريد الإلكتروني',
                                'api' => 'مفاتيح API',
                                'app' => 'التطبيق',
                                'social' => 'وسائل التواصل',
                            ])
                            ->default('general'),

                        Forms\Components\TextInput::make('order')
                            ->label('الترتيب')
                            ->numeric()
                            ->default(0)
                            ->helperText('رقم الترتيب لعرض الإعدادات'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('القيمة')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->label('القيمة')
                            ->required()
                            ->maxLength(65535)
                            ->visible(fn ($get) => in_array($get('type'), ['string', 'email', 'url']))
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('value')
                            ->label('القيمة')
                            ->required()
                            ->rows(5)
                            ->visible(fn ($get) => $get('type') === 'json')
                            ->helperText('أدخل JSON صالح')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('value')
                            ->label('القيمة')
                            ->required()
                            ->numeric()
                            ->visible(fn ($get) => $get('type') === 'number')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('value')
                            ->label('القيمة')
                            ->visible(fn ($get) => $get('type') === 'boolean')
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('value')
                            ->label('الملف')
                            ->visible(fn ($get) => $get('type') === 'file')
                            ->directory('settings')
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('التسميات والأوصاف')
                    ->schema([
                        Forms\Components\TextInput::make('label.ar')
                            ->label('التسمية (عربي)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('label.en')
                            ->label('التسمية (English)')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description.ar')
                            ->label('الوصف (عربي)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description.en')
                            ->label('الوصف (English)')
                            ->rows(3),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('الخيارات')
                    ->schema([
                        Forms\Components\Toggle::make('is_public')
                            ->label('عام (يظهر في API)')
                            ->helperText('هل يمكن الوصول لهذا الإعداد من خلال API العام؟')
                            ->default(false),

                        Forms\Components\Toggle::make('is_encrypted')
                            ->label('مشفر')
                            ->helperText('هل يجب تشفير هذه القيمة؟ (للبيانات الحساسة)')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('المفتاح')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('تم نسخ المفتاح')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('label')
                    ->label('التسمية')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->limit(40)
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_encrypted) {
                            return '••••••••••';
                        }
                        if ($record->type === 'boolean') {
                            return $state ? '✓ نعم' : '✗ لا';
                        }
                        if ($record->type === 'json') {
                            return 'JSON Data';
                        }
                        if ($record->type === 'file') {
                            return '📁 ' . basename($state ?? '');
                        }
                        return $state;
                    }),

                Tables\Columns\BadgeColumn::make('group')
                    ->label('المجموعة')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'payment',
                        'warning' => 'email',
                        'danger' => 'api',
                        'info' => 'app',
                        'secondary' => 'social',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'general' => 'عام',
                            'payment' => 'دفع',
                            'email' => 'بريد',
                            'api' => 'API',
                            'app' => 'تطبيق',
                            'social' => 'تواصل',
                            default => $state,
                        };
                    }),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('النوع')
                    ->colors([
                        'secondary' => 'string',
                        'info' => 'number',
                        'success' => 'boolean',
                        'warning' => 'json',
                        'danger' => 'file',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'string' => 'نص',
                            'number' => 'رقم',
                            'boolean' => 'منطقي',
                            'json' => 'JSON',
                            'file' => 'ملف',
                            'url' => 'رابط',
                            'email' => 'بريد',
                            default => $state,
                        };
                    }),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('عام')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('is_encrypted')
                    ->label('مشفر')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('warning')
                    ->falseColor('secondary'),

                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('المجموعة')
                    ->options([
                        'general' => 'عام',
                        'payment' => 'الدفع',
                        'email' => 'البريد الإلكتروني',
                        'api' => 'مفاتيح API',
                        'app' => 'التطبيق',
                        'social' => 'وسائل التواصل',
                    ]),

                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع البيانات')
                    ->options([
                        'string' => 'نص',
                        'number' => 'رقم',
                        'boolean' => 'نعم/لا',
                        'json' => 'JSON',
                        'file' => 'ملف',
                    ]),

                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('عام')
                    ->placeholder('الكل')
                    ->trueLabel('عام فقط')
                    ->falseLabel('خاص فقط'),

                Tables\Filters\TernaryFilter::make('is_encrypted')
                    ->label('مشفر')
                    ->placeholder('الكل')
                    ->trueLabel('مشفر فقط')
                    ->falseLabel('غير مشفر فقط'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('order', 'asc')
            ->emptyStateHeading('لا توجد إعدادات')
            ->emptyStateDescription('ابدأ بإضافة إعداد جديد')
            ->emptyStateIcon('heroicon-o-cog-6-tooth');
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
            'index' => Pages\ListAppSettings::route('/'),
            'create' => Pages\CreateAppSetting::route('/create'),
            'view' => Pages\ViewAppSetting::route('/{record}'),
            'edit' => Pages\EditAppSetting::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'المستخدمون';

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمون';

    protected static ?string $navigationGroup = 'إدارة المستخدمين';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText('اتركها فارغة إذا كنت لا تريد تغييرها'),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('الصورة الشخصية')
                            ->image()
                            ->directory('users/avatars')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('preferred_language')
                            ->label('اللغة المفضلة')
                            ->options([
                                'ar' => 'العربية',
                                'en' => 'English',
                            ])
                            ->default('ar')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('الصلاحيات والاشتراكات')
                    ->schema([
                        Forms\Components\Toggle::make('is_admin')
                            ->label('مدير (Admin)')
                            ->helperText('يمكنه الوصول إلى لوحة التحكم')
                            ->inline(false),

                        Forms\Components\Toggle::make('is_premium')
                            ->label('اشتراك Premium')
                            ->helperText('يمكنه مشاهدة المحتوى المميز')
                            ->inline(false)
                            ->live(),

                        Forms\Components\DateTimePicker::make('subscription_ends_at')
                            ->label('تاريخ انتهاء الاشتراك')
                            ->visible(fn (Forms\Get $get) => $get('is_premium'))
                            ->minDate(now())
                            ->helperText('اختر تاريخ انتهاء اشتراك Premium'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('الصورة')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->toggleable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('مدير')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('danger')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_premium')
                    ->label('Premium')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('subscription_ends_at')
                    ->label('انتهاء الاشتراك')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable()
                    ->color(fn ($state) => $state && $state->isPast() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('preferred_language')
                    ->label('اللغة')
                    ->formatStateUsing(fn ($state) => $state === 'ar' ? '🇸🇦 عربي' : '🇺🇸 English')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('تاريخ التحقق')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_admin')
                    ->label('المديرون')
                    ->placeholder('الكل')
                    ->trueLabel('المديرون فقط')
                    ->falseLabel('المستخدمون العاديون'),

                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label('Premium')
                    ->placeholder('الكل')
                    ->trueLabel('Premium فقط')
                    ->falseLabel('عادي فقط'),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('التحقق من البريد')
                    ->placeholder('الكل')
                    ->trueLabel('محقق')
                    ->falseLabel('غير محقق')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                    ),

                Tables\Filters\Filter::make('subscription_active')
                    ->label('الاشتراك نشط')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('is_premium', true)
                        ->where('subscription_ends_at', '>', now())
                    ),

                Tables\Filters\Filter::make('subscription_expired')
                    ->label('الاشتراك منتهي')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('is_premium', true)
                        ->where('subscription_ends_at', '<', now())
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->before(function (User $record) {
                        if ($record->is_admin && User::where('is_admin', true)->count() === 1) {
                            throw new \Exception('لا يمكن حذف آخر مدير في النظام!');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}

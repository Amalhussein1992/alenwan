<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.configuration');
    }

    public static function getNavigationLabel(): string
    {
        return 'الإعدادات';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')->schema([
                    Forms\Components\TextInput::make('key')
                        ->label('المفتاح')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('معرف فريد للإعداد (مثل: app_name, primary_color)')
                        ->placeholder('app_name'),

                    Forms\Components\Select::make('group')
                        ->label('المجموعة')
                        ->required()
                        ->options([
                            'general' => 'عام',
                            'app' => 'إعدادات التطبيق',
                            'payment' => 'الدفع',
                            'notification' => 'الإشعارات',
                            'social' => 'وسائل التواصل',
                            'theme' => 'المظهر',
                        ])
                        ->default('general'),

                    Forms\Components\Select::make('type')
                        ->label('النوع')
                        ->required()
                        ->options([
                            'text' => 'نص',
                            'textarea' => 'نص طويل',
                            'number' => 'رقم',
                            'boolean' => 'نعم/لا',
                            'image' => 'صورة',
                            'color' => 'لون',
                            'json' => 'JSON',
                        ])
                        ->default('text')
                        ->reactive(),

                    Forms\Components\TextInput::make('order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0)
                        ->helperText('ترتيب العرض'),
                ])->columns(2),

                Forms\Components\Section::make('التسميات')->schema([
                    Forms\Components\TextInput::make('label.ar')
                        ->label('العنوان (عربي)')
                        ->maxLength(255)
                        ->placeholder('اسم التطبيق'),

                    Forms\Components\TextInput::make('label.en')
                        ->label('العنوان (إنجليزي)')
                        ->maxLength(255)
                        ->placeholder('App Name'),

                    Forms\Components\Textarea::make('description.ar')
                        ->label('الوصف (عربي)')
                        ->rows(2)
                        ->placeholder('وصف الإعداد بالعربية'),

                    Forms\Components\Textarea::make('description.en')
                        ->label('الوصف (إنجليزي)')
                        ->rows(2)
                        ->placeholder('Setting description in English'),
                ])->columns(2),

                Forms\Components\Section::make('القيمة')->schema([
                    Forms\Components\Textarea::make('value')
                        ->label('قيمة الإعداد')
                        ->required()
                        ->rows(3)
                        ->helperText('أدخل القيمة لهذا الإعداد')
                        ->placeholder('القيمة...'),
                ]),
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
                    ->icon('heroicon-o-key')
                    ->iconColor('primary')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('label.ar')
                    ->label('العنوان')
                    ->searchable()
                    ->default(fn($record) => $record->label['en'] ?? $record->key)
                    ->limit(30),

                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->limit(40)
                    ->searchable()
                    ->tooltip(fn ($state) => strlen($state) > 40 ? $state : null)
                    ->copyable(),

                Tables\Columns\TextColumn::make('group')
                    ->label('المجموعة')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'general' => 'عام',
                        'app' => 'التطبيق',
                        'payment' => 'الدفع',
                        'notification' => 'الإشعارات',
                        'social' => 'التواصل',
                        'theme' => 'المظهر',
                        default => $state,
                    })
                    ->color(fn ($state) => match($state) {
                        'general' => 'gray',
                        'app' => 'success',
                        'payment' => 'warning',
                        'notification' => 'danger',
                        'social' => 'info',
                        'theme' => 'primary',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'text' => 'نص',
                        'textarea' => 'نص طويل',
                        'number' => 'رقم',
                        'boolean' => 'نعم/لا',
                        'image' => 'صورة',
                        'color' => 'لون',
                        'json' => 'JSON',
                        default => $state,
                    })
                    ->color(fn ($state) => match($state) {
                        'text' => 'gray',
                        'textarea' => 'gray',
                        'number' => 'warning',
                        'boolean' => 'success',
                        'image' => 'danger',
                        'color' => 'primary',
                        'json' => 'info',
                        default => 'gray',
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('الترتيب')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('المجموعة')
                    ->options([
                        'general' => 'عام',
                        'app' => 'إعدادات التطبيق',
                        'payment' => 'الدفع',
                        'notification' => 'الإشعارات',
                        'social' => 'وسائل التواصل',
                        'theme' => 'المظهر',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'text' => 'نص',
                        'textarea' => 'نص طويل',
                        'number' => 'رقم',
                        'boolean' => 'نعم/لا',
                        'image' => 'صورة',
                        'color' => 'لون',
                        'json' => 'JSON',
                    ])
                    ->multiple(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\AppSettingResource\Pages;

use App\Filament\Resources\AppSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewAppSetting extends ViewRecord
{
    protected static string $resource = AppSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('تعديل'),
            Actions\DeleteAction::make()
                ->label('حذف'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Infolists\Components\TextEntry::make('key')
                            ->label('المفتاح')
                            ->copyable()
                            ->icon('heroicon-o-key')
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('group')
                            ->label('المجموعة')
                            ->badge()
                            ->color(fn ($state) => match($state) {
                                'general' => 'primary',
                                'payment' => 'success',
                                'email' => 'warning',
                                'api' => 'danger',
                                'app' => 'info',
                                'social' => 'secondary',
                                default => 'gray',
                            })
                            ->formatStateUsing(function ($state) {
                                return match($state) {
                                    'general' => 'عام',
                                    'payment' => 'الدفع',
                                    'email' => 'البريد الإلكتروني',
                                    'api' => 'مفاتيح API',
                                    'app' => 'التطبيق',
                                    'social' => 'وسائل التواصل',
                                    default => $state,
                                };
                            }),

                        Infolists\Components\TextEntry::make('type')
                            ->label('نوع البيانات')
                            ->badge()
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

                        Infolists\Components\TextEntry::make('order')
                            ->label('الترتيب')
                            ->icon('heroicon-o-arrows-up-down'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('القيمة')
                    ->schema([
                        Infolists\Components\TextEntry::make('value')
                            ->label('القيمة')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record->is_encrypted) {
                                    return '••••••••••••••••';
                                }
                                if ($record->type === 'boolean') {
                                    return $state ? '✓ نعم' : '✗ لا';
                                }
                                if ($record->type === 'json') {
                                    return json_encode(json_decode($state), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }
                                return $state;
                            })
                            ->copyable(fn ($record) => !$record->is_encrypted)
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('التسميات والأوصاف')
                    ->schema([
                        Infolists\Components\TextEntry::make('label.ar')
                            ->label('التسمية (عربي)'),

                        Infolists\Components\TextEntry::make('label.en')
                            ->label('التسمية (English)'),

                        Infolists\Components\TextEntry::make('description.ar')
                            ->label('الوصف (عربي)')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('description.en')
                            ->label('الوصف (English)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Infolists\Components\Section::make('الخيارات')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_public')
                            ->label('عام (API)')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        Infolists\Components\IconEntry::make('is_encrypted')
                            ->label('مشفر')
                            ->boolean()
                            ->trueIcon('heroicon-o-lock-closed')
                            ->falseIcon('heroicon-o-lock-open')
                            ->trueColor('warning')
                            ->falseColor('secondary'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('معلومات النظام')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('تاريخ الإنشاء')
                            ->dateTime('Y-m-d H:i:s')
                            ->icon('heroicon-o-calendar'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('آخر تحديث')
                            ->dateTime('Y-m-d H:i:s')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

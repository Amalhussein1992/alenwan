<?php

namespace App\Filament\Resources\AppSettingResource\Pages;

use App\Filament\Resources\AppSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAppSettings extends ListRecords
{
    protected static string $resource = AppSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('إضافة إعداد جديد')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل')
                ->badge(fn () => \App\Models\AppSetting::count()),

            'general' => Tab::make('الإعدادات العامة')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'general'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'general')->count())
                ->badgeColor('primary'),

            'payment' => Tab::make('بوابات الدفع')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'payment'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'payment')->count())
                ->badgeColor('success'),

            'email' => Tab::make('البريد الإلكتروني')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'email'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'email')->count())
                ->badgeColor('warning'),

            'api' => Tab::make('مفاتيح API')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'api'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'api')->count())
                ->badgeColor('danger'),

            'app' => Tab::make('التطبيق')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'app'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'app')->count())
                ->badgeColor('info'),

            'social' => Tab::make('وسائل التواصل')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'social'))
                ->badge(fn () => \App\Models\AppSetting::where('group', 'social')->count())
                ->badgeColor('secondary'),

            'encrypted' => Tab::make('المشفرة')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_encrypted', true))
                ->badge(fn () => \App\Models\AppSetting::where('is_encrypted', true)->count())
                ->icon('heroicon-o-lock-closed'),

            'public' => Tab::make('العامة')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_public', true))
                ->badge(fn () => \App\Models\AppSetting::where('is_public', true)->count())
                ->icon('heroicon-o-globe-alt'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // يمكن إضافة Widgets هنا لاحقاً
        ];
    }
}

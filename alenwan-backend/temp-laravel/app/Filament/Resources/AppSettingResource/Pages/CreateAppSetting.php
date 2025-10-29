<?php

namespace App\Filament\Resources\AppSettingResource\Pages;

use App\Filament\Resources\AppSettingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAppSetting extends CreateRecord
{
    protected static string $resource = AppSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم إنشاء الإعداد بنجاح')
            ->body('تم إضافة الإعداد الجديد إلى النظام');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // تحويل القيمة المنطقية إلى نص للحفظ في قاعدة البيانات
        if ($data['type'] === 'boolean') {
            $data['value'] = $data['value'] ? '1' : '0';
        }

        // تحويل JSON إلى نص
        if ($data['type'] === 'json' && is_array($data['value'])) {
            $data['value'] = json_encode($data['value']);
        }

        return $data;
    }
}

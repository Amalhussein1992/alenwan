<?php

namespace App\Filament\Resources\AppSettingResource\Pages;

use App\Filament\Resources\AppSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAppSetting extends EditRecord
{
    protected static string $resource = AppSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('عرض'),
            Actions\DeleteAction::make()
                ->label('حذف'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('تم تحديث الإعداد بنجاح')
            ->body('تم حفظ التغييرات في الإعداد');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // تحويل القيمة المنطقية من نص إلى boolean للعرض
        if ($data['type'] === 'boolean') {
            $data['value'] = (bool)$data['value'];
        }

        // تحويل JSON من نص إلى array للعرض
        if ($data['type'] === 'json' && is_string($data['value'])) {
            $decoded = json_decode($data['value'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['value'] = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // تحويل القيمة المنطقية إلى نص للحفظ
        if ($data['type'] === 'boolean') {
            $data['value'] = $data['value'] ? '1' : '0';
        }

        // التحقق من صحة JSON قبل الحفظ
        if ($data['type'] === 'json' && is_string($data['value'])) {
            $decoded = json_decode($data['value'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Notification::make()
                    ->danger()
                    ->title('خطأ في صيغة JSON')
                    ->body('الرجاء التأكد من صحة صيغة JSON')
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }

        return $data;
    }
}

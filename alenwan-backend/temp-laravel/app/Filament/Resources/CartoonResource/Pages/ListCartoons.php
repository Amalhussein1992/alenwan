<?php

namespace App\Filament\Resources\CartoonResource\Pages;

use App\Filament\Resources\CartoonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCartoons extends ListRecords
{
    protected static string $resource = CartoonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

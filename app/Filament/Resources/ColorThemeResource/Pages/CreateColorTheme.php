<?php

namespace App\Filament\Resources\ColorThemeResource\Pages;

use App\Filament\Resources\ColorThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateColorTheme extends CreateRecord
{
    protected static string $resource = ColorThemeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['updated_by_user_id'] = auth()->id();
        $data['created_by_user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

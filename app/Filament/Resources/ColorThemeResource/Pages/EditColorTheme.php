<?php

namespace App\Filament\Resources\ColorThemeResource\Pages;

use App\Filament\Resources\ColorThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditColorTheme extends EditRecord
{
    protected static string $resource = ColorThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by_user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

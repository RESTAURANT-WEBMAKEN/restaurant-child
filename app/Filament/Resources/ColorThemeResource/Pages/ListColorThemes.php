<?php

namespace App\Filament\Resources\ColorThemeResource\Pages;

use App\Filament\Resources\ColorThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListColorThemes extends ListRecords
{
    protected static string $resource = ColorThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

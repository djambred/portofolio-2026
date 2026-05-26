<?php

namespace App\Filament\Admin\Resources\CareerHighlightResource\Pages;

use App\Filament\Admin\Resources\CareerHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerHighlights extends ListRecords
{
    protected static string $resource = CareerHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

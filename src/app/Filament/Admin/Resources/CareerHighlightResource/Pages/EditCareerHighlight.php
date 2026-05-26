<?php

namespace App\Filament\Admin\Resources\CareerHighlightResource\Pages;

use App\Filament\Admin\Resources\CareerHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerHighlight extends EditRecord
{
    protected static string $resource = CareerHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

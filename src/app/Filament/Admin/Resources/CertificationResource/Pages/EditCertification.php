<?php

namespace App\Filament\Admin\Resources\CertificationResource\Pages;

use App\Filament\Admin\Resources\CertificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertification extends EditRecord
{
    protected static string $resource = CertificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

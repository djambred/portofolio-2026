<?php

namespace App\Filament\Admin\Resources\SocialLinkResource\Pages;

use App\Filament\Admin\Resources\SocialLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialLink extends EditRecord
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

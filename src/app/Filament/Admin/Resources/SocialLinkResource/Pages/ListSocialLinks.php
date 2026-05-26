<?php

namespace App\Filament\Admin\Resources\SocialLinkResource\Pages;

use App\Filament\Admin\Resources\SocialLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialLinks extends ListRecords
{
    protected static string $resource = SocialLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Admin\Resources\PublicationResource\Pages;

use App\Filament\Admin\Resources\PublicationResource;
use App\Models\Profile;
use Filament\Forms;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListPublications extends ListRecords
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        $defaultProfileId = Profile::query()
            ->orderByRaw("CASE WHEN cv_status = 'published' THEN 0 ELSE 1 END")
            ->value('id');

        return [
            Actions\Action::make('importSintaOutputs')
                ->label('Import SINTA')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->form([
                    Forms\Components\TextInput::make('sinta_id')
                        ->label('SINTA Author ID')
                        ->required()
                        ->default('6758820')
                        ->maxLength(20),
                    Forms\Components\Select::make('profile_id')
                        ->label('Profile Target')
                        ->options(Profile::query()->orderBy('full_name')->pluck('full_name', 'id'))
                        ->required()
                        ->searchable()
                        ->default($defaultProfileId),
                    Forms\Components\TextInput::make('username')
                        ->label('SINTA Username (optional)')
                        ->email(),
                    Forms\Components\TextInput::make('password')
                        ->label('SINTA Password (optional)')
                        ->password()
                        ->revealable(),
                ])
                ->action(function (array $data): void {
                    @set_time_limit(300);

                    $params = [
                        'sintaId' => $data['sinta_id'],
                        '--profile-id' => $data['profile_id'],
                    ];

                    if (! empty($data['username']) && ! empty($data['password'])) {
                        $params['--username'] = $data['username'];
                        $params['--password'] = $data['password'];
                    }

                    try {
                        Artisan::call('sinta:import-outputs', $params);
                        $commandOutput = trim(Artisan::output());

                        $summary = 'Data publikasi berhasil diproses.';
                        if (preg_match('/Done\.\s*Imported:\s*\d+,\s*Updated:\s*\d+/i', $commandOutput, $match) === 1) {
                            $summary = $match[0];
                        }

                        Notification::make()
                            ->title('Import SINTA selesai')
                            ->body($summary)
                            ->success()
                            ->send();

                        $this->resetTable();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import SINTA gagal')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Actions\CreateAction::make(),
        ];
    }
}

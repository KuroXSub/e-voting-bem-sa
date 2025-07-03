<?php

namespace App\Filament\Resources\ElectionPeriodResource\Pages;

use App\Filament\Resources\ElectionPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElectionPeriod extends EditRecord
{
    protected static string $resource = ElectionPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

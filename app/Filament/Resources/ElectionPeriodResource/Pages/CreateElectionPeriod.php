<?php

namespace App\Filament\Resources\ElectionPeriodResource\Pages;

use App\Filament\Resources\ElectionPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateElectionPeriod extends CreateRecord
{
    protected static string $resource = ElectionPeriodResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

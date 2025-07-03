<?php

namespace App\Filament\Resources\ElectionPeriodResource\Pages;

use App\Filament\Resources\ElectionPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElectionPeriods extends ListRecords
{
    protected static string $resource = ElectionPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

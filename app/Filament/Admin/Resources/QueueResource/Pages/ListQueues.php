<?php

namespace App\Filament\Admin\Resources\QueueResource\Pages;

use App\Filament\Admin\Resources\QueueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQueues extends ListRecords
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

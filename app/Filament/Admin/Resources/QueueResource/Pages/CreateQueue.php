<?php

namespace App\Filament\Admin\Resources\QueueResource\Pages;

use App\Filament\Admin\Resources\QueueResource;
use Filament\Actions;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreateQueue extends CreateRecord
{
    protected static string $resource = QueueResource::class;

    public function form(Form $form): Form {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Queue Name'),
            Forms\Components\Select::make('room_id')
                ->relationship('room', 'name')
                ->required()
                ->label('Room'),
            Forms\Components\Select::make('user_id')
                ->relationship('creator', 'username')
                ->required()
                ->label('Creator')
                ->columnSpanFull(),
        ]);
    }
}

<?php

namespace App\Filament\Admin\Resources\QueueResource\Pages;

use App\Filament\Admin\Resources\QueueResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use App\Domain\Room\Entities\Room;
use Filament\Resources\Pages\EditRecord;

class EditQueue extends EditRecord
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

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
            Forms\Components\Repeater::make('queueUsers')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'username')
                    ->searchable()
                    ->required()
                ])
                ->orderColumn('position')->columnSpanFull()
        ]);
    }

}

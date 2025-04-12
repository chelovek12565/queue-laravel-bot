<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QueueResource\Pages;
use App\Domain\Queue\Entities\Queue;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Base\Models\Model;
use App\Domain\User\Domain\Entities\User;
use Illuminate\Support\Facades\Log;


class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Queue Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Room')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.username')
                    ->label('Creator')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQueues::route('/'),
            'create' => Pages\CreateQueue::route('/create'),
            'edit' => Pages\EditQueue::route('/{record}/edit'),
        ];
    }
}

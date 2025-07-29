<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RoomResource\Pages;
use App\Filament\Admin\Resources\RoomResource\RelationManagers;
use App\Domain\Room\Entities\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Room Name'),
                Forms\Components\TextInput::make('description')
                    ->label('Description'),
                Forms\Components\Select::make('user_id')
                    ->relationship('creator', 'username')
                    ->required()
                    ->label('Creator'),
                Forms\Components\Select::make('users')
                    ->multiple()
                    ->relationship('users', 'username')
                    ->label('Users'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Room Name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('creator.username')
                ->label('Creator')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('users_count')
                ->label('Number of Users')
                ->counts('users')
                ->sortable(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}

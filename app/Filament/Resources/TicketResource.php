<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\CategoriesRelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\Select::make('status')
                //     ->options(self::$model::STATUS)
                //     ->default('open')
                //     ->required(),
                Forms\Components\Select::make('priority')
                    ->options(self::$model::PRIORITY)
                    ->default('open')
                    ->required(),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Comment')
                    ->nullable(),
                // Forms\Components\Select::make('assigned_by')
                //     ->relationship('assignedBy', 'name')
                //     ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->description(fn (Ticket $record): string => $record->description)
                    // ->url(fn (Ticket $record): string => route('filament.resources.tickets.edit', $record))
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('priority')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Low' => 'success',
                    'Medium' => 'warning',
                    'High' => 'danger',
                })
                    ->sortable()
                    ->searchable(),
                
                    // ->enum(Ticket::PRIORITY),
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Open' => 'success',
                    'Archived' => 'warning',
                    'Resolved' => 'info',
                    'Closed' => 'danger',
                })
                    ->sortable()
                    ->searchable(),
                    // ->enum(Ticket::STATUS),
                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('assignedBy.name')
                    ->label('Assigned By')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('comment')
                    ->label('Comment')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}

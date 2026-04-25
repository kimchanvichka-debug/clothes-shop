<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product; // This line is the fix!
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->required()
                    ->reactive() 
                    ->afterStateUpdated(fn ($state, callable $set) => $set('price', Product::find($state)?->price ?? 0)),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->label('Unit Price')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('USD'),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->state(fn ($record): float => $record->quantity * $record->price)
                    ->money('USD')
                    ->color('success')
                    ->weight('bold'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Item')
                    ->icon('heroicon-m-plus'),
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
}
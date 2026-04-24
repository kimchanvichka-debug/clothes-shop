<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

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
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                // This shows the actual name of the product (Crop Top, etc.)
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price at Sale')
                    ->money('USD'),

                // This calculates Total = Price x Quantity
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->state(fn ($record): float => $record->quantity * $record->price)
                    ->money('USD'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Usually you don't manually create items here, 
                // but keeping it in case you need to fix an order
                Tables\Actions\CreateAction::make(),
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
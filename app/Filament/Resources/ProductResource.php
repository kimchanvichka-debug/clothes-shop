<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Details')
                    ->description('Fill in the information to display the item in the shop.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        Select::make('category')
                            ->options([
                                'Crop Top' => 'Crop Top (អាវខើច)',
                                'Boxy Fit Tee' => 'Boxy Fit Tee (អាវយឺតធំ)',
                                'Dress' => 'Dress (រ៉ូប)',
                                'Baggy Pants' => 'Baggy Pants (ខោបាវ)',
                                'Bikini' => 'Bikini (ឈុតហែលទឹក)',
                                'Sets' => 'Sets (ឈុត)',
                            ])
                            ->required()
                            ->native(false),

                        FileUpload::make('image')
                            ->image()
                            ->directory('products')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->disk('public') 
                    ->visibility('public')
                    ->square() 
                    ->size(80) 
                    ->grow(false),
                
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('category')
                    ->badge()
                    ->color('warning'), 

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->contentGrid([
                'md' => null,
                'sm' => 1,
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Crop Top' => 'Crop Top',
                        'Boxy Fit Tee' => 'Boxy Fit Tee',
                        'Dress' => 'Dress',
                        'Baggy Pants' => 'Baggy Pants',
                        'Bikini' => 'Bikini',
                        'Sets' => 'Sets',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button() 
                    ->color('info'),
                
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
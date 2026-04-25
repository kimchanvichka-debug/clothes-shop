<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    // This ensures that after creating a product, you go back to the list
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
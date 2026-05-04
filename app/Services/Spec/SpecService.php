<?php

namespace App\Services\Spec;

use App\Models\ProductType;
use App\Models\SpecDimension;
use App\Models\SpecOption;

class SpecService
{
    public function allDimensions(): \Illuminate\Database\Eloquent\Collection
    {
        return SpecDimension::with('options')->orderBy('sort_order')->get();
    }

    public function specsForProduct(int $productTypeId): array
    {
        $product = ProductType::with([
            'specDimensions.options' => fn ($q) => $q->orderBy('sort_order'),
        ])->findOrFail($productTypeId);

        return [
            'product' => $product,
            'dimensions' => $product->specDimensions->map(fn ($dim) => [
                'id'          => $dim->id,
                'name'        => $dim->name,
                'slug'        => $dim->slug,
                'is_required' => $dim->pivot->is_required,
                'options'     => $dim->options->map(fn ($opt) => [
                    'id'          => $opt->id,
                    'label'       => $opt->label,
                    'price_addon' => $opt->price_addon,
                ]),
            ]),
        ];
    }

    public function createDimension(array $data): SpecDimension
    {
        return SpecDimension::create($data);
    }

    public function createOption(array $data): SpecOption
    {
        return SpecOption::create($data);
    }

    public function createProductType(array $data, array $dimensionIds): ProductType
    {
        $product = ProductType::create($data);
        $syncData = collect($dimensionIds)->mapWithKeys(fn ($id, $index) => [
            $id => ['is_required' => true, 'sort_order' => $index],
        ])->toArray();
        $product->specDimensions()->sync($syncData);
        return $product;
    }
}

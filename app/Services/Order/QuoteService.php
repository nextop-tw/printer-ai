<?php

namespace App\Services\Order;

use App\Models\ProductBasePrice;
use App\Models\QuantityDiscount;
use App\Models\SpecOption;

class QuoteService
{
    public function calculate(int $productTypeId, array $specOptionIds, int $quantity): array
    {
        $mainOptionIds = $this->mainOptionIds($specOptionIds);
        $addonOptionIds = $this->addonOptionIds($specOptionIds, $mainOptionIds);

        $basePrice = $this->findBasePrice($productTypeId, $mainOptionIds);
        $addonTotal = $this->sumAddons($addonOptionIds);
        $discountRate = QuantityDiscount::rateFor($quantity);

        $unitPrice = $basePrice + $addonTotal;
        $total = round($unitPrice * $quantity * $discountRate, 0);

        return [
            'base_price'    => $basePrice,
            'addon_total'   => $addonTotal,
            'unit_price'    => $unitPrice,
            'quantity'      => $quantity,
            'discount_rate' => $discountRate,
            'total_price'   => $total,
        ];
    }

    private function findBasePrice(int $productTypeId, array $mainOptionIds): float
    {
        sort($mainOptionIds);

        $price = ProductBasePrice::where('product_type_id', $productTypeId)
            ->get()
            ->first(function ($row) use ($mainOptionIds) {
                $ids = $row->spec_option_ids;
                sort($ids);
                return $ids === $mainOptionIds;
            });

        return $price ? (float) $price->base_price : 0.0;
    }

    private function sumAddons(array $addonOptionIds): float
    {
        if (empty($addonOptionIds)) {
            return 0.0;
        }
        return (float) SpecOption::whereIn('id', $addonOptionIds)->sum('price_addon');
    }

    private function mainOptionIds(array $allOptionIds): array
    {
        // 主規格選項：price_addon = 0
        return SpecOption::whereIn('id', $allOptionIds)
            ->where('price_addon', 0)
            ->pluck('id')
            ->toArray();
    }

    private function addonOptionIds(array $allOptionIds, array $mainOptionIds): array
    {
        return array_values(array_diff($allOptionIds, $mainOptionIds));
    }
}

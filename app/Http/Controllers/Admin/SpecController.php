<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBasePrice;
use App\Models\ProductType;
use App\Models\QuantityDiscount;
use App\Models\SpecDimension;
use App\Models\SpecOption;
use App\Services\Spec\SpecService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecController extends Controller
{
    public function __construct(private SpecService $specService) {}

    // 規格維度
    public function dimensionIndex()
    {
        $dimensions = SpecDimension::with('options')->orderBy('sort_order')->get();
        return view('admin.specs.dimensions', compact('dimensions'));
    }

    public function dimensionStore(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);
        $validated['slug'] = Str::slug($validated['name'], '_') . '_' . time();
        SpecDimension::create($validated);
        return back()->with('success', '規格維度已新增');
    }

    // 規格選項
    public function optionStore(Request $request)
    {
        $validated = $request->validate([
            'spec_dimension_id' => 'required|exists:spec_dimensions,id',
            'label'             => 'required|string|max:50',
            'price_addon'       => 'required|numeric|min:0',
            'sort_order'        => 'nullable|integer',
        ]);
        SpecOption::create($validated);
        return back()->with('success', '規格選項已新增');
    }

    // 產品類型
    public function productIndex()
    {
        $products   = ProductType::with('specDimensions')->get();
        $dimensions = SpecDimension::orderBy('sort_order')->get();
        return view('admin.specs.products', compact('products', 'dimensions'));
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:50',
            'dimension_ids' => 'required|array|min:1',
            'dimension_ids.*' => 'exists:spec_dimensions,id',
        ]);
        $validated['slug'] = Str::slug($validated['name'], '_') . '_' . time();
        $this->specService->createProductType(
            ['name' => $validated['name'], 'slug' => $validated['slug'], 'is_active' => true],
            $validated['dimension_ids']
        );
        return back()->with('success', '產品類型已新增');
    }

    // 基本價
    public function priceIndex()
    {
        $products   = ProductType::with('basePrices')->get();
        $discounts  = QuantityDiscount::orderBy('min_quantity')->get();
        return view('admin.specs.prices', compact('products', 'discounts'));
    }

    public function priceStore(Request $request)
    {
        $validated = $request->validate([
            'product_type_id' => 'required|exists:product_types,id',
            'spec_option_ids' => 'required|array|min:1',
            'spec_option_ids.*' => 'exists:spec_options,id',
            'base_price'      => 'required|numeric|min:0',
        ]);
        ProductBasePrice::create($validated);
        return back()->with('success', '基本價已設定');
    }

    // 數量折扣
    public function discountStore(Request $request)
    {
        $validated = $request->validate([
            'min_quantity'  => 'required|integer|min:1',
            'discount_rate' => 'required|numeric|between:0.01,1',
        ]);
        QuantityDiscount::updateOrCreate(
            ['min_quantity' => $validated['min_quantity']],
            ['discount_rate' => $validated['discount_rate']]
        );
        return back()->with('success', '折扣設定已儲存');
    }
}

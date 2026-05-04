<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Services\Order\QuoteService;
use App\Services\Spec\SpecService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(
        private SpecService $specService,
        private QuoteService $quoteService,
    ) {}

    public function index()
    {
        $products = ProductType::where('is_active', true)->get(['id', 'name', 'slug']);
        return $this->success($products);
    }

    public function specs(int $id)
    {
        $data = $this->specService->specsForProduct($id);
        return $this->success($data);
    }

    public function quote(Request $request)
    {
        $validated = $request->validate([
            'product_type_id' => 'required|integer|exists:product_types,id',
            'spec_option_ids' => 'required|array|min:1',
            'spec_option_ids.*' => 'integer|exists:spec_options,id',
            'quantity'        => 'required|integer|min:1',
        ]);

        $quote = $this->quoteService->calculate(
            $validated['product_type_id'],
            $validated['spec_option_ids'],
            $validated['quantity']
        );

        return $this->success($quote);
    }
}

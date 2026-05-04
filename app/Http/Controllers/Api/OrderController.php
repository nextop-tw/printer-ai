<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Services\Payment\NewebpayService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        private OrderService $orderService,
        private NewebpayService $newebpayService,
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'           => 'required|email',
            'name'            => 'nullable|string|max:50',
            'product_type_id' => 'required|integer|exists:product_types,id',
            'spec_option_ids' => 'required|array|min:1',
            'spec_option_ids.*' => 'integer|exists:spec_options,id',
            'quantity'        => 'required|integer|min:1',
            'file_path'       => 'required|string',
            'file_analysis'   => 'nullable|array',
        ]);

        $order = $this->orderService->createPending(
            $validated,
            $validated['file_path'],
            $validated['file_analysis'] ?? []
        );

        $paymentForm = $this->newebpayService->buildPaymentForm($order);

        return $this->success([
            'order_no'    => $order->order_no,
            'total_price' => $order->total_price,
            'payment'     => $paymentForm,
        ], '訂單建立成功，請完成付款');
    }

    public function show(string $orderNo)
    {
        $order = \App\Models\Order::with(['productType', 'printer'])
            ->where('order_no', $orderNo)
            ->when(auth()->check(), fn ($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        return $this->success([
            'order_no'                  => $order->order_no,
            'status'                    => $order->status,
            'product'                   => $order->productType->name,
            'quantity'                  => $order->quantity,
            'total_price'               => $order->total_price,
            'estimated_completion_date' => $order->estimated_completion_date?->format('Y-m-d'),
            'paid_at'                   => $order->paid_at?->format('Y-m-d H:i'),
        ]);
    }
}

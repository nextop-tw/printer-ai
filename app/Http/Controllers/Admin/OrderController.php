<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Printer;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(Request $request)
    {
        $orders = Order::with(['user', 'productType', 'printer'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, fn ($q, $s) => $q->where('order_no', 'like', "%{$s}%"))
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'productType', 'printer', 'payment']);
        $availablePrinters = Printer::where('status', 'active')
            ->where('admin_suspended', false)
            ->get();

        return view('admin.orders.show', compact('order', 'availablePrinters'));
    }

    public function assign(Request $request, Order $order)
    {
        $request->validate([
            'printer_id' => 'required|exists:printers,id',
        ]);

        $this->orderService->assignPrinter($order, $request->printer_id);

        return back()->with('success', '已指派印刷廠並發送 LINE 通知');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:reviewing,printing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', '訂單狀態已更新');
    }

    public function file(Order $order)
    {
        abort_unless(Storage::exists($order->file_path), 404);
        return Storage::download($order->file_path);
    }
}

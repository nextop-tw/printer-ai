<?php

namespace App\Http\Controllers\Printer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrinterOrderController extends Controller
{
    public function index()
    {
        $printer = Auth::guard('printer')->user();
        $orders  = Order::with(['productType', 'user'])
            ->where('printer_id', $printer->id)
            ->latest()
            ->paginate(20);

        return view('printer.orders.index', compact('orders', 'printer'));
    }

    public function updateStatus(Request $request)
    {
        $printer = Auth::guard('printer')->user();

        $request->validate([
            'status'       => 'required|in:active,suspended',
            'working_days' => 'sometimes|integer|min:1|max:30',
        ]);

        $printer->update($request->only('status', 'working_days'));

        return back()->with('success', '設定已更新');
    }

    public function file(Order $order)
    {
        $printer = Auth::guard('printer')->user();
        abort_unless($order->printer_id === $printer->id, 403);
        abort_unless(Storage::exists($order->file_path), 404);
        return Storage::download($order->file_path);
    }
}

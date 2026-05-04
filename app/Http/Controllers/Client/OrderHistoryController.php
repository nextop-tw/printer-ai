<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('productType')
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }
}

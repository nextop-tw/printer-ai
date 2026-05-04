<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('productType')->latest()->get();

        $orderCount      = $orders->count();
        $processingCount = $orders->whereIn('status', ['assigned', 'printing'])->count();
        $completedCount  = $orders->where('status', 'completed')->count();
        $totalSpent      = $orders->whereNotIn('status', ['pending', 'cancelled'])->sum('total_price');
        $recentOrders    = $orders->take(5);

        return view('frontend.dashboard', compact(
            'orderCount', 'processingCount', 'completedCount', 'totalSpent', 'recentOrders'
        ));
    }

    public function upload()
    {
        return view('frontend.upload');
    }

    public function detect()
    {
        return view('frontend.detect');
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Auth::user()->update(['name' => $request->name]);
        return back()->with('success', '個人資料已更新');
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|min:8|confirmed',
        ]);
        Auth::user()->update(['password' => bcrypt($request->password)]);
        return back()->with('success', '密碼已更新');
    }
}

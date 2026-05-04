<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::latest()->paginate(20);
        return view('admin.printers.index', compact('printers'));
    }

    public function create()
    {
        return view('admin.printers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'contact_name' => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'required|email|unique:printers,email',
            'password'     => 'required|string|min:8',
            'line_user_id' => 'nullable|string|max:100',
            'working_days' => 'required|integer|min:1|max:30',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Printer::create($validated);

        return redirect()->route('admin.printers.index')->with('success', '印刷廠已建立');
    }

    public function edit(Printer $printer)
    {
        return view('admin.printers.edit', compact('printer'));
    }

    public function update(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'contact_name' => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'line_user_id' => 'nullable|string|max:100',
            'working_days' => 'required|integer|min:1|max:30',
        ]);

        $printer->update($validated);

        return back()->with('success', '印刷廠資料已更新');
    }

    public function suspend(Printer $printer)
    {
        $printer->update(['admin_suspended' => !$printer->admin_suspended]);
        $msg = $printer->admin_suspended ? '已強制暫停' : '已恢復接單';
        return back()->with('success', $msg);
    }
}

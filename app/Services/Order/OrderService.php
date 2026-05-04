<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Printer;
use App\Models\User;
use App\Services\Line\LineNotifyService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        private QuoteService $quoteService,
        private LineNotifyService $lineNotifyService,
    ) {}

    public function createPending(array $data, string $filePath, array $fileAnalysis): Order
    {
        $quote = $this->quoteService->calculate(
            $data['product_type_id'],
            $data['spec_option_ids'],
            $data['quantity']
        );

        return DB::transaction(function () use ($data, $filePath, $fileAnalysis, $quote) {
            $user = $this->findOrCreateUser($data['email'], $data['name'] ?? null);

            $order = Order::create([
                'user_id'         => $user->id,
                'product_type_id' => $data['product_type_id'],
                'order_no'        => $this->generateOrderNo(),
                'spec_snapshot'   => $data['spec_option_ids'],
                'unit_price'      => $quote['unit_price'],
                'quantity'        => $quote['quantity'],
                'discount_rate'   => $quote['discount_rate'],
                'total_price'     => $quote['total_price'],
                'file_path'       => $filePath,
                'file_analysis'   => $fileAnalysis,
                'status'          => 'pending',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $quote['total_price'],
                'status'   => 'pending',
            ]);

            return $order;
        });
    }

    public function markPaid(string $transactionId, string $orderNo, array $rawResponse): Order
    {
        return DB::transaction(function () use ($transactionId, $orderNo, $rawResponse) {
            $order = Order::where('order_no', $orderNo)->firstOrFail();

            $order->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $order->payment->update([
                'transaction_id' => $transactionId,
                'status'         => 'success',
                'raw_response'   => $rawResponse,
            ]);

            $this->sendPasswordSetupEmail($order->user);

            return $order;
        });
    }

    public function assignPrinter(Order $order, int $printerId): Order
    {
        $printer = Printer::findOrFail($printerId);

        $estimatedDate = Carbon::today()->addWeekdays($printer->working_days);

        $order->update([
            'printer_id'                => $printerId,
            'status'                    => 'assigned',
            'estimated_completion_date' => $estimatedDate,
        ]);

        $this->lineNotifyService->notifyPrinter($order, $printer);

        return $order->fresh();
    }

    private function findOrCreateUser(string $email, ?string $name): User
    {
        return User::firstOrCreate(
            ['email' => $email],
            ['name' => $name ?? '用戶', 'password' => null]
        );
    }

    private function sendPasswordSetupEmail(User $user): void
    {
        if ($user->email_verified_at) {
            return;
        }
        // TODO: 發送設定密碼 email（使用 Laravel Password Reset token）
    }

    private function generateOrderNo(): string
    {
        return 'PR' . date('Ymd') . strtoupper(Str::random(6));
    }
}

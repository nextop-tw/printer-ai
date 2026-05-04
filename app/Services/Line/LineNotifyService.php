<?php

namespace App\Services\Line;

use App\Models\LineNotification;
use App\Models\Order;
use App\Models\Printer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LineNotifyService
{
    private string $channelAccessToken;
    private string $apiUrl = 'https://api.line.me/v2/bot/message/push';

    public function __construct()
    {
        $this->channelAccessToken = config('services.line.channel_access_token', '');
    }

    public function notifyPrinter(Order $order, Printer $printer): void
    {
        if (!$printer->line_user_id || !$this->channelAccessToken) {
            Log::warning("LINE 通知略過：印刷廠 {$printer->id} 未設定 LINE ID 或 Token 未設定");
            return;
        }

        $message = $this->buildMessage($order, $printer);
        $status = 'failed';

        try {
            $response = Http::withToken($this->channelAccessToken)
                ->post($this->apiUrl, [
                    'to'       => $printer->line_user_id,
                    'messages' => [['type' => 'text', 'text' => $message]],
                ]);

            $status = $response->successful() ? 'sent' : 'failed';

            if (!$response->successful()) {
                Log::error('LINE 通知失敗', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('LINE 通知例外', ['error' => $e->getMessage()]);
        }

        LineNotification::create([
            'order_id'   => $order->id,
            'printer_id' => $printer->id,
            'message'    => $message,
            'status'     => $status,
            'sent_at'    => now(),
        ]);
    }

    private function buildMessage(Order $order, Printer $printer): string
    {
        return implode("\n", [
            '【新訂單通知】',
            "訂單編號：{$order->order_no}",
            "產品：{$order->productType->name}",
            "數量：{$order->quantity}",
            "預計完成：{$order->estimated_completion_date?->format('Y-m-d')}",
            "圖檔：" . route('admin.orders.file', $order->id),
        ]);
    }
}

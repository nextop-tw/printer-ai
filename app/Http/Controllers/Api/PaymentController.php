<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Services\Payment\NewebpayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private NewebpayService $newebpayService,
        private OrderService $orderService,
    ) {}

    // 付款完成後，藍新金流非同步通知（POST）
    public function notify(Request $request)
    {
        $data = $request->all();

        if (!$this->newebpayService->verifyCallback($data)) {
            return response('FAIL', 400);
        }

        $tradeResult = $this->newebpayService->decryptCallback($data['TradeInfo']);

        if (($tradeResult['Status'] ?? '') === 'SUCCESS') {
            $this->orderService->markPaid(
                $tradeResult['TradeNo'],
                $tradeResult['MerchantOrderNo'],
                $tradeResult
            );
        }

        return response('OK');
    }

    // 付款完成後，瀏覽器跳轉回來（GET）
    public function return(Request $request)
    {
        $data = $request->all();

        if (!$this->newebpayService->verifyCallback($data)) {
            return redirect()->route('home')->with('error', '付款驗證失敗');
        }

        $tradeResult = $this->newebpayService->decryptCallback($data['TradeInfo']);
        $orderNo = $tradeResult['MerchantOrderNo'] ?? '';

        return redirect()->route('orders.show', $orderNo)
            ->with('success', '付款成功！');
    }
}

<?php

namespace App\Services\Payment;

use App\Models\Order;

class NewebpayService
{
    private string $merchantId;
    private string $hashKey;
    private string $hashIv;
    private bool $isSandbox;

    public function __construct()
    {
        $this->merchantId = config('services.newebpay.merchant_id', '');
        $this->hashKey    = config('services.newebpay.hash_key', '');
        $this->hashIv     = config('services.newebpay.hash_iv', '');
        $this->isSandbox  = config('services.newebpay.sandbox', true);
    }

    public function buildPaymentForm(Order $order): array
    {
        $tradeInfo = $this->encryptTradeInfo([
            'MerchantID'  => $this->merchantId,
            'RespondType' => 'JSON',
            'TimeStamp'   => time(),
            'Version'     => '2.0',
            'MerchantOrderNo' => $order->order_no,
            'Amt'         => (int) $order->total_price,
            'ItemDesc'    => $order->productType->name . ' x' . $order->quantity,
            'Email'       => $order->user->email,
            'ReturnURL'   => route('payment.return'),
            'NotifyURL'   => route('payment.notify'),
            'ClientBackURL' => route('orders.show', $order->order_no),
        ]);

        return [
            'action'      => $this->gatewayUrl(),
            'MerchantID'  => $this->merchantId,
            'TradeInfo'   => $tradeInfo,
            'TradeSha'    => $this->buildTradeSha($tradeInfo),
            'Version'     => '2.0',
        ];
    }

    public function verifyCallback(array $data): bool
    {
        $tradeInfo = $data['TradeInfo'] ?? '';
        $tradeSha  = $data['TradeSha'] ?? '';

        return $this->buildTradeSha($tradeInfo) === $tradeSha;
    }

    public function decryptCallback(string $tradeInfo): array
    {
        $decrypted = $this->aesDecrypt($tradeInfo);
        parse_str($decrypted, $result);
        return $result;
    }

    private function encryptTradeInfo(array $params): string
    {
        $query = http_build_query($params);
        return $this->aesEncrypt($query);
    }

    private function buildTradeSha(string $tradeInfo): string
    {
        $str = "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIv}";
        return strtoupper(hash('sha256', $str));
    }

    private function aesEncrypt(string $data): string
    {
        $encrypted = openssl_encrypt(
            $this->addPadding($data),
            'AES-256-CBC',
            $this->hashKey,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
            $this->hashIv
        );
        return bin2hex($encrypted);
    }

    private function aesDecrypt(string $data): string
    {
        $decrypted = openssl_decrypt(
            hex2bin($data),
            'AES-256-CBC',
            $this->hashKey,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
            $this->hashIv
        );
        return $this->stripPadding($decrypted);
    }

    private function addPadding(string $data): string
    {
        $blockSize = 32;
        $pad = $blockSize - (strlen($data) % $blockSize);
        return $data . str_repeat(chr($pad), $pad);
    }

    private function stripPadding(string $data): string
    {
        $pad = ord(substr($data, -1));
        return substr($data, 0, strlen($data) - $pad);
    }

    private function gatewayUrl(): string
    {
        return $this->isSandbox
            ? 'https://ccore.newebpay.com/MPG/mpg_gateway'
            : 'https://core.newebpay.com/MPG/mpg_gateway';
    }
}

# printer-ai

印刷媒合平台

## Remote

- GitHub: https://github.com/nextop-tw/printer-ai.git

## 技術棧

- Laravel 13 / PHP 8.4-fpm
- MySQL 8.0
- Nginx (Docker)
- Blade + Alpine.js + Tailwind CSS
- AdminLTE 3 (CDN) — 後台 UI

## 本地開發

```bash
docker compose up -d
```

- 前台：http://printer-ai.local:8081
- 後台：http://printer-ai.local:8081/admin/login
- MySQL port：3307

Windows hosts 需加：`127.0.0.1 printer-ai.local`

## 管理員預設帳號

- Email: admin@printer-ai.local
- 密碼: admin123456

## 認證系統

Triple Guard：`web`（用戶）/ `admin`（管理員）/ `printer`（印刷廠）

## 規格系統

Table A（spec_dimensions）+ Table B（spec_options）+ product_types pivot
疊加定價：base_price + sum(price_addon) × 數量折扣率

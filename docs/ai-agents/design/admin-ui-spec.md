# 印刷媒合平台 管理端 UI 規格

**版本：** v1.0
**最後更新：** 2026-05-04

---

## UI 套件決策

**套件：** AdminLTE 3（CDN 載入）
**理由：** 成熟穩定，Laravel 整合文件完整，無需額外 npm build

---

## 全域樣式設定

```html
<!-- CDN 載入清單 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js" defer></script>
```

**主題色：** AdminLTE 預設藍（`navbar-dark navbar-primary sidebar-dark-primary`）

---

## Layout 規格

```
AdminLTE 標準 wrapper：
- body.hold-transition.sidebar-mini.layout-fixed
- div.wrapper
  - nav.main-header（Topbar）
  - aside.main-sidebar（Sidebar）
  - div.content-wrapper（主內容）
  - footer.main-footer
```

---

## 頁面元件規格

### 訂單列表（`/admin/orders`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 頁面標題 | `.content-header` | 標題「訂單管理」+ 麵包屑 |
| 篩選列 | `<form>` + `<select>` + `<input>` | 水平排列，`<select>` 狀態篩選 + 搜尋框 |
| 資料表格 | `.table.table-bordered.table-striped` | 含 `<thead>` 固定欄位 |
| 分頁 | Laravel Paginate + `.pagination` | Bootstrap 分頁樣式 |
| 操作按鈕 | `.btn.btn-sm.btn-info` + icon | 查看：`fa-eye` |
| 狀態 badge | `.badge` | 各狀態對應顏色（見下表） |

**狀態顏色對照：**
| 狀態 | Badge Class |
|------|-------------|
| 待付款 | `badge-secondary` |
| 已付款 | `badge-warning` |
| 審核中 | `badge-info` |
| 已指派 | `badge-primary` |
| 生產中 | `badge-primary` |
| 已出貨 | `badge-success` |
| 完成 | `badge-success` |
| 取消 | `badge-danger` |

---

### 訂單詳情（`/admin/orders/{id}`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 頁面標題 | `.content-header` | 訂單號 + 返回按鈕 |
| 左欄（訂單資訊） | `.card` | 訂單基本資訊 + 圖檔分析結果 |
| 右欄（操作區） | `.card` | 指派印刷廠表單 + 狀態更新表單 |
| 指派表單 | `<select>` + `.btn.btn-primary` | 僅顯示接單中的廠商 |
| 狀態更新 | `<select>` + `.btn.btn-warning` | 允許狀態選項 |
| 下載按鈕 | `.btn.btn-secondary` | `fa-download` icon |
| 圖檔分析 | `.list-group` | DPI / 色彩 / 出血，有警告顯示 `badge-danger` |

---

### 印刷廠列表（`/admin/printers`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 新增按鈕 | `.btn.btn-primary` 左上角 | `fa-plus` + 「新增印刷廠」 |
| 資料表格 | `.table.table-bordered` | 廠商名 / 工作天 / 廠商狀態 / 管理員狀態 / 操作 |
| 暫停 Toggle | `.btn.btn-sm` | 接單中→`btn-danger fa-ban`，已暫停→`btn-success fa-check` |
| 編輯按鈕 | `.btn.btn-sm.btn-warning` | `fa-edit` |

---

### 印刷廠表單（新增/編輯）

| 欄位 | 元件 | 備註 |
|------|------|------|
| 廠商名稱 | `<input type="text">` | 必填 |
| 聯絡人 | `<input type="text">` | 選填 |
| 電話 | `<input type="tel">` | 選填 |
| Email | `<input type="email">` | 必填，unique |
| 密碼 | `<input type="password">` | 新增必填，編輯選填 |
| LINE User ID | `<input type="text">` | 選填，說明文字「廠商的 LINE userId」 |
| 工作天數 | `<input type="number" min="1" max="30">` | 必填 |
| 操作按鈕 | `.btn.btn-primary` sticky 底部 | 「儲存」 |

---

### 規格維度管理（`/admin/specs/dimensions`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 新增維度 | inline form（上方） | 名稱 + 排序 + 送出按鈕 |
| 維度列表 | `.card` 展開式 | 每個維度一個 card，展開顯示選項 |
| 選項列表 | `.table.table-sm` | 選項名稱 / 加價 / 刪除 |
| 新增選項 | inline form（每個 card 內） | 名稱 + 加價 + 送出 |

---

### 產品類型管理（`/admin/specs/products`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 新增表單 | `.card` 上方 | 產品名稱 + checkbox 勾選規格維度 |
| 產品列表 | `.table` | 名稱 / 維度 tag / 操作 |
| 維度 tag | `.badge.badge-info` | 每個維度一個 tag |

---

### 基本價設定（`/admin/specs/prices`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 產品選擇 | `<select>` | 選產品後動態顯示已設定的價格 |
| 價格列表 | `.table` | 規格組合描述 / 基本價 |
| 新增表單 | 多個 `<select>`（各規格維度）+ 價格 input | Ajax 動態載入規格選項 |

---

### 數量折扣設定（`/admin/specs/discounts`）

| 區域 | 元件 | 規格 |
|------|------|------|
| 折扣列表 | `.table` | 最低數量 / 折扣率 / 刪除 |
| 新增表單 | inline form | 最低數量 + 折扣率（如 0.9）+ 新增按鈕 |

---

## 客製樣式覆蓋（最小化）

```css
/* 僅需覆蓋的樣式 */
.content-wrapper { background-color: #f4f6f9; }
.card-header { font-weight: 600; }
```

---

## 共用元件

| 元件 | 說明 |
|------|------|
| Flash Message | `session('success')` / `session('error')` → `.alert.alert-success/.alert-danger` 自動消失 3 秒 |
| 麵包屑 | 每頁都有，使用 AdminLTE `.breadcrumb` |
| 返回按鈕 | 詳情頁左上角，`btn-outline-secondary fa-arrow-left` |

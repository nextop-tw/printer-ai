<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>方案定價 — PrinterAI｜透明計費，按需選擇</title>
  <meta name="description" content="個人、設計公司、企業三種方案，透明計費無隱藏費用。" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
@include('frontend.partials.navbar')

<section style="padding-top:130px;padding-bottom:60px;text-align:center">
  <div class="container-sm">
    <span class="label" style="display:block;margin-bottom:1rem">方案定價</span>
    <h1 class="display" style="font-size:clamp(2rem,5vw,3rem);margin-bottom:1rem">透明計費。<br>不藏任何費用。</h1>
    <p style="color:var(--muted);font-size:1.05rem;max-width:500px;margin:0 auto 2.5rem">免費檔案分析開始。只在印刷時付費。準備好了再升級月費方案。</p>
    <div style="display:flex;align-items:center;justify-content:center;gap:1rem;margin-bottom:3rem">
      <span style="font-size:0.88rem;color:var(--muted)">月繳</span>
      <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer">
        <input type="checkbox" id="billingToggle" style="opacity:0;width:0;height:0">
        <span style="position:absolute;inset:0;background:var(--border);border-radius:100px;transition:0.3s" id="toggleTrack"></span>
        <span style="position:absolute;height:18px;width:18px;left:3px;top:3px;background:white;border-radius:50%;transition:0.3s;box-shadow:0 1px 4px rgba(0,0,0,0.2)" id="toggleThumb"></span>
      </label>
      <span style="font-size:0.88rem;color:var(--muted)">年繳 <span style="background:rgba(232,92,44,0.1);color:var(--accent);padding:2px 8px;border-radius:100px;font-size:0.78rem;font-weight:600">省 20%</span></span>
    </div>
  </div>
</section>

<section style="padding-bottom:80px">
  <div class="container">
    <div class="pricing-grid" style="max-width:1000px;margin:0 auto">
      <div class="pricing-card">
        <div class="pricing-tier">入門方案</div>
        <h3>免費</h3>
        <div class="pricing-price">NT$0</div>
        <p class="pricing-desc">適合偶爾需要檢查檔案或少量印刷的使用者。</p>
        <div class="price-features">
          <div class="price-feature"><i class="bi bi-check-lg"></i> 每月 5 次檔案分析</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 解析度與色彩模式偵測</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 基本印刷風險報告</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 按量付費印刷下單</div>
          <div class="price-feature" style="color:var(--muted)"><i class="bi bi-x-lg" style="color:var(--border)"></i> 自動修正引擎</div>
          <div class="price-feature" style="color:var(--muted)"><i class="bi bi-x-lg" style="color:var(--border)"></i> 視覺預覽</div>
        </div>
        <a href="{{ route('auth.google') }}" class="btn btn-outline" style="width:100%;justify-content:center">免費開始</a>
      </div>
      <div class="pricing-card featured">
        <div class="featured-badge">最受歡迎</div>
        <div class="pricing-tier">專業方案</div>
        <h3>Pro</h3>
        <div class="pricing-price">NT$<span data-monthly="1490">1,490</span> <span><span class="billing-label">/月</span></span></div>
        <p class="pricing-desc">適合自由接案設計師與有固定印刷需求的小型公司。</p>
        <div class="price-features">
          <div class="price-feature"><i class="bi bi-check-lg"></i> 無限次檔案分析</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 六項完整偵測報告</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 自動修正引擎（全項目）</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 即時視覺印刷預覽</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 所有印刷訂單享 9 折優惠</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 電子郵件支援（24 小時回覆）</div>
        </div>
        <a href="{{ route('auth.google') }}" class="btn btn-primary" style="width:100%;justify-content:center">立即訂閱</a>
      </div>
      <div class="pricing-card">
        <div class="pricing-tier">企業 / SaaS</div>
        <h3>企業版</h3>
        <div class="pricing-price">NT$<span data-monthly="5990">5,990</span> <span><span class="billing-label">/月</span></span></div>
        <p class="pricing-desc">適合設計公司、印刷經銷商與需要平台整合的企業。</p>
        <div class="price-features">
          <div class="price-feature"><i class="bi bi-check-lg"></i> 包含 Pro 所有功能</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> REST API（每月 1 萬次呼叫）</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> Webhook 事件通知</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 多帳號團隊管理</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 白牌偵測元件</div>
          <div class="price-feature"><i class="bi bi-check-lg"></i> 所有印刷訂單享 85 折優惠</div>
        </div>
        <a href="{{ route('auth.google') }}" class="btn btn-dark" style="width:100%;justify-content:center">聯絡業務</a>
      </div>
    </div>
  </div>
</section>

<!-- Print Pricing Table -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-header center">
      <span class="label">印刷單價參考</span>
      <h2>有競爭力的價格，品質有保障</h2>
      <p>以下為標準印刷品項定價，結帳時自動計算量折。</p>
    </div>
    <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;margin-top:3rem">
      <table style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:var(--ink);color:white">
            <th style="padding:1rem 1.5rem;text-align:left;font-size:0.82rem;font-weight:600">品項</th>
            <th style="padding:1rem 1.5rem;text-align:left;font-size:0.82rem;font-weight:600">尺寸</th>
            <th style="padding:1rem 1.5rem;text-align:right;font-size:0.82rem;font-weight:600">100 張</th>
            <th style="padding:1rem 1.5rem;text-align:right;font-size:0.82rem;font-weight:600">500 張</th>
            <th style="padding:1rem 1.5rem;text-align:right;font-size:0.82rem;font-weight:600">1000 張</th>
          </tr>
        </thead>
        <tbody>
          <tr style="border-bottom:1px solid var(--cream)"><td style="padding:1rem 1.5rem;font-weight:600">名片</td><td style="padding:1rem 1.5rem;color:var(--muted);font-size:0.88rem">90 × 54mm</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$360</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$1,140</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$1,860</td></tr>
          <tr style="border-bottom:1px solid var(--cream)"><td style="padding:1rem 1.5rem;font-weight:600">A5 傳單</td><td style="padding:1rem 1.5rem;color:var(--muted);font-size:0.88rem">148 × 210mm</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$720</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$2,340</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$3,720</td></tr>
          <tr style="border-bottom:1px solid var(--cream)"><td style="padding:1rem 1.5rem;font-weight:600">A4 海報</td><td style="padding:1rem 1.5rem;color:var(--muted);font-size:0.88rem">210 × 297mm</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$1,320</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$4,440</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$7,200</td></tr>
          <tr><td style="padding:1rem 1.5rem;font-weight:600">A3 海報</td><td style="padding:1rem 1.5rem;color:var(--muted);font-size:0.88rem">297 × 420mm</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$2,040</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$6,840</td><td style="padding:1rem 1.5rem;text-align:right;font-family:'JetBrains Mono',monospace;font-size:0.88rem">NT$11,400</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section-sm" style="background:var(--cream)">
  <div class="container">
    <div class="cta-banner">
      <h2>今天就免費開始分析</h2>
      <p>加入設計師和代理商，信賴 PrinterAI 的印刷製程。</p>
      <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> 免費上傳</a>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div><div class="footer-brand"><div class="brand-icon"><i class="bi bi-printer-fill"></i></div>PrinterAI</div><p class="footer-desc">全球首個 AI 設計稿轉印刷一站式平台。</p></div>
      <div class="footer-col"><h5>平台</h5><ul><li><a href="{{ route('features') }}">功能介紹</a></li><li><a href="{{ route('pricing') }}">方案定價</a></li><li><a href="{{ route('upload') }}">免費試用</a></li></ul></div>
      <div class="footer-col"><h5>印刷品項</h5><ul><li><a href="#">名片</a></li><li><a href="#">DM 傳單</a></li><li><a href="#">海報</a></li></ul></div>
      <div class="footer-col"><h5>公司</h5><ul><li><a href="#">關於我們</a></li><li><a href="#">API 文件</a></li><li><a href="#">聯絡我們</a></li></ul></div>
    </div>
    <div class="footer-bottom"><span>© 2025 PrinterAI｜版權所有</span></div>
  </div>
</footer>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>

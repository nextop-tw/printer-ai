<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>功能介紹 — PrinterAI｜AI 印刷品質檢測平台</title>
  <meta name="description" content="探索 PrinterAI 四大核心模組：自動印刷品質偵測、一鍵檔案修正、視覺化預覽與全球印刷配送網絡。" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
@include('frontend.partials.navbar')

<!-- Hero -->
<section style="padding-top:130px;padding-bottom:80px;background:var(--ink);color:white;position:relative;overflow:hidden">
  <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.03) 1px,transparent 1px);background-size:48px 48px"></div>
  <div style="position:absolute;top:-80px;right:-80px;width:480px;height:480px;background:radial-gradient(circle,rgba(232,92,44,0.12) 0%,transparent 70%);border-radius:50%"></div>
  <div class="container" style="position:relative;z-index:1">
    <div style="max-width:700px">
      <span class="label" style="color:var(--accent);margin-bottom:1rem;display:block">平台功能</span>
      <h1 class="display" style="font-size:clamp(2.2rem,5vw,3.5rem);margin-bottom:1.25rem">從 AI 設計稿到專業印刷品，<br>你需要的工具全部都在這裡</h1>
      <p style="color:rgba(255,255,255,0.6);font-size:1.1rem;line-height:1.7;margin-bottom:2rem">四個核心模組無縫協作——偵測、修正、預覽、生產——消除你的創意檔案與完成印刷品之間的所有障礙。</p>
      <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> 立即免費試用</a>
    </div>
  </div>
</section>

<!-- Module 1: Detect -->
<section class="section">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center">
      <div data-animate>
        <span class="label" style="color:var(--accent);display:block;margin-bottom:1rem">模組 01 — 偵測</span>
        <h2 style="font-size:2rem;margin-bottom:1rem">10 秒完成印刷品質分析</h2>
        <p style="color:var(--muted);line-height:1.7;margin-bottom:1.5rem">偵測引擎對每個上傳的檔案進行全面的多參數分析，同步檢查所有影響印刷品質的關鍵因素，讓你在送印前完全掌握風險。</p>
        <div style="display:flex;flex-direction:column;gap:0.75rem">
          <div style="display:flex;align-items:center;gap:10px;font-size:0.9rem"><i class="bi bi-check2-circle" style="color:var(--accent);font-size:1.1rem"></i> 解析度偵測（最低 300 DPI 標準）</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:0.9rem"><i class="bi bi-check2-circle" style="color:var(--accent);font-size:1.1rem"></i> 色彩模式分析（RGB vs CMYK）</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:0.9rem"><i class="bi bi-check2-circle" style="color:var(--accent);font-size:1.1rem"></i> 出血區域驗證（3mm 標準）</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:0.9rem"><i class="bi bi-check2-circle" style="color:var(--accent);font-size:1.1rem"></i> 安全邊界分析</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:0.9rem"><i class="bi bi-check2-circle" style="color:var(--accent);font-size:1.1rem"></i> 尺寸規格對照驗證</div>
        </div>
      </div>
      <div data-animate>
        <div class="detect-card">
          <div class="detect-header"><h4><i class="bi bi-search"></i> 分析報告</h4><span class="detect-status status-warn">2 個警告</span></div>
          <div class="detect-body">
            <div class="detect-row"><div class="detect-label"><i class="bi bi-image"></i> 解析度</div><span class="detect-value ok">300 DPI ✓</span></div>
            <div class="detect-row"><div class="detect-label"><i class="bi bi-palette"></i> 色彩模式</div><span class="detect-value warn">RGB — 需轉換為 CMYK</span></div>
            <div class="detect-row"><div class="detect-label"><i class="bi bi-crop"></i> 出血區域</div><span class="detect-value warn">缺少——0mm</span></div>
            <div class="detect-row"><div class="detect-label"><i class="bi bi-shield-check"></i> 安全邊界</div><span class="detect-value ok">內容在範圍內 ✓</span></div>
            <div class="detect-row"><div class="detect-label"><i class="bi bi-rulers"></i> 尺寸規格</div><span class="detect-value ok">90 × 54mm ✓</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Module 2: Fix -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center">
      <div data-animate>
        <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:2rem">
          <h4 style="margin-bottom:1.5rem;font-size:1rem"><i class="bi bi-magic" style="color:var(--accent)"></i> 自動修正引擎</h4>
          <div style="display:flex;flex-direction:column;gap:1rem">
            <div style="background:var(--cream);border-radius:var(--radius);padding:1rem">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem"><span style="font-size:0.88rem;font-weight:600">RGB → CMYK 轉換</span><span class="order-badge badge-ready">完成</span></div>
              <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:100%"></div></div>
            </div>
            <div style="background:var(--cream);border-radius:var(--radius);padding:1rem">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem"><span style="font-size:0.88rem;font-weight:600">新增 3mm 出血</span><span class="order-badge badge-ready">完成</span></div>
              <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:100%"></div></div>
            </div>
          </div>
        </div>
      </div>
      <div data-animate>
        <span class="label" style="color:var(--accent);display:block;margin-bottom:1rem">模組 02 — 修正</span>
        <h2 style="font-size:2rem;margin-bottom:1rem">以往要花幾小時的修正，<br>現在自動完成</h2>
        <p style="color:var(--muted);line-height:1.7;margin-bottom:1.5rem">每個偵測到的問題都能用一個按鈕解決。修正引擎採用業界標準演算法與 AI 增強技術，在不損壞設計意圖的前提下修復檔案。</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
          <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;font-size:0.85rem"><i class="bi bi-palette" style="color:var(--accent);margin-right:6px"></i>RGB → CMYK</div>
          <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;font-size:0.85rem"><i class="bi bi-crop" style="color:var(--accent);margin-right:6px"></i>補出血</div>
          <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;font-size:0.85rem"><i class="bi bi-zoom-in" style="color:var(--accent);margin-right:6px"></i>AI 提升解析度</div>
          <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1rem;font-size:0.85rem"><i class="bi bi-arrows-move" style="color:var(--accent);margin-right:6px"></i>自動置中</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section">
  <div class="container">
    <div class="cta-banner">
      <h2>免費開始你的第一次分析</h2>
      <p>無需信用卡，10 秒內取得印刷品質評分。</p>
      <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> 上傳並分析</a>
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

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PrinterAI — AI 設計稿，一鍵轉印刷</title>
  <meta name="description" content="PrinterAI 是 AI 設計稿轉印刷平台。自動偵測印刷問題、一鍵修正、即時預覽，讓任何 AI 設計圖都能完美印出。" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23e85c2c'/><text y='24' x='5' font-size='22'>🖨</text></svg>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>

@include('frontend.partials.navbar')

<!-- Hero -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-bg-blob"></div>
  <div class="container">
    <div class="hero-inner">
      <div class="hero-content fade-in-up">
        <div class="hero-eyebrow">
          <span class="hero-eyebrow-dot"></span>
          AI 驅動印刷轉換平台
        </div>
        <h1 class="hero-title display">
          AI 設計稿
          <span class="line2">直達印刷品</span>
        </h1>
        <p class="hero-sub">橋接 AI 生成設計與專業印刷製程的平台。自動品質偵測、智慧修正、視覺預覽，讓每一張 AI 設計都能完美呈現在紙上。</p>
        <div class="hero-actions">
          <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-cloud-upload"></i> 免費上傳分析</a>
          <a href="{{ route('features') }}" class="btn btn-outline btn-lg">了解運作方式</a>
        </div>
        <div class="hero-trust">
          <div class="trust-item"><i class="bi bi-check-circle-fill"></i> 無需設計技能</div>
          <div class="trust-item"><i class="bi bi-check-circle-fill"></i> 10 秒內出報告</div>
          <div class="trust-item"><i class="bi bi-check-circle-fill"></i> 全球配送服務</div>
        </div>
      </div>
      <div class="hero-visual fade-in-up delay-2" style="position:relative">
        <div class="hero-card">
          <div class="card-header-bar">
            <span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span>
            <span class="mono" style="font-size:0.72rem;color:var(--muted);margin-left:8px">印刷分析報告.pdf</span>
          </div>
          <div class="file-preview-area" style="background:linear-gradient(135deg,#1a3a5c,#2a5a8c);padding:1.5rem">
            <div style="background:white;border-radius:4px;padding:1.5rem;text-align:center">
              <div style="font-size:0.7rem;color:#666;margin-bottom:0.5rem;font-family:'JetBrains Mono',monospace;letter-spacing:0.1em">YOUR BRAND</div>
              <div style="font-family:'Syne',sans-serif;font-size:1.8rem;font-weight:800;color:#0d0d0d;line-height:1">設計工作室</div>
              <div style="width:40px;height:2px;background:#e85c2c;margin:0.5rem auto"></div>
              <div style="font-size:0.7rem;color:#999">hello@yourbrand.com・02-1234-5678</div>
            </div>
          </div>
          <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:0.75rem">
            <span class="risk-badge risk-ok"><i class="bi bi-check-lg"></i> 300 DPI</span>
            <span class="risk-badge risk-warn"><i class="bi bi-exclamation-triangle"></i> RGB→CMYK</span>
            <span class="risk-badge risk-ok"><i class="bi bi-check-lg"></i> 出血正常</span>
          </div>
          <div style="margin-top:1rem">
            <div class="check-row"><span class="check-label">解析度</span><span class="check-val ok">300 DPI ✓</span></div>
            <div class="check-row"><span class="check-label">色彩模式</span><span class="check-val warn">RGB → 需轉 CMYK</span></div>
            <div class="check-row"><span class="check-label">出血區域</span><span class="check-val ok">3mm ✓</span></div>
            <div class="check-row"><span class="check-label">安全邊界</span><span class="check-val ok">符合規範 ✓</span></div>
          </div>
        </div>
        <div class="floating-badge badge-top"><i class="bi bi-lightning-charge-fill" style="color:var(--accent)"></i> 8.3 秒完成分析</div>
        <div class="floating-badge badge-bottom" style="animation-delay:2s"><i class="bi bi-truck" style="color:#1a8a2e"></i> 2–3 個工作天到貨</div>
      </div>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="section-sm" style="background:var(--cream);border-top:1px solid var(--border);border-bottom:1px solid var(--border)">
  <div class="container">
    <div class="stats-row">
      <div class="stat-item"><span class="stat-num" data-target="120000" data-suffix="+">0</span><div class="stat-label">已分析檔案數</div></div>
      <div class="stat-item"><span class="stat-num" data-target="47000" data-suffix="+">0</span><div class="stat-label">印刷訂單完成</div></div>
      <div class="stat-item"><span class="stat-num" data-target="98.4" data-suffix="%">0</span><div class="stat-label">零瑕疵出貨率</div></div>
      <div class="stat-item"><span class="stat-num" data-target="52" data-suffix="">0</span><div class="stat-label">覆蓋國家地區</div></div>
    </div>
  </div>
</section>

<!-- Problem -->
<section class="section">
  <div class="container">
    <div class="section-header center">
      <span class="label">我們解決的核心問題</span>
      <h2>AI 設計在螢幕上很美，<br>但大多數印出來會失敗。</h2>
      <p>Midjourney、DALL·E、Stable Diffusion 能生成驚艷的圖像，但這些工具從來不會幫你準備印刷檔案。結果就是：模糊的海報、色偏的文宣、浪費的預算。</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-top:3rem">
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:2rem;text-align:center" data-animate>
        <div style="font-size:2.5rem;margin-bottom:1rem">🖼️</div>
        <h4 style="margin-bottom:0.5rem">解析度不足</h4>
        <p style="font-size:0.85rem;color:var(--muted);line-height:1.65">AI 圖片通常只有 72 DPI，印刷最低需要 300 DPI。差距放到紙上是災難性的模糊。</p>
      </div>
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:2rem;text-align:center" data-animate>
        <div style="font-size:2.5rem;margin-bottom:1rem">🎨</div>
        <h4 style="margin-bottom:0.5rem">色彩模式錯誤</h4>
        <p style="font-size:0.85rem;color:var(--muted);line-height:1.65">螢幕用 RGB，印刷用 CMYK。未轉換直接送印，螢幕上鮮豔的顏色會變暗淡混濁。</p>
      </div>
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:2rem;text-align:center" data-animate>
        <div style="font-size:2.5rem;margin-bottom:1rem">✂️</div>
        <h4 style="margin-bottom:0.5rem">缺少出血設定</h4>
        <p style="font-size:0.85rem;color:var(--muted);line-height:1.65">沒有出血區域，裁切後會留下白邊。專業印刷需要 3mm 出血，AI 檔案幾乎都沒有。</p>
      </div>
      <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:2rem;text-align:center" data-animate>
        <div style="font-size:2.5rem;margin-bottom:1rem">📐</div>
        <h4 style="margin-bottom:0.5rem">尺寸規格不符</h4>
        <p style="font-size:0.85rem;color:var(--muted);line-height:1.65">名片標準是 90×54mm，AI 輸出往往是任意尺寸。強制縮放會扭曲版面與文字。</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-header center">
      <span class="label">平台運作流程</span>
      <h2>六個步驟，從設計稿<br>到你手上的印刷品</h2>
    </div>
    <div class="steps-grid">
      <div class="step-card" data-animate><div class="step-num">01</div><div class="step-icon"><i class="bi bi-cloud-upload"></i></div><h4>上傳設計稿</h4><p>直接拖曳任何來自 Midjourney、DALL·E、Canva 或 AI 工具的 JPG、PNG、PDF 檔，最大支援 20MB。</p></div>
      <div class="step-card" data-animate><div class="step-num">02</div><div class="step-icon"><i class="bi bi-search"></i></div><h4>即時印刷分析</h4><p>引擎同步檢查解析度、色彩模式、出血區域、安全邊界與尺寸規格，10 秒內完成六項偵測。</p></div>
      <div class="step-card" data-animate><div class="step-num">03</div><div class="step-icon"><i class="bi bi-magic"></i></div><h4>一鍵自動修正</h4><p>RGB 轉 CMYK、補出血、AI 提升解析度、自動置中，以往需要設計師數小時，現在一個按鈕搞定。</p></div>
      <div class="step-card" data-animate><div class="step-num">04</div><div class="step-icon"><i class="bi bi-eye"></i></div><h4>視覺印刷預覽</h4><p>在正式下單前，清楚看見出血邊框、安全區邊界和模擬裁切線呈現在實際設計上的樣子。</p></div>
      <div class="step-card" data-animate><div class="step-num">05</div><div class="step-icon"><i class="bi bi-bag-check"></i></div><h4>選擇規格下單</h4><p>選擇品項、材質、數量與加工方式，系統即時報價，無隱藏費用。</p></div>
      <div class="step-card" data-animate><div class="step-num">06</div><div class="step-icon"><i class="bi bi-truck"></i></div><h4>印刷與配送到府</h4><p>媒合最佳認證印刷廠，2–5 個工作天配送到府，支援全球寄送。</p></div>
    </div>
    <div class="text-center mt-3">
      <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> 免費試用——無需註冊帳號</a>
    </div>
  </div>
</section>

<!-- Features -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="label">核心功能</span>
      <h2>為精準而生，<br>為所有人設計。</h2>
      <p>無論你是設計師在交付前最後把關，還是用 Canva 製作名片的小店老闆，PrinterAI 讓專業印刷對每個人都唾手可得。</p>
    </div>
    <div class="features-grid">
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-cpu"></i></div><h4>智慧偵測引擎</h4><p>多層次分析同時檢查所有關鍵印刷參數，數秒內生成完整風險報告。</p></div>
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-arrow-repeat"></i></div><h4>自動修正套件</h4><p>RGB 轉 CMYK、補出血延伸、解析度提升，以往要花數小時的修正全部自動完成。</p></div>
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-display"></i></div><h4>即時印刷預覽</h4><p>視覺化呈現出血邊框、安全區與裁切線，下單前完全掌握成品效果。</p></div>
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-building"></i></div><h4>多廠商印刷網絡</h4><p>依產品類型、所在地與交期需求，智慧媒合最適合的認證印刷合作廠商。</p></div>
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-graph-up"></i></div><h4>完整訂單管理</h4><p>從下單、製作到配送，全流程即時追蹤狀態，支援一鍵重複下單。</p></div>
      <div class="feature-card" data-animate><div class="feature-icon"><i class="bi bi-plug"></i></div><h4>API 與 SaaS 串接</h4><p>透過 REST API 將偵測功能直接嵌入你的設計工具、CMS 或電商平台。</p></div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-header center">
      <span class="label">客戶怎麼說</span>
      <h2>獲得設計師、代理商<br>與企業主的信賴</h2>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card" data-animate><div class="t-quote">"</div><p class="t-text">以前客戶拿 AI 設計稿來，光修正印刷問題就要耗掉幾個小時。用了 PrinterAI，幾分鐘就搞定，已經成為公司不可缺少的工具。</p><div class="t-author"><div class="t-avatar">林</div><div><div class="t-name">林小姐</div><div class="t-role">設計總監，台北</div></div></div></div>
      <div class="testimonial-card" data-animate><div class="t-quote">"</div><p class="t-text">我用 Midjourney 設計了名片，完全不知道印出來會這麼慘。PrinterAI 幫我找出所有問題還自動修好了，真的很神奇。</p><div class="t-author"><div class="t-avatar">陳</div><div><div class="t-name">陳先生</div><div class="t-role">自由接案顧問，台中</div></div></div></div>
      <div class="testimonial-card" data-animate><div class="t-quote">"</div><p class="t-text">API 串接後把印前檢查直接內建到設計工具裡，因印刷品質問題產生的客服工單減少了 70%，ROI 非常驚人。</p><div class="t-author"><div class="t-avatar">王</div><div><div class="t-name">王先生</div><div class="t-role">技術長，SaaS 設計平台</div></div></div></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section">
  <div class="container">
    <div class="cta-banner">
      <h2>準備好讓你的 AI 設計稿可以印刷了嗎？</h2>
      <p>免費上傳第一個檔案，無需信用卡，10 秒內取得完整分析報告。</p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
        <a href="{{ route('upload') }}" class="btn btn-primary btn-lg"><i class="bi bi-upload"></i> 免費開始分析</a>
        <a href="{{ route('pricing') }}" class="btn btn-outline btn-lg" style="color:white;border-color:rgba(255,255,255,0.3)">查看方案定價</a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand"><div class="brand-icon"><i class="bi bi-printer-fill"></i></div>PrinterAI</div>
        <p class="footer-desc">全球首個 AI 設計稿轉印刷一站式平台，讓專業印刷對每個人都唾手可得。</p>
      </div>
      <div class="footer-col"><h5>平台</h5><ul><li><a href="{{ route('features') }}">功能介紹</a></li><li><a href="{{ route('pricing') }}">方案定價</a></li><li><a href="{{ route('upload') }}">免費試用</a></li><li><a href="{{ route('dashboard') }}">管理後台</a></li></ul></div>
      <div class="footer-col"><h5>印刷品項</h5><ul><li><a href="#">名片</a></li><li><a href="#">DM 傳單</a></li><li><a href="#">海報</a></li><li><a href="#">折頁</a></li></ul></div>
      <div class="footer-col"><h5>公司</h5><ul><li><a href="#">關於我們</a></li><li><a href="#">API 文件</a></li><li><a href="#">隱私政策</a></li><li><a href="#">服務條款</a></li></ul></div>
    </div>
    <div class="footer-bottom">
      <span>© 2025 PrinterAI｜版權所有</span>
      <div style="display:flex;gap:1.5rem"><a href="#">隱私政策</a><a href="#">服務條款</a><a href="#">聯絡我們</a></div>
    </div>
  </div>
</footer>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>檔案分析 — PrinterAI</title>
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />
</head>
<body>
<div class="dashboard-layout">
  @include('frontend.partials.sidebar')
  <main class="main-content">
    <div class="topbar">
      <div style="display:flex;align-items:center;gap:0.75rem">
        <button class="sidebar-toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <span class="topbar-greeting"><strong>檔案分析</strong> — 下單前先偵測印刷問題</span>
      </div>
      <div class="topbar-actions"><a href="{{ route('upload') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> 新增訂單</a></div>
    </div>
    <div style="max-width:800px">
      <div class="upload-zone" id="uploadZone" style="margin-bottom:1.5rem">
        <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.pdf" />
        <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
        <h3>將設計稿拖曳到此處</h3>
        <p>支援 JPG、PNG、PDF，最大 20MB。免費分析，無需訂閱。</p>
      </div>
      <div id="detectResult" class="hidden">
        <div class="detect-card" style="margin-bottom:1.5rem">
          <div class="detect-header">
            <h4><i class="bi bi-file-earmark-check"></i> <span id="detectFilename">—</span></h4>
            <span class="detect-status" id="detectStatus">分析中...</span>
          </div>
          <div class="detect-body" id="detectRows"></div>
        </div>
        <div id="fixPanel" class="hidden" style="background:rgba(232,92,44,0.06);border:1px solid rgba(232,92,44,0.2);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem">
          <h4 style="margin-bottom:0.75rem;font-size:1rem"><i class="bi bi-magic" style="color:var(--accent)"></i> 自動修正可用</h4>
          <p style="font-size:0.88rem;color:var(--muted);margin-bottom:1rem">選擇要套用的修正，再進行下單。</p>
          <div style="display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1rem">
            <label style="display:flex;align-items:center;gap:8px;font-size:0.88rem;cursor:pointer"><input type="checkbox" checked style="accent-color:var(--accent)" /> RGB 轉換為 CMYK</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:0.88rem;cursor:pointer"><input type="checkbox" checked style="accent-color:var(--accent)" /> 新增 3mm 出血區域</label>
            <label style="display:flex;align-items:center;gap:8px;font-size:0.88rem;cursor:pointer"><input type="checkbox" style="accent-color:var(--accent)" /> AI 解析度提升</label>
          </div>
          <div style="display:flex;gap:0.75rem">
            <button class="btn btn-primary" id="applyFixBtn"><i class="bi bi-magic"></i> 套用修正</button>
            <a href="{{ route('upload') }}" class="btn btn-dark"><i class="bi bi-cart-plus"></i> 前往下單</a>
          </div>
        </div>
        <button class="btn btn-outline" id="resetBtn"><i class="bi bi-arrow-counterclockwise"></i> 分析另一個檔案</button>
      </div>
    </div>
  </main>
</div>
<div class="toast-container"></div>
<script src="{{ asset('js/frontend.js') }}"></script>
<script>
document.getElementById('applyFixBtn')?.addEventListener('click', function(){
  this.innerHTML = '<i class="bi bi-check-lg"></i> 修正已套用';
  this.disabled = true;
  Toast.show('自動修正已成功套用', 'success');
});
document.getElementById('resetBtn')?.addEventListener('click', function(){
  document.getElementById('detectResult').classList.add('hidden');
  const zone = document.getElementById('uploadZone');
  zone.style.display = '';
  zone.innerHTML = `<input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.pdf" /><div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div><h3>將設計稿拖曳到此處</h3><p>支援 JPG、PNG、PDF，最大 20MB。</p>`;
  initUploadZone();
});
</script>
</body>
</html>

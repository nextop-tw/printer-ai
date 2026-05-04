/* PrinterAI — Main JS (Laravel Edition) */

/* ── Toast ── */
const Toast = {
  _el: null,
  init() {
    if (this._el) return;
    this._el = document.querySelector('.toast-container');
    if (!this._el) {
      this._el = document.createElement('div');
      this._el.className = 'toast-container';
      document.body.appendChild(this._el);
    }
  },
  show(msg, type = 'info', ms = 3200) {
    this.init();
    const icons = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', info: 'bi-info-circle-fill' };
    const el = document.createElement('div');
    el.className = `toast toast-${type}`;
    el.innerHTML = `<i class="bi ${icons[type] || icons.info}"></i><span>${msg}</span>`;
    this._el.appendChild(el);
    setTimeout(() => {
      el.style.cssText = 'opacity:0;transform:translateX(12px);transition:all .28s ease';
      setTimeout(() => el.remove(), 300);
    }, ms);
  }
};

/* ── Navbar ── */
function initNavbar() {
  const nav = document.querySelector('.navbar');
  if (!nav) return;

  const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 20);
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  const btn = document.querySelector('.hamburger');
  const menu = document.querySelector('.mobile-menu');
  if (btn && menu) {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.classList.toggle('open');
    });
    document.addEventListener('click', (e) => {
      if (!nav.contains(e.target)) menu.classList.remove('open');
    });
  }

  const page = location.pathname.split('/').pop() || '';
  document.querySelectorAll('.nav-link[data-page]').forEach(a => {
    if (a.dataset.page === page) a.classList.add('active');
  });
}

/* ── Scroll Animations ── */
function initScrollAnimations() {
  const items = document.querySelectorAll('[data-animate]');
  if (!items.length || !('IntersectionObserver' in window)) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('fade-in-up'); io.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  items.forEach(el => io.observe(el));
}

/* ── Counter Animations ── */
function initCounters() {
  const els = document.querySelectorAll('[data-target]');
  if (!els.length || !('IntersectionObserver' in window)) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      io.unobserve(e.target);
      const el = e.target;
      const target = parseFloat(el.dataset.target);
      const suffix = el.dataset.suffix || '';
      const dur = 1800;
      const start = performance.now();
      const tick = (now) => {
        const p = Math.min((now - start) / dur, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = (Number.isInteger(target)
          ? Math.floor(eased * target).toLocaleString()
          : (eased * target).toFixed(1)) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    });
  }, { threshold: 0.5 });
  els.forEach(el => io.observe(el));
}

/* ── Tabs ── */
function initTabs() {
  document.querySelectorAll('.tab-bar').forEach(bar => {
    bar.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.tab;
        if (!target) return;
        bar.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const panel = document.getElementById(target);
        if (!panel) return;
        const container = panel.closest('.tab-container') || document;
        container.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        panel.classList.add('active');
      });
    });
  });
}

/* ── Upload Zone (偵測引擎) ── */
function initUploadZone() {
  const zone = document.getElementById('uploadZone');
  const fileInput = document.getElementById('fileInput');
  const resultPanel = document.getElementById('detectResult');
  if (!zone) return;

  zone.addEventListener('dragenter', e => { e.preventDefault(); zone.classList.add('dragover'); });
  zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('dragover'); });
  zone.addEventListener('dragleave', e => { e.preventDefault(); zone.classList.remove('dragover'); });
  zone.addEventListener('drop', e => {
    e.preventDefault(); zone.classList.remove('dragover');
    const file = e.dataTransfer?.files?.[0];
    if (file) processFile(file);
  });
  if (fileInput) {
    fileInput.addEventListener('change', () => {
      if (fileInput.files?.[0]) processFile(fileInput.files[0]);
    });
  }

  function processFile(file) {
    const valid = ['image/jpeg','image/png','application/pdf'];
    if (!valid.includes(file.type)) {
      Toast.show('不支援的格式，請上傳 JPG、PNG 或 PDF', 'error'); return;
    }
    if (file.size > 20 * 1024 * 1024) {
      Toast.show('檔案超過 20MB 上限', 'error'); return;
    }
    showAnalyzing(zone);
    setTimeout(() => runDetection(file), 2000);
  }

  function showAnalyzing(el) {
    el.innerHTML = `
      <div class="upload-icon"><i class="bi bi-arrow-repeat spin"></i></div>
      <h3>分析檔案中...</h3>
      <p>正在執行印刷品質六項檢測</p>
      <div class="progress-bar-wrap mt-2" style="max-width:180px;margin:0.75rem auto 0">
        <div class="progress-bar-fill" id="analyzeBar" style="width:0%"></div>
      </div>`;
    let w = 0;
    const iv = setInterval(() => {
      w += Math.random() * 18 + 4;
      if (w >= 90) { clearInterval(iv); w = 90; }
      const bar = document.getElementById('analyzeBar');
      if (bar) bar.style.width = w + '%';
    }, 180);
  }

  function runDetection(file) {
    const isPDF = file.type === 'application/pdf';
    const r = {
      filename: file.name,
      size: (file.size / 1024).toFixed(0) + ' KB',
      dpi: isPDF ? '300 DPI' : (Math.random() > 0.5 ? '300 DPI' : '72 DPI'),
      colorMode: isPDF ? 'CMYK' : (Math.random() > 0.4 ? 'CMYK' : 'RGB'),
      bleed: Math.random() > 0.5 ? '3mm ✓' : '缺少',
      safeZone: Math.random() > 0.4 ? '正常' : '過於靠近邊緣',
    };
    r.dpiOk    = r.dpi.includes('300');
    r.colorOk  = r.colorMode === 'CMYK';
    r.bleedOk  = r.bleed.includes('✓');
    r.safeOk   = r.safeZone === '正常';
    r.score    = [r.dpiOk, r.colorOk, r.bleedOk, r.safeOk].filter(Boolean).length;

    zone.style.display = 'none';
    if (resultPanel) {
      resultPanel.classList.remove('hidden');
      renderResult(r);
    }
    setTimeout(() => Toast.show('分析完成', 'success'), 300);
  }

  function renderResult(r) {
    const cls   = r.score === 4 ? 'status-pass' : r.score >= 2 ? 'status-warn' : 'status-fail';
    const label = r.score === 4 ? '可直接印刷' : r.score >= 2 ? '有警告項目' : '發現問題';

    const statusEl   = document.getElementById('detectStatus');
    const filenameEl = document.getElementById('detectFilename');
    if (statusEl)   { statusEl.className = `detect-status ${cls}`; statusEl.textContent = label; }
    if (filenameEl) filenameEl.textContent = r.filename;

    const rows = [
      { icon:'bi-image',       label:'解析度', value: r.dpi,      ok: r.dpiOk },
      { icon:'bi-palette',     label:'色彩模式',value: r.colorMode, ok: r.colorOk },
      { icon:'bi-crop',        label:'出血區域',value: r.bleed,    ok: r.bleedOk },
      { icon:'bi-shield-check',label:'安全邊界',value: r.safeZone, ok: r.safeOk },
      { icon:'bi-file-earmark',label:'檔案大小',value: r.size,     ok: true },
    ];
    const rowsEl = document.getElementById('detectRows');
    if (rowsEl) {
      rowsEl.innerHTML = rows.map(row => `
        <div class="detect-row">
          <div class="detect-label"><i class="bi ${row.icon}"></i> ${row.label}</div>
          <span class="detect-value ${row.ok ? 'ok' : 'err'}">${row.value}</span>
        </div>`).join('');
    }

    const fixPanel = document.getElementById('fixPanel');
    if (fixPanel && r.score < 4) fixPanel.classList.remove('hidden');
  }
}

/* ── Sidebar (Dashboard) ── */
function initDashboard() {
  if (!document.querySelector('.dashboard-layout')) return;

  const toggleBtn = document.getElementById('sidebarToggle') || document.querySelector('.sidebar-toggle-btn');
  const sidebar   = document.querySelector('.sidebar');

  let overlay = document.querySelector('.sidebar-overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
  }

  function openSidebar()  { sidebar?.classList.add('open'); overlay.classList.add('active'); document.body.style.overflow = 'hidden'; }
  function closeSidebar() { sidebar?.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow = ''; }

  toggleBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
  });
  overlay.addEventListener('click', closeSidebar);
}

/* ── Upload Wizard ── */
function initWizard() {
  const wizard = document.querySelector('.upload-wizard');
  if (!wizard) return;

  let step = 1;
  const TOTAL = 6;
  const panels = wizard.querySelectorAll('.wizard-panel');
  const steps  = wizard.querySelectorAll('.wizard-step');
  const btnNext = document.getElementById('btnNext');
  const btnBack = document.getElementById('btnBack');

  function goTo(n) {
    step = Math.max(1, Math.min(TOTAL, n));
    steps.forEach((s, i) => {
      s.classList.toggle('active', i + 1 === step);
      s.classList.toggle('done',   i + 1 < step);
      const numEl = s.querySelector('.wizard-num');
      if (numEl) {
        if (i + 1 < step) numEl.innerHTML = '<i class="bi bi-check"></i>';
        else numEl.textContent = i + 1;
      }
    });
    panels.forEach((p, i) => p.classList.toggle('hidden', i + 1 !== step));
    if (btnBack) btnBack.classList.toggle('hidden', step === 1);
    if (btnNext) {
      if (step === TOTAL) btnNext.innerHTML = '<i class="bi bi-check-lg"></i> 送出訂單';
      else btnNext.innerHTML = '繼續 <i class="bi bi-arrow-right"></i>';
    }
    wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  btnNext?.addEventListener('click', () => {
    if (step < TOTAL) {
      goTo(step + 1);
    } else {
      if (btnNext) { btnNext.disabled = true; btnNext.innerHTML = '<i class="bi bi-hourglass spin"></i> 處理中...'; }
      setTimeout(() => {
        Toast.show('訂單已成功送出！', 'success');
        setTimeout(() => window.location.href = '/dashboard', 1600);
      }, 800);
    }
  });
  btnBack?.addEventListener('click', () => goTo(step - 1));

  wizard.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', () => {
      wizard.querySelectorAll('.product-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      updateQuote();
    });
  });
  wizard.querySelectorAll('#qtySelect, #materialSelect').forEach(sel => {
    sel?.addEventListener('change', updateQuote);
  });

  function updateQuote() {
    const sel = wizard.querySelector('.product-card.selected');
    const qty = parseInt(wizard.querySelector('#qtySelect')?.value || 100);
    if (!sel) return;
    const name = sel.querySelector('.product-name')?.textContent || '';
    const priceMap = { '名片': 2.4, 'DM 傳單': 3.6, '海報': 13.5 };
    const unit = priceMap[name] || 3;
    const sub  = qty * unit;
    const tax  = Math.round(sub * 0.05);
    const total = sub + tax;
    const fmt = n => `NT$${n.toLocaleString()}`;
    const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };
    set('qProductName', name);
    set('qQty', qty + ' 張');
    set('qSubtotal', fmt(sub));
    set('qTax', fmt(tax));
    set('qTotal', fmt(total));
  }

  goTo(1);
  updateQuote();
}

/* ── Pricing Toggle ── */
function initPricingToggle() {
  const toggle = document.getElementById('billingToggle');
  const track  = document.getElementById('toggleTrack');
  const thumb  = document.getElementById('toggleThumb');
  if (!toggle) return;
  toggle.addEventListener('change', () => {
    const yearly = toggle.checked;
    if (track) track.style.background = yearly ? 'var(--accent)' : 'var(--border)';
    if (thumb) thumb.style.transform  = yearly ? 'translateX(20px)' : 'translateX(0)';
    document.querySelectorAll('[data-monthly]').forEach(el => {
      const base   = parseFloat(el.dataset.monthly.replace(/,/g, ''));
      const annual = Math.round(base * 0.8);
      el.textContent = yearly ? annual.toLocaleString() : parseFloat(el.dataset.monthly).toLocaleString();
    });
    document.querySelectorAll('.billing-label').forEach(el => {
      el.textContent = yearly ? '/月（年繳）' : '/月';
    });
  });
}

/* ── Init ── */
document.addEventListener('DOMContentLoaded', () => {
  Toast.init();
  initNavbar();
  initTabs();
  initScrollAnimations();
  initCounters();
  initUploadZone();
  initDashboard();
  initWizard();
  initPricingToggle();
});

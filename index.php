<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ClearCut — Remove image backgrounds and download a transparent PNG.">
  <title>净影 ClearCut — 图片去背景</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="atmosphere" aria-hidden="true"></div>

  <header class="topbar">
    <a class="brand" href="./" aria-label="ClearCut">
      <span class="brand-mark" aria-hidden="true"></span>
      <span class="brand-text">
        <span class="brand-zh" data-i18n="brand_zh">净影</span>
        <span class="brand-en">ClearCut</span>
      </span>
    </a>
    <div class="topbar-actions">
      <a class="btn btn-ghost topbar-link" href="manual.php" data-i18n="nav_manual">用户手册</a>
      <div class="lang-switch" role="group" aria-label="Language">
        <button type="button" class="lang-btn is-active" data-lang="zh" aria-pressed="true">中文</button>
        <button type="button" class="lang-btn" data-lang="en" aria-pressed="false">EN</button>
      </div>
    </div>
  </header>

  <main>
    <section class="hero" id="upload-section">
      <h1 class="hero-brand">
        <span data-i18n="brand_zh">净影</span>
        <span class="hero-brand-en">ClearCut</span>
      </h1>
      <p class="hero-tagline" data-i18n="tagline">一键移除背景，下载透明 PNG</p>

      <form id="upload-form" class="dropzone" enctype="multipart/form-data" novalidate>
        <input type="file" id="image-input" name="image" accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif" hidden>
        <div class="dropzone-inner" id="drop-area">
          <div class="dropzone-icon" aria-hidden="true">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect x="6" y="10" width="36" height="28" rx="4" stroke="currentColor" stroke-width="2"/>
              <circle cx="17" cy="20" r="3" fill="currentColor" opacity=".55"/>
              <path d="M6 32l10-8 8 6 6-5 12 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <p class="dropzone-title" data-i18n="drop_title">拖放图片到此处，或点击选择</p>
          <p class="dropzone-hint" data-i18n="drop_hint">支持 JPG / PNG / WEBP / GIF，最大 8 MB</p>
          <button type="button" class="btn btn-primary" id="browse-btn" data-i18n="browse">选择图片</button>
        </div>
        <div class="preview-strip" id="preview-strip" hidden>
          <img id="preview-thumb" alt="" width="72" height="72">
          <div class="preview-meta">
            <span id="preview-name"></span>
            <span id="preview-size"></span>
          </div>
          <button type="button" class="btn btn-ghost" id="clear-btn" data-i18n="clear">清除</button>
        </div>
        <button type="submit" class="btn btn-accent" id="process-btn" disabled data-i18n="process">开始去背景</button>
      </form>
    </section>

    <section class="progress-panel" id="progress-panel" hidden>
      <div class="progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="progress-bar">
        <div class="progress-fill" id="progress-fill"></div>
      </div>
      <p class="progress-text" id="progress-text" data-i18n="processing">正在处理，请稍候…</p>
    </section>

    <section class="results" id="results-section" hidden>
      <header class="section-head">
        <h2 data-i18n="results_title">去背景完成</h2>
        <p data-i18n="results_sub">预览结果后下载透明 PNG</p>
      </header>

      <div class="result-panel">
        <div class="result-compare">
          <figure class="result-col">
            <figcaption data-i18n="original">原图</figcaption>
            <div class="checker result-frame">
              <img id="original-preview" alt="Original">
            </div>
          </figure>
          <div class="result-divider" aria-hidden="true">
            <span class="result-arrow">→</span>
          </div>
          <figure class="result-col result-col-out">
            <figcaption data-i18n="result_label">去背景结果</figcaption>
            <div class="checker result-frame result-frame-lg">
              <img id="result-preview" alt="Result">
            </div>
          </figure>
        </div>
        <div class="result-actions">
          <button type="button" class="btn btn-ghost" id="again-btn" data-i18n="again">再传一张</button>
          <a class="btn btn-accent" id="download-btn" href="#" download data-i18n="download">下载 PNG</a>
        </div>
      </div>
    </section>

    <p class="status-msg" id="status-msg" role="status" aria-live="polite" hidden></p>
  </main>

  <?php require __DIR__ . '/includes/footer.php'; ?>

  <script src="assets/js/i18n.js"></script>
  <script type="module" src="assets/js/app.js"></script>
</body>
</html>

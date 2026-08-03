<?php
/**
 * User manual — language follows ClearCut i18n (zh / en).
 * Desktop: full-width layout (width: 100%), not browser Fullscreen API.
 */
declare(strict_types=1);
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ClearCut user manual — how to remove image backgrounds.">
  <title>用户手册 — 净影 ClearCut</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/manual.css">
</head>
<body class="page-manual">
  <div class="atmosphere" aria-hidden="true"></div>

  <header class="topbar manual-topbar">
    <a class="brand" href="index.php" aria-label="ClearCut">
      <span class="brand-mark" aria-hidden="true"></span>
      <span class="brand-text">
        <span class="brand-zh" data-i18n="brand_zh">净影</span>
        <span class="brand-en">ClearCut</span>
      </span>
    </a>
    <div class="topbar-actions">
      <a class="btn btn-ghost topbar-link" href="index.php" data-i18n="nav_home">首页</a>
      <div class="lang-switch" role="group" aria-label="Language">
        <button type="button" class="lang-btn is-active" data-lang="zh" aria-pressed="true">中文</button>
        <button type="button" class="lang-btn" data-lang="en" aria-pressed="false">EN</button>
      </div>
    </div>
  </header>

  <main class="manual-shell">
    <header class="manual-hero">
      <p class="manual-kicker" data-i18n="manual_kicker">使用指南</p>
      <h1 data-i18n="manual_title">用户手册</h1>
      <p class="manual-lead" data-i18n="manual_lead">了解如何上传图片、预览结果并下载透明 PNG。</p>
    </header>

    <nav class="manual-toc" aria-label="Table of contents">
      <a href="#sec-overview" data-i18n="manual_toc_overview">功能概览</a>
      <a href="#sec-steps" data-i18n="manual_toc_steps">操作步骤</a>
      <a href="#sec-preview" data-i18n="manual_toc_preview">界面预览</a>
      <a href="#sec-tips" data-i18n="manual_toc_tips">使用技巧</a>
      <a href="#sec-faq" data-i18n="manual_toc_faq">常见问题</a>
    </nav>

    <div class="manual-body">
      <section class="manual-section" id="sec-overview">
        <h2 data-i18n="manual_overview_h">功能概览</h2>
        <p data-i18n="manual_overview_p">净影 ClearCut 使用 AI 识别图片主体并移除背景，输出带透明通道的 PNG，方便用于设计、电商与社交内容。</p>
        <div class="manual-cards">
          <article class="manual-card">
            <h3 data-i18n="manual_feat1_h">AI 智能抠图</h3>
            <p data-i18n="manual_feat1_p">自动识别人物、插画主体与产品，无需手动描边。</p>
          </article>
          <article class="manual-card">
            <h3 data-i18n="manual_feat2_h">一键处理</h3>
            <p data-i18n="manual_feat2_p">上传后点击开始即可，系统自动完成抠图与透明背景导出。</p>
          </article>
          <article class="manual-card">
            <h3 data-i18n="manual_feat3_h">透明 PNG</h3>
            <p data-i18n="manual_feat3_p">结果可直接下载，背景为透明，便于二次合成。</p>
          </article>
          <article class="manual-card">
            <h3 data-i18n="manual_feat4_h">中英双语</h3>
            <p data-i18n="manual_feat4_p">右上角随时切换语言，手册与主界面同步跟随。</p>
          </article>
        </div>
      </section>

      <section class="manual-section" id="sec-steps">
        <h2 data-i18n="manual_steps_h">操作步骤</h2>
        <ol class="manual-steps">
          <li>
            <strong data-i18n="manual_step1_t">打开首页</strong>
            <span data-i18n="manual_step1_d">进入净影 ClearCut 主页，确认语言为中文或 English。</span>
          </li>
          <li>
            <strong data-i18n="manual_step2_t">上传图片</strong>
            <span data-i18n="manual_step2_d">拖放图片到虚线区域，或点击「选择图片」。支持 JPG / PNG / WEBP / GIF，单张最大 8 MB。</span>
          </li>
          <li>
            <strong data-i18n="manual_step3_t">开始去背景</strong>
            <span data-i18n="manual_step3_d">点击「开始去背景」，等待进度条完成。处理时间取决于图片大小与服务器性能。</span>
          </li>
          <li>
            <strong data-i18n="manual_step4_t">预览并下载</strong>
            <span data-i18n="manual_step4_d">对比原图与去背景结果（棋盘格表示透明）。满意后点击「下载 PNG」。</span>
          </li>
          <li>
            <strong data-i18n="manual_step5_t">再传一张</strong>
            <span data-i18n="manual_step5_d">需要处理下一张时，点击「再传一张」返回上传界面。</span>
          </li>
        </ol>
      </section>

      <section class="manual-section" id="sec-preview">
        <h2 data-i18n="manual_preview_h">界面预览说明</h2>
        <div class="manual-preview-grid">
          <article class="manual-preview-item">
            <div class="manual-preview-visual manual-preview-upload" aria-hidden="true">
              <span class="pv-box"></span>
              <span class="pv-line"></span>
              <span class="pv-line short"></span>
            </div>
            <h3 data-i18n="manual_pv1_h">上传区</h3>
            <p data-i18n="manual_pv1_p">首页中央的大虚线框是上传入口。选中图片后会显示文件名与大小，并可清除重选。</p>
          </article>
          <article class="manual-preview-item">
            <div class="manual-preview-visual manual-preview-progress" aria-hidden="true">
              <span class="pv-bar"><span class="pv-bar-fill"></span></span>
              <span class="pv-line short"></span>
            </div>
            <h3 data-i18n="manual_pv2_h">处理进度</h3>
            <p data-i18n="manual_pv2_p">点击开始后会出现进度条。请稍候，AI 正在识别主体并生成透明背景。</p>
          </article>
          <article class="manual-preview-item">
            <div class="manual-preview-visual manual-preview-result" aria-hidden="true">
              <span class="pv-thumb"></span>
              <span class="pv-arrow">→</span>
              <span class="pv-main"></span>
            </div>
            <h3 data-i18n="manual_pv3_h">结果对比</h3>
            <p data-i18n="manual_pv3_p">结果页左右对照原图与去背景效果。棋盘格表示透明；下方可下载或再传一张。</p>
          </article>
        </div>
      </section>

      <section class="manual-section" id="sec-tips">
        <h2 data-i18n="manual_tips_h">使用技巧</h2>
        <ul class="manual-list">
          <li data-i18n="manual_tip1">主体尽量居中、清晰；主体过小或过糊时，识别效果会下降。</li>
          <li data-i18n="manual_tip2">淡色衣服贴在浅色背景上较难分离，尽量提高对比或换更清晰的原图。</li>
          <li data-i18n="manual_tip3">复杂风景、多主体同框时，AI 可能只保留主要人物；可裁剪后再上传。</li>
          <li data-i18n="manual_tip4">下载的 PNG 可在 Photoshop、Canva、PPT 等软件中继续编辑。</li>
        </ul>
      </section>

      <section class="manual-section" id="sec-faq">
        <h2 data-i18n="manual_faq_h">常见问题</h2>
        <div class="manual-faq">
          <details>
            <summary data-i18n="manual_faq1_q">支持哪些格式？</summary>
            <p data-i18n="manual_faq1_a">JPG、PNG、WEBP、GIF，最大 8 MB。输出统一为透明 PNG。</p>
          </details>
          <details>
            <summary data-i18n="manual_faq2_q">处理很慢怎么办？</summary>
            <p data-i18n="manual_faq2_a">大图会先缩小再处理。请耐心等待进度条；若长时间无响应，可缩小原图后重试。</p>
          </details>
          <details>
            <summary data-i18n="manual_faq3_q">身体或衣物被抠掉了？</summary>
            <p data-i18n="manual_faq3_a">可换更清晰、主体更大、对比更强的原图再试；复杂风景或多主体时可先裁剪。</p>
          </details>
          <details>
            <summary data-i18n="manual_faq4_q">手册语言如何切换？</summary>
            <p data-i18n="manual_faq4_a">点击右上角「中文 / EN」。语言会保存在浏览器中，并与首页保持一致。</p>
          </details>
          <details>
            <summary data-i18n="manual_faq5_q">为什么在虚拟主机也能用？</summary>
            <p data-i18n="manual_faq5_a">抠图在您的浏览器中完成，不依赖服务器安装 Python。只要网页能打开、网络可访问 CDN 即可。</p>
          </details>
        </div>
      </section>

      <p class="manual-back">
        <a class="btn btn-accent" href="index.php" data-i18n="manual_back">返回去背景</a>
      </p>
    </div>
  </main>

  <?php require __DIR__ . '/includes/footer.php'; ?>

  <script src="assets/js/i18n.js"></script>
  <script src="assets/js/manual.js"></script>
</body>
</html>

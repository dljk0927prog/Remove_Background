/**
 * Bilingual strings (zh / en) — shared by app + manual
 */
const I18N = {
  zh: {
    brand_zh: '净影',
    tagline: '一键移除背景，下载透明 PNG',
    drop_title: '拖放图片到此处，或点击选择',
    drop_hint: '支持 JPG / PNG / WEBP / GIF，最大 8 MB',
    browse: '选择图片',
    clear: '清除',
    process: '开始去背景',
    processing: 'AI 正在抠图，请稍候…',
    results_title: '去背景完成',
    results_sub: '预览结果后下载透明 PNG',
    original: '原图',
    again: '再传一张',
    download: '下载 PNG',
    footer: '浏览器 AI 抠图 · 透明 PNG · 中英双语',
    nav_home: '首页',
    nav_manual: '用户手册',
    err_type: '请选择 JPG、PNG、WEBP 或 GIF 图片。',
    err_size: '文件过大，最大支持 8 MB。',
    err_generic: '处理失败，请重试。',
    err_engine: '无法加载浏览器 AI 引擎，请检查网络后重试。',
    ok_done: '处理完成，可以下载了。',
    progress_upload: '正在准备…',
    progress_load: '正在加载 AI 引擎…',
    progress_model: '首次使用需下载模型，请稍候…',
    progress_work: 'AI 正在抠图…',
    manual_kicker: '使用指南',
    manual_title: '用户手册',
    manual_lead: '了解如何上传图片、预览结果并下载透明 PNG。',
    manual_toc_overview: '功能概览',
    manual_toc_steps: '操作步骤',
    manual_toc_preview: '界面预览',
    manual_toc_tips: '使用技巧',
    manual_toc_faq: '常见问题',
    manual_overview_h: '功能概览',
    manual_overview_p: '净影 ClearCut 使用 AI 识别图片主体并移除背景，输出带透明通道的 PNG，方便用于设计、电商与社交内容。',
    manual_feat1_h: 'AI 智能抠图',
    manual_feat1_p: '在浏览器中自动识别人物、插画主体与产品，无需手动描边。',
    manual_feat2_h: '一键处理',
    manual_feat2_p: '选择图片后点击开始即可，无需服务器安装 Python。',
    manual_feat3_h: '透明 PNG',
    manual_feat3_p: '结果可直接下载，背景为透明，便于二次合成。',
    manual_feat4_h: '中英双语',
    manual_feat4_p: '右上角随时切换语言，手册与主界面同步跟随。',
    manual_steps_h: '操作步骤',
    manual_step1_t: '打开首页',
    manual_step1_d: '进入净影 ClearCut 主页，确认语言为中文或 English。',
    manual_step2_t: '上传图片',
    manual_step2_d: '拖放图片到虚线区域，或点击「选择图片」。支持 JPG / PNG / WEBP / GIF，单张最大 8 MB。',
    manual_step3_t: '开始去背景',
    manual_step3_d: '点击「开始去背景」，等待进度条完成。处理时间取决于图片大小与服务器性能。',
    manual_step4_t: '预览并下载',
    manual_step4_d: '对比原图与去背景结果（棋盘格表示透明）。满意后点击「下载 PNG」。',
    manual_step5_t: '再传一张',
    manual_step5_d: '需要处理下一张时，点击「再传一张」返回上传界面。',
    manual_preview_h: '界面预览说明',
    manual_pv1_h: '上传区',
    manual_pv1_p: '首页中央的大虚线框是上传入口。选中图片后会显示文件名与大小，并可清除重选。',
    manual_pv2_h: '处理进度',
    manual_pv2_p: '点击开始后会出现进度条。请稍候，AI 正在识别主体并生成透明背景。',
    manual_pv3_h: '结果对比',
    manual_pv3_p: '结果页左右对照原图与去背景效果。棋盘格表示透明；下方可下载或再传一张。',
    manual_tips_h: '使用技巧',
    manual_tip1: '主体尽量居中、清晰；主体过小或过糊时，识别效果会下降。',
    manual_tip2: '淡色衣服贴在浅色背景上较难分离，尽量提高对比或换更清晰的原图。',
    manual_tip3: '复杂风景、多主体同框时，AI 可能只保留主要人物；可裁剪后再上传。',
    manual_tip4: '下载的 PNG 可在 Photoshop、Canva、PPT 等软件中继续编辑。',
    manual_faq_h: '常见问题',
    manual_faq1_q: '支持哪些格式？',
    manual_faq1_a: 'JPG、PNG、WEBP、GIF，最大 8 MB。输出统一为透明 PNG。',
    manual_faq2_q: '处理很慢怎么办？',
    manual_faq2_a: '首次使用会在浏览器下载 AI 模型，之后会更快。大图也会更慢；可缩小原图后重试。',
    manual_faq3_q: '身体或衣物被抠掉了？',
    manual_faq3_a: '可换更清晰、主体更大、对比更强的原图再试；复杂风景或多主体时可先裁剪。',
    manual_faq4_q: '手册语言如何切换？',
    manual_faq4_a: '点击右上角「中文 / EN」。语言会保存在浏览器中，并与首页保持一致。',
    manual_faq5_q: '为什么在虚拟主机也能用？',
    manual_faq5_a: '抠图在您的浏览器中完成，不依赖服务器安装 Python。只要网页能打开、网络可访问 CDN 即可。',
    manual_back: '返回去背景',
    result_label: '去背景结果',
  },
  en: {
    brand_zh: 'ClearCut',
    tagline: 'Remove the background and download a transparent PNG',
    drop_title: 'Drop an image here, or click to browse',
    drop_hint: 'JPG / PNG / WEBP / GIF · max 8 MB',
    browse: 'Choose image',
    clear: 'Clear',
    process: 'Remove background',
    processing: 'AI is cutting out the subject…',
    results_title: 'Done',
    results_sub: 'Preview the result, then download the transparent PNG',
    original: 'Original',
    again: 'Upload another',
    download: 'Download PNG',
    footer: 'Browser AI cutout · Transparent PNG · ZH / EN',
    nav_home: 'Home',
    nav_manual: 'User Manual',
    err_type: 'Please choose a JPG, PNG, WEBP or GIF image.',
    err_size: 'File too large. Maximum size is 8 MB.',
    err_generic: 'Processing failed. Please try again.',
    err_engine: 'Could not load the browser AI engine. Check your network and retry.',
    ok_done: 'Done — ready to download.',
    progress_upload: 'Preparing…',
    progress_load: 'Loading AI engine…',
    progress_model: 'First run downloads the model — please wait…',
    progress_work: 'AI cutout in progress…',
    manual_kicker: 'Guide',
    manual_title: 'User Manual',
    manual_lead: 'Learn how to upload, preview, and download a transparent PNG.',
    manual_toc_overview: 'Overview',
    manual_toc_steps: 'Steps',
    manual_toc_preview: 'UI Preview',
    manual_toc_tips: 'Tips',
    manual_toc_faq: 'FAQ',
    manual_overview_h: 'Overview',
    manual_overview_p: 'ClearCut uses AI to detect the main subject, remove the background, and export a transparent PNG for design, commerce, and social use.',
    manual_feat1_h: 'AI cutout',
    manual_feat1_p: 'Automatically detects people, illustration subjects, and products — no manual tracing.',
    manual_feat2_h: 'One-click process',
    manual_feat2_p: 'Upload and click start — the system handles cutout and transparent export for you.',
    manual_feat3_h: 'Transparent PNG',
    manual_feat3_p: 'Download a ready-to-use PNG with a clear background for compositing.',
    manual_feat4_h: 'ZH / EN',
    manual_feat4_p: 'Switch language anytime; the manual stays in sync with the main app.',
    manual_steps_h: 'How to use',
    manual_step1_t: 'Open Home',
    manual_step1_d: 'Go to the ClearCut home page and set Chinese or English.',
    manual_step2_t: 'Upload an image',
    manual_step2_d: 'Drop a file into the dashed area or click Choose image. JPG / PNG / WEBP / GIF, max 8 MB.',
    manual_step3_t: 'Remove background',
    manual_step3_d: 'Click Remove background and wait for the progress bar. Time depends on image size and server speed.',
    manual_step4_t: 'Preview & download',
    manual_step4_d: 'Compare the original with the result. Checkerboard means transparency. Then download PNG.',
    manual_step5_t: 'Upload another',
    manual_step5_d: 'Click Upload another to return to the upload screen for the next image.',
    manual_preview_h: 'Interface preview',
    manual_pv1_h: 'Upload area',
    manual_pv1_p: 'The large dashed box is the upload zone. After selecting a file, you will see its name and size, and can clear it.',
    manual_pv2_h: 'Progress',
    manual_pv2_p: 'After you start, a progress bar appears while AI detects the subject and builds a transparent PNG.',
    manual_pv3_h: 'Side-by-side result',
    manual_pv3_p: 'The result page compares original and cutout. Checkerboard means transparent. Download or upload another below.',
    manual_tips_h: 'Tips',
    manual_tip1: 'Keep the subject centered and sharp. Tiny or blurry subjects are harder to detect.',
    manual_tip2: 'Pale clothes on a light background are hard to separate — raise contrast or use a clearer source image.',
    manual_tip3: 'Busy scenes or multiple subjects may keep only the main person — crop first, then upload.',
    manual_tip4: 'Open the PNG in Photoshop, Canva, PowerPoint, and similar tools for further editing.',
    manual_faq_h: 'FAQ',
    manual_faq1_q: 'Which formats are supported?',
    manual_faq1_a: 'JPG, PNG, WEBP, and GIF up to 8 MB. Output is always a transparent PNG.',
    manual_faq2_q: 'Why is processing slow?',
    manual_faq2_a: 'The first run downloads the AI model in your browser; later runs are faster. Large images also take longer — try a smaller file.',
    manual_faq3_q: 'Body or clothing was removed?',
    manual_faq3_a: 'Try a clearer image with a larger subject and stronger contrast; crop busy multi-subject scenes first.',
    manual_faq4_q: 'How do I change manual language?',
    manual_faq4_a: 'Use 中文 / EN in the top-right. The choice is saved in your browser and matches the home page.',
    manual_faq5_q: 'Why does this work on shared hosting?',
    manual_faq5_a: 'Cutout runs in your browser. The server only hosts the website — no Python install is required.',
    manual_back: 'Back to cutout',
    result_label: 'Result',
  },
};

function detectDefaultLang() {
  const stored = localStorage.getItem('clearcut_lang');
  if (stored === 'zh' || stored === 'en') return stored;
  const nav = (navigator.language || '').toLowerCase();
  return nav.startsWith('zh') ? 'zh' : 'en';
}

window.ClearCutI18n = {
  lang: detectDefaultLang(),
  t(key) {
    const pack = I18N[this.lang] || I18N.zh;
    return pack[key] ?? I18N.zh[key] ?? key;
  },
  setLang(lang) {
    if (!I18N[lang]) return;
    this.lang = lang;
    localStorage.setItem('clearcut_lang', lang);
    document.documentElement.lang = lang === 'zh' ? 'zh-CN' : 'en';
    document.querySelectorAll('[data-i18n]').forEach((el) => {
      const key = el.getAttribute('data-i18n');
      if (key) el.textContent = this.t(key);
    });
    document.querySelectorAll('.lang-btn').forEach((btn) => {
      const active = btn.getAttribute('data-lang') === lang;
      btn.classList.toggle('is-active', active);
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
    });
    if (!document.body.classList.contains('page-manual')) {
      document.title = lang === 'zh'
        ? '净影 ClearCut — 图片去背景'
        : 'ClearCut — Remove Image Background';
    }
    document.dispatchEvent(new CustomEvent('i18n:changed'));
  },
};

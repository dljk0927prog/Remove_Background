/**
 * Client-side AI background removal (works on iFastNet shared hosting).
 * Uses @imgly/background-removal in the browser — no Python / rembg on server.
 */
(() => {
  const i18n = window.ClearCutI18n;
  const MAX_BYTES = 8 * 1024 * 1024;
  const IMGLY_ESM = 'https://cdn.jsdelivr.net/npm/@imgly/background-removal@1.7.0/+esm';

  const form = document.getElementById('upload-form');
  const input = document.getElementById('image-input');
  const dropArea = document.getElementById('drop-area');
  const browseBtn = document.getElementById('browse-btn');
  const processBtn = document.getElementById('process-btn');
  const clearBtn = document.getElementById('clear-btn');
  const previewStrip = document.getElementById('preview-strip');
  const previewThumb = document.getElementById('preview-thumb');
  const previewName = document.getElementById('preview-name');
  const previewSize = document.getElementById('preview-size');
  const progressPanel = document.getElementById('progress-panel');
  const progressFill = document.getElementById('progress-fill');
  const progressBar = document.getElementById('progress-bar');
  const progressText = document.getElementById('progress-text');
  const resultsSection = document.getElementById('results-section');
  const originalPreview = document.getElementById('original-preview');
  const resultPreview = document.getElementById('result-preview');
  const downloadBtn = document.getElementById('download-btn');
  const againBtn = document.getElementById('again-btn');
  const statusMsg = document.getElementById('status-msg');
  const uploadSection = document.getElementById('upload-section');

  let selectedFile = null;
  let objectUrl = null;
  let resultObjectUrl = null;
  let removeBackgroundFn = null;

  function showStatus(message, type) {
    statusMsg.hidden = false;
    statusMsg.textContent = message;
    statusMsg.classList.remove('is-error', 'is-ok');
    statusMsg.classList.add(type === 'error' ? 'is-error' : 'is-ok');
  }

  function hideStatus() {
    statusMsg.hidden = true;
    statusMsg.textContent = '';
  }

  function formatSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
  }

  function setProgress(pct, labelKey) {
    const value = Math.max(0, Math.min(100, pct));
    progressFill.style.width = value + '%';
    progressBar.setAttribute('aria-valuenow', String(Math.round(value)));
    if (labelKey) progressText.textContent = i18n.t(labelKey);
  }

  function setProgressText(text) {
    progressText.textContent = text;
  }

  function resetFile() {
    selectedFile = null;
    input.value = '';
    if (objectUrl) {
      URL.revokeObjectURL(objectUrl);
      objectUrl = null;
    }
    previewStrip.hidden = true;
    processBtn.disabled = true;
    dropArea.hidden = false;
  }

  function acceptFile(file) {
    if (!file) return;
    const okType = /^image\/(jpeg|png|webp|gif)$/i.test(file.type)
      || /\.(jpe?g|png|webp|gif)$/i.test(file.name);
    if (!okType) {
      showStatus(i18n.t('err_type'), 'error');
      return;
    }
    if (file.size > MAX_BYTES) {
      showStatus(i18n.t('err_size'), 'error');
      return;
    }
    hideStatus();
    selectedFile = file;
    if (objectUrl) URL.revokeObjectURL(objectUrl);
    objectUrl = URL.createObjectURL(file);
    previewThumb.src = objectUrl;
    previewThumb.alt = file.name;
    previewName.textContent = file.name;
    previewSize.textContent = formatSize(file.size);
    previewStrip.hidden = false;
    dropArea.hidden = true;
    processBtn.disabled = false;
  }

  function showResults(originalSrc, resultSrc, downloadHref) {
    uploadSection.hidden = true;
    progressPanel.hidden = true;
    resultsSection.hidden = false;
    originalPreview.src = originalSrc;
    resultPreview.src = resultSrc;
    downloadBtn.href = downloadHref;
    downloadBtn.setAttribute('download', 'no-bg.png');
    downloadBtn.textContent = i18n.t('download');
    showStatus(i18n.t('ok_done'), 'ok');
    resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function resetAll() {
    resetFile();
    if (resultObjectUrl) {
      URL.revokeObjectURL(resultObjectUrl);
      resultObjectUrl = null;
    }
    resultsSection.hidden = true;
    progressPanel.hidden = true;
    uploadSection.hidden = false;
    hideStatus();
    setProgress(0, 'processing');
    uploadSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  async function loadEngine() {
    if (removeBackgroundFn) return removeBackgroundFn;
    setProgress(8, 'progress_load');
    const mod = await import(IMGLY_ESM);
    removeBackgroundFn = mod.removeBackground || mod.default;
    if (typeof removeBackgroundFn !== 'function') {
      throw new Error(i18n.t('err_engine'));
    }
    return removeBackgroundFn;
  }

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.addEventListener('click', () => i18n.setLang(btn.getAttribute('data-lang')));
  });
  document.addEventListener('i18n:changed', () => {
    if (!downloadBtn.getAttribute('href') || downloadBtn.getAttribute('href') === '#') return;
    downloadBtn.textContent = i18n.t('download');
    if (!progressPanel.hidden) progressText.textContent = i18n.t('processing');
  });
  i18n.setLang(i18n.lang);

  browseBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    input.click();
  });
  dropArea.addEventListener('click', () => input.click());
  input.addEventListener('change', () => {
    if (input.files && input.files[0]) acceptFile(input.files[0]);
  });
  clearBtn.addEventListener('click', () => {
    resetFile();
    hideStatus();
  });
  againBtn.addEventListener('click', resetAll);

  ['dragenter', 'dragover'].forEach((evt) => {
    dropArea.addEventListener(evt, (e) => {
      e.preventDefault();
      e.stopPropagation();
      dropArea.classList.add('is-dragover');
    });
  });
  ['dragleave', 'drop'].forEach((evt) => {
    dropArea.addEventListener(evt, (e) => {
      e.preventDefault();
      e.stopPropagation();
      dropArea.classList.remove('is-dragover');
    });
  });
  dropArea.addEventListener('drop', (e) => {
    const file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
    if (file) acceptFile(file);
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!selectedFile || processBtn.disabled) return;

    hideStatus();
    resultsSection.hidden = true;
    progressPanel.hidden = false;
    processBtn.disabled = true;
    setProgress(5, 'progress_load');

    try {
      const removeBackground = await loadEngine();
      setProgress(18, 'progress_work');

      const blob = await removeBackground(selectedFile, {
        progress: (key, current, total) => {
          if (!total) return;
          const ratio = current / total;
          // Model fetch / inference progress
          if (String(key).includes('fetch') || String(key).includes('download')) {
            setProgress(18 + Math.round(ratio * 42), 'progress_model');
            setProgressText(i18n.t('progress_model'));
          } else {
            setProgress(60 + Math.round(ratio * 35), 'progress_work');
          }
        },
      });

      if (resultObjectUrl) URL.revokeObjectURL(resultObjectUrl);
      resultObjectUrl = URL.createObjectURL(blob);

      const originalSrc = objectUrl || URL.createObjectURL(selectedFile);
      setProgress(100, 'processing');
      showResults(originalSrc, resultObjectUrl, resultObjectUrl);
    } catch (err) {
      console.error(err);
      progressPanel.hidden = true;
      showStatus((err && err.message) ? err.message : i18n.t('err_generic'), 'error');
      processBtn.disabled = !selectedFile;
    }
  });
})();

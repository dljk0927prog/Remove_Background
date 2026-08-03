/**
 * Manual page language switcher (shares ClearCutI18n).
 */
(() => {
  const i18n = window.ClearCutI18n;
  if (!i18n) return;

  document.querySelectorAll('.lang-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      i18n.setLang(btn.getAttribute('data-lang'));
      document.title = i18n.lang === 'zh'
        ? '用户手册 — 净影 ClearCut'
        : 'User Manual — ClearCut';
    });
  });

  i18n.setLang(i18n.lang);
  document.title = i18n.lang === 'zh'
    ? '用户手册 — 净影 ClearCut'
    : 'User Manual — ClearCut';
})();

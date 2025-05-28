import './bootstrap';

// 禁用 F12、Ctrl+Shift+I、Ctrl+U、右鍵選單
document.addEventListener('keydown', function (e) {
  if (
    e.key === 'F12' ||
    (e.ctrlKey && e.shiftKey && e.key === 'I') ||
    (e.ctrlKey && e.key === 'U') ||
    (e.ctrlKey && e.shiftKey && e.key === 'J')
  ) {
    e.preventDefault();
    alert('已禁止開發者工具快捷鍵');
  }
});

document.addEventListener('contextmenu', function (e) {
  e.preventDefault();
  alert('已禁用右鍵選單');
});

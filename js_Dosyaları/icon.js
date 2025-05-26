function updateFavicon(newFaviconUrl) {
  const favicon = document.querySelector('link[rel="icon"]') || document.createElement('link');
  favicon.type = 'image/png';
  favicon.rel = 'icon';
  favicon.href = newFaviconUrl;
  document.head.appendChild(favicon);
}

// Yeni Favicon URL'si
updateFavicon('../logo.png');
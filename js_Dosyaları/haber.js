// Yeni etiketler eklenmeye başladığında bunu gözlemleyecek fonksiyon
document.addEventListener("DOMContentLoaded", function () {
  // MutationObserver'ı oluşturuyoruz
  const observer = new MutationObserver(function (mutationsList, observer) {
    mutationsList.forEach(function (mutation) {
      mutation.addedNodes.forEach(function (node) {
        // Sadece a etiketleri eklenirse, target ve rel ekliyoruz
        if (node.tagName === 'A') {
          node.setAttribute('target', '_blank');
          node.setAttribute('rel', 'noopener noreferrer');
        }
      });
    });
  });

  // Gözlemleyeceğimiz element
  const targetNode = document.body;

  // Observer'ı başlatıyoruz
  observer.observe(targetNode, {
    childList: true,  // Yeni child elemanlar eklenirse gözlemler
    subtree: true     // Alt elemanları da gözlemler
  });
});

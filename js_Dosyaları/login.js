document.addEventListener('DOMContentLoaded', function () {
  function showLogin() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('signupForm').style.display = 'none';
  }

  function showSignup() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('signupForm').style.display = 'block';
  }

  // Giriş formu işlemi
  const lform = document.getElementById('login-form');
  lform.addEventListener('submit', function (event) {
    const email = document.getElementById('login-email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
      alert("Lütfen geçerli bir e-posta adresi giriniz.");
      event.preventDefault();

    } else {
      lform.submit();
    }
  });

  // Kayıt formu işlemi
  let sForm = document.getElementById('signup-form');
  sForm.addEventListener('submit', function (event) {

    const email = document.getElementById('signup-email').value;
    const password = document.querySelector('input[type="password"]:nth-child(4)').value; // Şifre
    const confirmPassword = document.querySelector('input[type="password"]:nth-child(5)').value; // Şifre Tekrarı

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z]).{6,}$/; // En az 6 karakter, bir küçük harf ve bir büyük harf içermeli

    // E-posta geçerliliği kontrolü
    if (!emailRegex.test(email)) {
      alert("Lütfen geçerli bir e-posta adresi giriniz.");
      event.preventDefault();
      return;
    }

    // Şifrelerin uyuşup uyuşmadığını kontrol et
    if (password !== confirmPassword) {
      alert("Şifreler eşleşmiyor!");
      event.preventDefault();
      return;
    }

    // Şifrenin geçerli formatta olup olmadığını kontrol et
    if (!passwordRegex.test(password)) {
      alert("Şifre en az 6 karakter olmalı ve bir büyük harf, bir küçük harf içermelidir.");
      event.preventDefault();
      return;
    }
    sForm.submit();
  });

  // Geçiş fonksiyonlarını global olarak tanımla
  window.showLogin = showLogin;
  window.showSignup = showSignup;
});

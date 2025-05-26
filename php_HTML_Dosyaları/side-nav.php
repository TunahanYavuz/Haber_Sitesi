<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <script src="https://kit.fontawesome.com/59361a46cb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css_Dosyaları/side-nav.css">
  <script src="../js_Dosyaları/side-nav.js"></script>
</head>
<body>

<nav class="nav">
  <ul class="nav-list">
    <li id="logo" class="nav-element"><a href="../php_HTML_Dosyaları/Anasayfa.php"><img style="width: 70px" src="../logo.png" alt="logo"></a> </li>
    <li class="nav-element"><a href="yazarlar.php">Yazarlar</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=28">Gündem</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=18">Borsa</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=2">Spor</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=29">Hayat</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=14">Dünya</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=16">Ekonomi</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=30">Astroloji</a></li>
    <li class="nav-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=48">Sağlık</a></li>
    <li id="diger" class="nav-element">Diğer</li>
    <li id="arama" class="nav-element"><a href="aramasayfasi.php"><i style="width: 20px; height: 20px"
                                                                     class="fa-solid fa-magnifying-glass"></i></a>
    </li>
    <?php
    if(isset($_SESSION["login"])&& $_SESSION["login"]):?>
    <li id="giris" class="nav-element"><a href="../php_HTML_Dosyaları/logout.php">Çıkış Yap</a></li>
  <?php else:?>
    <li id="giris" class="nav-element"><a href="giris.html">Giriş Yap</a></li>
  <?php endif;?>

      <?php
    if(isset($_SESSION["login"]) && $_SESSION["login"] && $_SESSION["Unvan"]==="Yazar"):?>
    <li id="giris" class="nav-element"><a href="../php_HTML_Dosyaları/Admin-Panel.php">Panel</a></li>
  <?php endif;?>
  </ul>
</nav>
<div class="sidebar">
  <ul class="sidebar-list">
    <li class="sidebar-element"><a href="yazarlar.php">Yazarlar</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=28">Gündem</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=18">Borsa</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=2">Spor</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=29">Hayat</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=14">Dünya</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=16">Ekonomi</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=30">Astroloji</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=48">Sağlık</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=36">Yaşam</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=38">Kültür Sanat</a></li>
    <li class="sidebar-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=39">Magazin</a></li>
  </ul>
</div>
<script src="../js_Dosyaları/side-nav.js"></script>
<script src="../js_Dosyaları/icon.js"></script>
</body>
</html>
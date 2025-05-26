<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Keskin Kalem</title>
  <link rel="stylesheet" href="../css_Dosyaları/Anasayfa.css" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php require "../php_HTML_Dosyaları/side-nav.php"?>

<main>
  <div class="row">
    <div class="grid-container">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "habersitesi_db";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $sql = "SELECT * FROM haberler  where oncelik = 1 order by OlusturulmaTarihi desc limit 4";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

          $KapakFoto = base64_encode($row["KapakFotografi"]);

          ?>

      <div class="ust-haber">
        <div class="img"><a href="../php_HTML_Dosyaları/haber.php?id=<?=$row["HaberID"]?>"><img src="data:image/png;base64,<?=$KapakFoto?>" alt="Haber görseli"></a>
        </div>
        <div class="text"><?= $row["Baslik"] ?></div>
      </div>
        <?php }
        }
        ?>
    </div>
      <div class="center-row">
        <div class="gundem-haber">
          <div class="swiper">
            <?php
            $sql = "SELECT * FROM haberler  where oncelik = 0 order by OlusturulmaTarihi desc limit 20";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $KapakFoto = base64_encode($row["KapakFotografi"]);
                ?>
            <div class="haber">
              <a href="../php_HTML_Dosyaları/haber.php?id=<?=$row["HaberID"]?> "><img src="data:image/png;base64,<?=$KapakFoto?>"></a>
              <span class="title-container">
                <span class="title-top"><h2><?=$row["UstYazi"]?></h2></span>
                <span class="title-bottom">
                  <span class="cizgi"></span>
                    <h2><?=$row["AltYazi"]?></h2>
                  </span>
              </span>
            </div>
            <?php
            }
            }
            ?>
          </div>

          <div class="left-button">
            <button class="left"><</button>
          </div>
          <div class="right-button">
            <button class="right">></button>
          </div>
        </div>
        <div class="center-right">
            <?php
            $sql = "SELECT * FROM haberler  where oncelik = 2 order by OlusturulmaTarihi desc limit 2";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $KapakFoto = base64_encode($row["KapakFotografi"]);
                    ?>

                  <div class="center-right-content">
                    <div class="img"><a href="../php_HTML_Dosyaları/haber.php?id=<?=$row["HaberID"]?>"><img src="data:image/png;base64,<?=$KapakFoto?>" alt="Haber görseli"></a>
                    </div>
                    <div class="text"><?= $row["Baslik"] ?></div>
                  </div>
                <?php }
            }
            ?>
        </div>
      </div>
    </div>
    <footer>
      <ul class="footer-list">
        <li class="footer-element"><a href="yazarlar.php">Yazarlar</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=28">Gündem</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=18">Borsa</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=2">Spor</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=29">Hayat</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=14">Dünya</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=16">Ekonomi</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=30">Astroloji</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=48">Sağlık</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=36">Yaşam</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=38">Kültür Sanat</a></li>
        <li class="footer-element"><a href="../php_HTML_Dosyaları/Kategori.php?id=39">Magazin</a></li>
      </ul>
    </footer>
</main>
<footer class="footer">
  <p>&copy; 2024 Haber Sayfası. Tüm Hakları Saklıdır.</p>
</footer>
<script src="../js_Dosyaları/Anasayfa.js"></script>
</body>
</html>
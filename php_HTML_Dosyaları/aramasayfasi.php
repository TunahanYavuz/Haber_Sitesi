<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="../logo.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arama Sayfası</title>
  <link rel="stylesheet" href="../css_Dosyaları/aramasayfasi.css">
  <link rel="stylesheet" href="../css_Dosyaları/side-nav.css">
  <script src="https://kit.fontawesome.com/59361a46cb.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
require "../php_HTML_Dosyaları/side-nav.php";
?>
<div class="container">
  <h1>Arama</h1>
  <div class="search-box">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
    <label>
      <input type="text" name="arama_input" placeholder="Ara">
    </label>
    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
  <div class="arama-sonucu-container">
    <?php
    if (isset($_POST["arama_input"])||isset($_GET["arama_input"])) {
        $current_page = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
        $limit = 20;
        $offset = ($current_page - 1) * $limit;


        // Kullanıcının arama girişi
        $input = $_POST["arama_input"] ?? ($_GET["arama_input"] ?? "");

        // Kelime parçalarını oluştur
        $words = explode(" ", $input);
        $combinations = [];

        // 1. Tüm kombinasyonları oluştur (en uzunlardan kısalara)
        for ($length = count($words); $length >= 1; $length--) {
            for ($i = 0; $i <= count($words) - $length; $i++) {
                $slice = array_slice($words, $i, $length);
                $phrase = implode(" ", $slice);
                $combinations[] = $phrase;
            }
        }

        // Tekrarları kaldır ve SQL için hazırla
        $combinations = array_unique($combinations);

        // SQL parçası oluştur
        $sql_parts = [];
        foreach ($combinations as $phrase) {
            // Güvenlik için özel karakterleri temizle (ya da parametreli çalış)
            $escaped = addslashes($phrase);
            $sql_parts[] = "(Ozet LIKE '%$escaped%' OR Baslik LIKE '%$escaped%')";}

        // SQL'i birleştir
        $where_sql = implode(" OR ", $sql_parts);

        // Sıralama: eşleşme uzunluğuna göre sıralamak için CASE kullan
        $order_case = [];
        foreach ($combinations as $i => $phrase) {
            $escaped = addslashes($phrase);
            // Uzun olan eşleşmeye daha büyük puan ver
            $score = strlen($phrase); // ya da count(explode(" ", $phrase))
            $order_case[] = "WHEN Ozet LIKE '%$escaped%' THEN $score";
            $order_case[] = "WHEN Baslik LIKE '%$escaped%' THEN $score";
        }

        $order_sql = "CASE " . implode(" ", $order_case) . " ELSE 0 END DESC";

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "habersitesi_db";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $count_sql = "SELECT COUNT(*) as toplam FROM haberler WHERE $where_sql";
        $count_result = $conn->query($count_sql);
        $row = $count_result->fetch_assoc();
        $total_rows = $row['toplam'];
        $total_pages = ceil($total_rows / $limit);
        $final_sql = "SELECT * FROM haberler WHERE $where_sql ORDER BY $order_sql LIMIT $limit OFFSET $offset";
        $result = $conn->query($final_sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $kapakFoto = base64_encode($row["KapakFotografi"]);?>
              <div class="arama-sonucu">
                  <a target="_blank" href="haber.php?id=<?=$row["HaberID"]?>" class="more">
                    <img src="data:image/png;base64,<?=$kapakFoto?>" alt="">
                    <h2><?=$row["Baslik"]?></h2>
                    <p>
                        <?=$row["Ozet"]?>
                    </p></a>
              </div>
          <?php }?>
  </div>
  <?php
        }
        if ($total_pages > 1) {
              echo '<div class="sayfa-numaralari">';
              for ($i = 1; $i <= $total_pages; $i++) {
                  $active = $i == $current_page ? 'style="font-weight:bold;text-decoration:underline;"' : '';
                  $arama_encoded = urlencode($input);?>
                  <form action="<?=$_SERVER["PHP_SELF"]?>" method="get"><a href="?sayfa=<?=$i?>&arama_input=<?=$arama_encoded?>" <?=$active?>> <?=$i?></a></form>
              <?php }
              echo '</div>';
          }
    }
    ?>
  <div class="categories">
    <h2>Kategoriler</h2>
    <div class="grid">
      <a href="yazarlar.php">Yazarlar</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=28">Gündem</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=18">Borsa</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=2">Spor</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=29">Hayat</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=14">Dünya</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=16">Ekonomi</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=30">Astroloji</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=48">Sağlık</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=36">Yaşam</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=38">Kültür Sanat</a>
      <a href="../php_HTML_Dosyaları/Kategori.php?id=39">Magazin</a>
    </div>
  </div>
</div>
</body>
<footer>
  <img src="../img_Dosyaları/WhatsApp%20Görsel%202024-12-23%20saat%2019.37.34_6a10303b.jpg" alt="avatar">
</footer>
<script src="../js_Dosyaları/side-nav.js"></script>

</html>

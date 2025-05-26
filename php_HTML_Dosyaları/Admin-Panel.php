<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link type="text/css" href="../css_Dosyaları/Admin-Panel.css" rel="stylesheet">

  <title>Admin Panel</title>
</head>
<body>
<?php
require "../php_HTML_Dosyaları/side-nav.php";
if (!isset($_SESSION["Unvan"])|| !$_SESSION["Unvan"] == "admin"){
  header("Location: Anasayfa.php");
  exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habersitesi_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM Haberler order by HaberID desc";
$result = $conn->query($sql);
?>
  <main>
      <span class="haber-sayisi"><?=$result->num_rows?></span>
    <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $kapakFoto = base64_encode($row["KapakFotografi"]); ?>
          <div class="panel-haber-satır">
            <div class="haber-img"><a href="../php_HTML_Dosyaları/haber.php?id=<?=$row["HaberID"]?>"><img src="data:image/png;base64,<?=$kapakFoto?>"></a></div>
            <div class="haber-icerik">
              <div class="hero-baslik">
                <div class="baslik-message">Haber Başlığı</div>
                <div class="baslik"><?=$row["Baslik"]?></div>
              </div>
              <div class="hero-tarih">
                <div class="tarih-message">Yayınlanma Tarihi</div>
                <div class="tarih"><?=$row["OlusturulmaTarihi"]?></div>
              </div>
            </div>
            <div class="update-delete">
              <div class="delete"><a href="haberSil.php?id=<?=$row["HaberID"]?>">Sil</a></div>
              <div class="update"><a href="haberDuzenle.php?id=<?=$row["HaberID"]?>">Güncelle</a></div>
            </div>
          </div>
          <?php
        }
      }
    ?>
    <div class="haber-gir"><a href="../php_HTML_Dosyaları/HaberGir.php">Haber Oluştur</a></div>
  </main>

</body>
</html>
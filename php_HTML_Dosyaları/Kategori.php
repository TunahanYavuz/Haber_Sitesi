<?php
  require "../php_HTML_Dosyaları/side-nav.php";
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "habersitesi_db";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if ($_GET["id"])
  $kategoriID = $_GET["id"];
  else{
    header("Location:Anasayfa.php");
    exit();
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori Sayfası</title>
  <link rel="stylesheet" href="../css_Dosyaları/Kategori.css">
</head>
<body>

<?php
  $sql = "SELECT * FROM haberler h inner join haberkategori hk on h.HaberID = hk.HaberID where hk.KategoriID = $kategoriID order by h.HaberID desc";
  $result = $conn->query($sql);
?>
<main>
  <div class="hero-news">
  <?php if ($result->num_rows >0){
    while($row = $result->fetch_assoc()){
      $kapakFoto = base64_encode($row["KapakFotografi"]);
      ?>
      <article class="news">
        <a href="haber.php?id=<?=$row["HaberID"]?>" class="more">
        <img src="data:image/png;base64,<?=$kapakFoto?>" alt="">
        <h2><?=$row["Baslik"]?></h2>
        <p>
          <?=$row["Ozet"]?>
        </p></a>
      </article>
      <?php
    }
  }?>
  </div>

  <aside>
    <h3>Popüler Haberler</h3>

    <?php
      $sql = "SELECT * FROM haberler where Oncelik = 0 order by HaberID desc limit 8";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $kapakFoto = base64_encode($row["KapakFotografi"]);?>
            <div class="popular-news">
              <a href="haber.php?id=<?=$row["HaberID"]?>" class="more">
              <img src="data:image/png;base64,<?=$kapakFoto?>" alt="">
              <h2><?=$row["Baslik"]?></h2>
              <p>
                <?=$row["Ozet"]?>
              </p></a>
            </div>


          <?php
        }
      }
      ?>

  </aside>

</main>
<script src="../js_Dosyaları/side-nav.js"></script>

</body>
</html>
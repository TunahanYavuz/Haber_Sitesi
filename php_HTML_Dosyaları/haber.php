<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habersitesi_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM haberler WHERE HaberID = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$row["Baslik"]?></title>
    <link rel="stylesheet" href="../css_Dosyaları/haber.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <?php
      require "../php_HTML_Dosyaları/side-nav.php"
    ?>
    <main class="container">
        <article class="haber-detay">
          <?php
            if ($result->num_rows > 0) {?>
              <h2><?=$row["Baslik"]?></h2>
              <p class="tarih"><?=$row["OlusturulmaTarihi"]?></p>
              <p><b><?=$row["Ozet"]?></b></p>
              <?php
            }
            else{
              header("Location: ../Ana_sayfa/Anasayfa.php");
              exit();
            }
            ?>

          <?php
          $sql = "SELECT * FROM haberlerfotograf WHERE HaberID = '$id'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $i = 0;
              while ($row = $result->fetch_assoc()) {
                  $HaberFoto = base64_encode($row["Fotograf"]);
                  ?>

                <img style="width: 760px; height: 450px" src="data:image/png;base64,<?=$HaberFoto?>">

                <p class="icerik"><?=$row["Aciklama"]?></p>
                  <?php
                  $i++;
              }
          }
          ?>
        </article>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Haber Sayfası. Tüm Hakları Saklıdır.</p>
    </footer>
<script src="../js_Dosyaları/haber.js"></script>

</body>
</html>
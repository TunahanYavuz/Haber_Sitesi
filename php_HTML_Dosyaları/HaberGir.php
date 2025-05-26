<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habersitesi_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM Kategoriler";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fotoğraf Yükle</title>
  <link rel="stylesheet" href="../css_Dosyaları/haber-gir.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/59361a46cb.js" crossorigin="anonymous"></script>
</head>
<body>
<?php require "../php_HTML_Dosyaları/side-nav.php"?>
<form method="post" name="form" action="haberOlustur.php" target="_blank">
  <div class="haberPreview"> <label for="haberPreview" ><i class="fa-solid fa-question"></i></label>
  </div>
  <input type="submit" id="haberPreview" hidden="hidden">
  <div>
  <label>
    Haber Türünü Seçiniz:
    <select id="haberTuru" name="HaberTuru" required>
      <option value="1">Tepe</option>
      <option value="0">Gündem</option>
      <option value="2">Yan</option>
    </select>
    </label>
<div class="kategorilerDiv">
      <label for="kategoriler"> Kategori Seçiniz:</label>
        <div class="kategorilerDiv2">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {?>
              <label><input  type="checkbox" name="Kategori[]" value="<?=$row["KategoriID"]?>"><?=$row["KategoriAdi"]?></label>
                <?php }} ?>
        </div>
</div>
</div>
  <label>
    Haber Başlığı:
    <input required type="text" placeholder="Haber başlığı giriniz" name="Baslik" id="Baslik">
  </label>
  <div id="turSecim"></div>
  <label>
    Haber Özeti:
    <input required type="text" placeholder="Haber özetini giriniz" name="Ozet" id="Ozet">
  </label>
  <div class="kapakFotoPreview">
    <input type="file" id="fileInputKF" style="display: none" accept="image/*">
    <label for="fileInputKF">
      Kapak Fotoğrafı:
      <i class="fa-solid fa-upload"></i></label>
  </div>
  <br>
  <br>
  <br>
  <label for="submitButton" style="background-color: lightgreen">Gönder</label>
  <input type="submit" id="submitButton" style="display: none">
  <br>

  <input type="file" id="fileInput" style="display: none" accept="image/*">
  <label for="fileInput">
    Fotoğraf Yükle:
    <i class="fa-solid fa-upload"></i></label>
  <div id="preview">
  </div>
  <span id="inputs"></span>
</form>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="../js_Dosyaları/haber-gir.js"></script>
</body>
</html>

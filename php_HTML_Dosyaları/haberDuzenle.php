<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Haber Düzenle</title>
    <link rel="stylesheet" href="../css_Dosyaları/haber-gir.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/59361a46cb.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
session_start();
if(isset($_SESSION["login"])&&$_SESSION["login"]&&$_SESSION["Unvan"] == "Yazar"){
    session_abort();
    $id = $_GET["id"];
    require "../php_HTML_Dosyaları/side-nav.php";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "habersitesi_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "select * from haberler where HaberId = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
else {
    header("Location: ../php_HTML_Dosyaları/Anasayfa.php");
    exit();
}

?>
<form method="post" name="form" action="haberGuncelle.php?id=<?=$id?>" target="_blank">
    <div class="haberPreview"> <label for="haberPreview" ><i class="fa-solid fa-question"></i></label>
    </div>
    <input type="submit" id="haberPreview" hidden="hidden">
    <div>
        <label>
            Haber Türünü Seçiniz:
            <select id="haberTuru" name="HaberTuru" required>
                <option value="1" <?=$row["Oncelik"] == 1 ? 'selected': ''?>>Tepe</option>
                <option value="0" <?=$row["Oncelik"] == 0 ? 'selected': ''?>>Gündem</option>
                <option value="2" <?=$row["Oncelik"] == 2 ? 'selected': ''?>>Yan</option>
            </select>
        </label>
        <div class="kategorilerDiv">
            <label for="kategoriler"> Kategori Seçiniz:</label>
            <div class="kategorilerDiv2">
                <?php
                $sql = "SELECT * FROM Kategoriler";
                $result = $conn->query($sql);
                $sql = "SELECT KategoriID FROM haberkategori where HaberID = '$id'";
                $kategoriRes = $conn->query($sql);
                $seciliKategoriler = [];
                while ($kategori = $kategoriRes->fetch_assoc()){
                    $seciliKategoriler[] = $kategori["KategoriID"];
                }
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <label><input type="checkbox" name="Kategori[]" <?= in_array($row["KategoriID"],$seciliKategoriler)? 'checked ':''?>value="<?=$row["KategoriID"]?>"><?=$row["KategoriAdi"]?></label>
                    <?php }}
                $sql = "select * from haberler where HaberId = '$id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                }?>
            </div>
        </div>
    </div>
    <label>
        Haber Başlığı:
        <input required type="text" placeholder="Haber başlığı giriniz" name="Baslik" id="Baslik" value="<?=$row["Baslik"]?>">
    </label>
  <div id="turSecim">
  <?php if ($row["Oncelik"] == 0): ?>
    <label>Üst Yazı
      <input type="text" id="Ust-Yazi" name="Ust-Yazi" placeholder="Üst Yazıyı Giriniz" required value="<?=$row["UstYazi"]?>">
    </label>
    <label>Alt Yazı
      <input type="text" id="Alt-Yazi" name="Alt-Yazi" placeholder="Alt Yazıyı Giriniz" required value="<?=$row["AltYazi"]?>">
    </label>
  <?php endif;?>
  </div>
    <label>
        Haber Özeti:
        <input required type="text" placeholder="Haber özetini giriniz" name="Ozet" id="Ozet" value="<?=$row["Ozet"]?>">
    </label>
    <div class="kapakFotoPreview">
        <input type="file" id="fileInputKF" style="display: none" accept="image/*">
        <label for="fileInputKF">
            Kapak Fotoğrafı:
            <i class="fa-solid fa-upload" aria-hidden="true"></i></label>

        <div class="KFimage-container" id="KapakFotoDiv">
            <button title="Fotoğrafı Sil" class="delete-button">×</button>
            <div class="div-2" id="div2">
                <img class="KFpreview-image" src="data:image/png;base64,<?=base64_encode($row["KapakFotografi"])?>">
            </div>
            <input id="KapakFoto" name="KapakFoto" hidden="" value="data:image/png;base64,<?=base64_encode($row["KapakFotografi"])?>">
        </div>
    </div>
    <br>
    <br>
    <br>
    <label for="updateButton" style="background-color: lightgreen">Gönder</label>
    <input type="submit" id="updateButton" style="display: none">
    <br>

    <input type="file" id="fileInput" style="display: none" accept="image/*">
    <label for="fileInput">
        Fotoğraf Yükle:
        <i class="fa-solid fa-upload"></i></label>
    <div id="preview">
        <?php
        $sql = "select * from haberlerfotograf where HaberID = '$id'";
        $result = $conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $haberFoto = base64_encode($row["Fotograf"]);
        ?>
      <div class="image-container" draggable="true">
        <button title="Fotoğrafı Sil" class="delete-button">×</button>
        <span class="number" title="Fotoğrafın Kaçıncı Sırada Gözükeceğini Temsil Eder"></span>
        <img class="preview-image" src="data:image/png;base64,<?=$haberFoto?>">
        <div id="editor<?=$i?>" class="quill-editor"></div>
        <script>
          document.addEventListener("DOMContentLoaded",function () {
            const quill = new Quill(`#editor<?=$i?>`, {
              theme: 'snow',
              placeholder: 'Fotoğraf açıklaması girin...',
              bounds: `#editor<?=$i?>`,
              modules: {
                toolbar:
                  [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'link']]
              },
            });
            quill.root.innerHTML = <?=json_encode($row["Aciklama"])?>;
            if (!window.quillEditors) window.quillEditors = [];
            window.quillEditors.push(quill);
          })
        </script>
        <input id="HaberFoto<?=$i?>" name="HaberFoto[]" hidden value="data:image/png;base64,<?=$haberFoto?>">
      </div>
      <?php $i++;
        }}
      ?>
    </div>
    <span id="inputs"></span>
</form>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="../js_Dosyaları/haber-gir.js"></script>
</body>
</html>




<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$_POST["Baslik"]?></title>
    <link rel="stylesheet" href="../css_Dosyaları/haber.css">
</head>
<body>
<?php
require "../php_HTML_Dosyaları/side-nav.php"
?>
<main class="container">
    <article class="haber-detay">
            <h2><?=$_POST["Baslik"]?></h2>
            <p class="tarih"><?=date("d M Y H:i:s")?></p>
            <p><b><?=$_POST["Ozet"]?></b></p>
        <?php
            $i = 0;
            foreach ($_POST["HaberFoto"] as $key => $value) {
                                ?>
                <img style="width: 760px; height: 450px" src="<?=$value?>">

                <p class="icerik"><?=$_POST["icerik"][$key]?></p>
                <?php
                $i++;
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
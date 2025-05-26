<?php
require_once __DIR__ . '/../vendor/autoload.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habersitesi_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.Allowed', 'p,strong,b,i,em,a,u,s,blockquote,sup,sub,ol,ul,li,hr');
$config->set('HTML.AllowedAttributes', 'href, style, class');
$config->set('AutoFormat.AutoParagraph', false);
$config->set('AutoFormat.RemoveEmpty', true);
$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
$config->set('URI.AllowedSchemes', array(
    'http' => true,
    'https' => true,
    'mailto' => true
));
$doc = new DOMDocument(1.0, "UTF-8");
$purifier = new HTMLPurifier($config);

if (($_POST["HaberTuru"])==="0") {
    $sql = "insert into haberler (Oncelik, Baslik, UstYazi, AltYazi, KapakFotografi, Ozet) values (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $Baslik = $_POST["Baslik"];
    $UstYazi = $_POST["Ust-Yazi"];
    $AltYazi = $_POST["Alt-Yazi"];
    $Ozet = $_POST["Ozet"];
    $Oncelik = $_POST["HaberTuru"];
    $Null = null;
    $kapakFotografi = $_POST["KapakFoto"];
    $kapakFotografi = explode(",", $kapakFotografi);
    $kapakFotografi = base64_decode($kapakFotografi[1]);
    $stmt->bind_param("isssbs",$Oncelik, $Baslik, $UstYazi, $AltYazi, $Null, $Ozet);
    $stmt -> send_long_data(4, $kapakFotografi);
    $stmt->execute();
    $HaberID = $conn->insert_id;
    $stmt->close();
    kategoriFotografEkle($HaberID);

}else if (($_POST["HaberTuru"])==="1") {
    $sql = "insert into haberler (Oncelik, Baslik, KapakFotografi, Ozet) values (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $Baslik = $_POST["Baslik"];
    $Ozet = $_POST["Ozet"];
    $Oncelik = $_POST["HaberTuru"];
    $Null = null;
    $kapakFotografi = $_POST["KapakFoto"];
    $kapakFotografi = explode(",", $kapakFotografi);
    $kapakFotografi = base64_decode($kapakFotografi[1]);
    $stmt->bind_param("isbs",$Oncelik, $Baslik, $Null, $Ozet);
    $stmt -> send_long_data(2, $kapakFotografi);
    $stmt->execute();
    $HaberID = $conn->insert_id;
    $stmt->close();
    kategoriFotografEkle($HaberID);
}else if (($_POST["HaberTuru"])==="2") {
    $sql = "insert into haberler (Oncelik, Baslik, KapakFotografi, Ozet) values (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $Baslik = $_POST["Baslik"];
    $Ozet = $_POST["Ozet"];
    $Oncelik = $_POST["HaberTuru"];
    $Null = null;
    $kapakFotografi = $_POST["KapakFoto"];
    $kapakFotografi = explode(",", $kapakFotografi);
    $kapakFotografi = base64_decode($kapakFotografi[1]);
    $stmt->bind_param("isbs",$Oncelik, $Baslik, $Null, $Ozet);
    $stmt -> send_long_data(2, $kapakFotografi);
    $stmt->execute();
    $HaberID = $conn->insert_id;
    $stmt->close();
    kategoriFotografEkle($HaberID);
}
function kategoriFotografEkle($HaberID)
{
    global $conn;
    global $purifier;
    global $doc;
    $sql = "insert into haberkategori(HaberID, KategoriID) values (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $HaberID, $KategoriID);
    foreach ($_POST["Kategori"] as $value) {
        $KategoriID = $value;
        $stmt->execute();
    }
    $haberFoto = $_POST["HaberFoto"];
    $sql = "insert into haberlerfotograf(HaberID, Fotograf, Aciklama) values (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ibs", $HaberID, $Null, $Aciklama);
    foreach ($haberFoto as $key => $value) {
        $haberFoto = $value;
        $haberFoto = explode(",", $haberFoto);
        $Fotograf = base64_decode($haberFoto[1]);
        $Aciklama = $purifier->purify($_POST["icerik"][$key]);
        $Aciklama = mb_convert_encoding($Aciklama,"HTML-ENTITIES", "UTF-8");
        $doc->loadHTML($Aciklama);
        $links = $doc->getElementsByTagName("a");
        foreach ($links as $link) {
            if (!$link->hasAttribute("target")) {
                $link->setAttribute("target", '_blank');
                $link->setAttribute("rel", "noopener noreferrer");
            }
        }
        $body = $doc->getElementsByTagName("body")->item(0);
        $Aciklama = '';
        foreach ($body->childNodes as $child) {
            $Aciklama .= $doc->saveHTML($child);
        }
        $stmt-> send_long_data(1, $Fotograf);
        $stmt->execute();
    }
    $stmt->close();
    header("Location:../php_HTML_Dosyaları/Anasayfa.php");
    exit();
}
<?php
session_start();
if(isset($_SESSION["login"])&&$_SESSION["login"]&&$_SESSION["Unvan"] === "Yazar") {
    $haberID = $_GET["id"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "habersitesi_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM haberler WHERE HaberID = $haberID";
    $conn->query($sql);
    $conn->close();
    header("Location: ../php_HTML_Dosyaları/Admin-Panel.php");
    exit();
}

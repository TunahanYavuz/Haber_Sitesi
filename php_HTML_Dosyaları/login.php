<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habersitesi_db";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $salt = '$5$rounds=5000$awuqoeyqw/*-+$';
    if (!empty($_POST["login-email"]) && !empty($_POST["login-password"])) {
        $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE e_mail = ? AND Sifre = ?");
        $loginEmail = $_POST["login-email"];
        $loginPassword = $_POST["login-password"];
        $loginPassword = crypt($loginPassword, $salt);
        $stmt->bind_param("ss", $loginEmail, $loginPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "asd";
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["loginEmail"] = $loginEmail;
            $_SESSION["loginName"] = $row["KullaniciAdi"];
            $_SESSION["Unvan"] = $row["Unvan"];
            header("Location: ../php_HTML_Dosyaları/Anasayfa.php");
            exit();
        }
        else{
            header("Location: ../php_HTML_Dosyaları/giris.html");
            exit();
        }
    }
    elseif (!empty($_POST["signup-email"]) && !empty($_POST["signup-password"])&&!empty($_POST["first-name"])&&!empty($_POST["last-name"])) {
        $stmt = $conn->prepare("insert into kullanicilar(KullaniciAdi, KullaniciSoyadi, e_mail, Sifre) values (?,?,?,?)");
        $stmtControl = $conn->prepare("SELECT e_mail FROM kullanicilar WHERE e_mail = ?");
        $signupEmail = $_POST["signup-email"];
        $signupPassword = $_POST["signup-password"];
        $firstName = $_POST["first-name"];
        $lastName = $_POST["last-name"];
        $signupPassword = crypt($signupPassword, $salt);
        $stmtControl->bind_param("s", $signupEmail);
        $stmtControl->execute();
        $result = $stmtControl->get_result();
        if ($result && $result->num_rows === 0) {
            $stmt->bind_param("ssss", $firstName, $lastName, $signupEmail, $signupPassword);
            $stmt->execute();
            $stmt->close();
        }
        $stmtControl->close();
        header("Location: ../php_HTML_Dosyaları/giris.html");
        exit();
    }
}
?>
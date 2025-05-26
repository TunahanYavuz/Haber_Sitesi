<?php
session_start();
session_unset();
session_destroy();
header("Location: ../php_HTML_Dosyaları/Anasayfa.php");
exit();


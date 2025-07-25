<?php
session_start();
$_SESSION = [];
session_destroy();

if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, '/');
    
    
}
header("Location: ../../../index.php");
exit();


?>
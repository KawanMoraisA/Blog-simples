<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['usuario'])) {
    session_unset();
    session_destroy();

    header("location: index.php");
    exit();
} else {
    header("location: index.php");
    exit();
}
?>

<?php
    session_start();
    $_SESSION["id_r"]=$_POST['contact'];
    print_r($_POST);
    header("location:messagerie.php");
    exit();
?>
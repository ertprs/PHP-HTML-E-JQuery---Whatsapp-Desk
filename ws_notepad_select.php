<?php

session_start();

header("Content-type: text/html; charset=utf-8");

include("dbcon/dbcon.php");

$phone = $_POST['phone'];

if (!isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133') {
    header("Location: index.php");
} else {
    if (!empty($phone)) {
            $sql = "SELECT notepad FROM contatos WHERE numero='{$phone}' ";
            $sql .= "AND user_cli='{$_SESSION['user_cli']}'";
            $result = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($result);
            echo json_encode($result);
    }
}

mysqli_close($con);
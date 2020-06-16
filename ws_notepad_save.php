<?php

session_start();

header("Content-type: text/html; charset=utf-8");

include("dbcon/dbcon.php");

$notepad = $_POST['notepad'];
$phone = $_POST['phone'];

if (!isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133') {
    header("Location: index.php");

} else {

    if (!empty($notepad) && !empty($phone)) {

            $sql = "UPDATE contatos SET notepad='{$notepad}' WHERE numero='{$phone}' ";
            $sql .= "AND user_cli='{$_SESSION['user_cli']}'";
            $result = mysqli_query($con, $sql);

            echo json_encode($result);
    }


}

mysqli_close($con);
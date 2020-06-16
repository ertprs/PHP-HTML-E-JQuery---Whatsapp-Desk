<?php

session_start();

header("Content-type: text/html; charset=utf-8");

include("dbcon/dbcon.php");


if (!isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133') {
    header("Location: index.php");

} else {
    // Busca todas as tags
    $sql = "SELECT * FROM tags";
    $result = mysqli_query($con, $sql);
    while ($rows = mysqli_fetch_assoc($result)) {
        $vetor[] = array_map('utf8_encode', $rows);
    }
    echo json_encode($vetor);


}

mysqli_close($con);

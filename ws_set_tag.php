<?php

session_start();

header("Content-type: text/html; charset=utf-8");

include("dbcon/dbcon.php");

$tag_id = $_POST['tag_id'];
$last_id = $_POST['last_id'];
$phone = $_POST['phone'];

if (!isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133') {
    header("Location: index.php");

} else {

    if (!empty($tag_id) && !empty($last_id) && !empty($phone)) {

        // Atualiza tag de atendimento na conversa
        $sql = "UPDATE whats_chat SET tag_id={$tag_id} WHERE id={$last_id}";
        $result = mysqli_query($con, $sql);

        if ($result) {
            // Atualiza tag de atendimento no contato
            $sql = "SELECT name FROM tags WHERE id={$tag_id}";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $sql = "UPDATE contatos SET tag='{$row['name']}' WHERE numero='" . $phone . "' ";
            $sql .= "AND user_cli='".$_SESSION['user_cli']."'";
            $result = mysqli_query($con, $sql);

            echo json_encode($result);
        }
    }


}

mysqli_close($con);

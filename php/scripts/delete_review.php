<?php

    session_start();

    include "../connection.php";

    if (!isset($_SESSION["session_user"])) {
        header("Location: ../../index.php");
        exit;
    }

    if(!isset($_SESSION["deleted_reviews"]))
        $_SESSION["deleted_reviews"] = 0;

    $to_delete = $_POST["deleteRev"];

    if(!isset($to_delete)) {
        header("Location: ../welcome.php");
        exit;
    }
    
    foreach($to_delete as $id) {
        $delete = "DELETE FROM recensione WHERE id_recensione = $id";
        if($conn->query($delete)) {
            if($conn->affected_rows > 0)
                $_SESSION["deleted_reviews"]++;
        } else {
            getOut();
        }
    }

    header("Location: ../welcome.php");

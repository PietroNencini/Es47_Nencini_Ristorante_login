<?php

    session_start();

    include "../connection.php";

    if (!isset($_SESSION["session_user"])) {
        header("Location: ../../index.php");
        exit;
    }

    $to_delete = $_POST["deleteRev"];

    if(!isset($to_delete)) {
        header("Location: ../welcome.php");
        exit;
    }
    
    foreach($to_delete as $id) {
        $delete = "DELETE FROM recensione WHERE id = $id";
        $conn->query($delete);
    }

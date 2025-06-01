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
    

    $stmt = $conn->prepare("DELETE FROM recensione WHERE id_recensione = ?");

    foreach($to_delete as $id) {
        $stmt->bind_param("i", $id);
        if($stmt->execute()) {
            $_SESSION["error_code"] = -5;
            if($conn->affected_rows > 0)
                $_SESSION["deleted_reviews"]++;
        } else {
            getOut();
        }
    }

    header("Location: ../welcome.php");

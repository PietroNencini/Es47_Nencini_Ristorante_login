<?php

    session_start();

    include "../connection.php";

    if (!isset($_SESSION["session_user"]) || $_SESSION["session_user"] != "admin") {
        header("Location: ../../index.php");
        exit;
    }

    $rest_name = str_replace("'", "\'", (string)$_POST["r_name"]);
    $rest_address = str_replace("'", "\'", (string)$_POST["r_address"]);
    $rest_city = str_replace("'", "\'", (string)$_POST["r_city"]);

    $insert = "INSERT INTO ristorante(nome, indirizzo, citta) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($insert);
    $stmt->bind_param("sss", $rest_name, $rest_address, $rest_city);
    if($stmt->execute()) {
        $_SESSION["error_code"] = 8;
        if($conn->affected_rows > 0) {
            $_SESSION["error_code"] = -3;
        }
        header("Location: ../admin_panel.php");
    } else {
        $_SESSION["error_code"] = 3;
        header("Location: ../../pages/error.html");
    }




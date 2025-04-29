<?php

    session_start();

    include "connection.php";

    if (!isset($_SESSION["session_user"]) || $_SESSION["session_user"] != "admin") {
        header("Location: ../index.php");
        exit;
    }

    $rest_name = $_POST["r_name"];
    $rest_address = $_POST["r_address"];
    $rest_city = $_POST["r_city"];

    $insert = "INSERT INTO ristorante(nome, indirizzo, citta) VALUES ($rest_name, $rest_address, $rest_city)";
    if($conn->query($insert)) {

        if($conn->query($rest_address)) {
            
        }
        header("Location: admin_panel.php");
    } else {
        header("Location: ../pages/error.html");
    }




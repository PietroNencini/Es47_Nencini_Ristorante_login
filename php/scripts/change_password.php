<?php

    session_start();

    include "../connection.php";

    if (!isset($_SESSION["session_user"])) {
        header("Location: ../../index.php");
        exit;
    }

    if(!isset($_SESSION["error_code"]))
        $_SESSION["error_code"] = 0;

    $logged_user = $_SESSION["session_user"];
    $pw = hash("sha256", $_POST["new_password"]);

    // Ottengo la password già presente
    if($result = $conn->query("SELECT passwrd FROM utente WHERE username = '$logged_user'")) {
        $old_pw = $result->fetch_assoc()["passwrd"];
    } else {
        getOut();
    }

    // Primo controllo: le password non possono essere uguali (cosa la cambi a fare)
    if($pw == $old_pw) {
        $_SESSION["error_code"] = 9;
        header("Location: ../welcome.php");
        exit;
    }

    //Query parametrizzata per evitare sql injection
    $query = "UPDATE utente SET passwrd = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $pw, $logged_user);

    if($stmt->execute()) {
        $_SESSION["error_code"] = $conn->affected_rows > 0 ? -4 : 9;
        header("Location: ../welcome.php");
    } else {
        header("Location: ../pages/error.html");
    }




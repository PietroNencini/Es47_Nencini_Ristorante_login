<?php
    session_start();

    if(!isset($_SESSION["error_code"]))     // 0: OK, 1: username non trovato, 2: password errata, 3: errore nella query, -1: errore sconosciuto
        $_SESSION["error_code"] = 0;
    if(!isset($_SESSION["session_user"]))
        $_SESSION["session_user"] = "";

    include "connection.php";

    $form_username = $_POST["username"];
    $form_password = $_POST["password"];

    $data_query = "SELECT username, passwrd FROM UTENTE";

    if($result = $conn->query($data_query)) {

        if($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                foreach($row as $field->$value) {
                    if($field == "username" && $form_username == $value) {
                        $user_found = true;
                    }
                }
            }

            if(!$user_found) {
                $_SESSION["error_code"] = 1;
                header("Location: login_error.php");
            }

        }

    } else {
        header("Location: ../pages/error.html");
    }

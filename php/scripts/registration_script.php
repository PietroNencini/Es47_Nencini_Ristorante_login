<?php

    session_start();

    include "../connection.php";

    $form_username = str_replace(["'", "\""], "", (string)$_POST["username"]);
    $form_password = str_replace(["'", "\""], "", (string)$_POST["password"]);
    $form_name = str_replace(["'", "\""], ["\'", ""], (string)$_POST["name"]);
    $form_surname = str_replace(["'", "\""], ["\'", ""], (string)$_POST["surname"]);
    $form_email = $_POST["email"];
    if(!preg_match("/[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}/", $form_email)) {
        $_SESSION["error_code"] = 10;
        header("Location: ../../index.php");
        exit;
    }

    $hashed_pw = hash("sha256", $form_password);

    $query_select = "SELECT username, passwrd, email FROM utente";
    $query_insert = "INSERT INTO utente(username, passwrd, nome, cognome, email) VALUES(?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query_insert);
    $stmt->bind_param("sssss", $form_username, $hashed_pw, $form_name, $form_surname, $form_email);

    if($result = $conn->query($query_select)) {
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                if($row["username"] == $form_username) {
                    $_SESSION["error_code"] = 4;
                    header("Location: ../registration.php");
                    exit;
                } else if($row["email"] == $form_email) {
                    $_SESSION["error_code"] = 5;
                    header("Location: ../registration.php");
                    exit;
                }
            }    
            if($result_insert = $stmt->execute()) {
                    
                $_SESSION["error_code"] = 0;
                $_SESSION["session_user"] = $form_username;
                header("Location: ../welcome.php");

            } else {
                $_SESSION["error_code"] = 3;
                header("Location: ../../pages/error.html");
            }
        }

    } else {
        $_SESSION["error_code"] = 3;
        header("Location: ../../pages/error.html");
    }



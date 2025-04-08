<?php

    session_start();

    include "../connection.php";

    $form_username = $_POST["username"];
    $form_password = $_POST["password"];
    $form_name = $_POST["name"];
    $form_surname = $_POST["surname"];
    $form_email = $_POST["email"];

    $hashed_pw = hash("sha256", $form_password);

    $query_select = "SELECT username, passwrd, email FROM utente";
    $query_insert = "INSERT INTO utente(username, passwrd, nome, cognome, email) VALUES('$form_username', '$hashed_pw', '$form_name', '$form_surname', '$form_email')";

    if($result = $conn->query($query_select)) {
        echo "Sono arrivato alla pirima";
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
            if($result_insert = $conn->query($query_insert)) {
                    
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



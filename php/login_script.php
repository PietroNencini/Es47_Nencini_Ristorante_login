
<?php
    // Questa pagina non ha contenuto HTML, serve solo a reindirizzare l'utente nella pagina corretta in base al risultato della login
    session_start();

    if(!isset($_SESSION["error_code"]))     // 0: OK, 1: username non trovato, 2: password errata, 3: errore nella query, -1: errore sconosciuto
        $_SESSION["error_code"] = 0;
    if(!isset($_SESSION["session_user"]))
        $_SESSION["session_user"] = "";

    include "connection.php";

    $form_username = $_POST["username"];
    $form_password = $_POST["password"];

    $data_query = "SELECT username, passwrd FROM UTENTE";

    if($result = $conn->query($data_query)) {                            //? CONTROLLO 1: Sintassi query
        $user_found = false;   
        while($row = $result->fetch_assoc()) {                                  //? CONTROLLO 2: Iterazione sui record per verificare l'esistenza dell'utente           
            if($row["username"] == $form_username) {
                $user_found = true;
                if($row["passwrd"] == $form_password) {
                    $_SESSION["session_user"] = $form_username;
                    $_SESSION["error_code"] = 0;
                    header("Location: welcome.php");
                } else {
                    $_SESSION["error_code"] = 2;
                    header("Location: login_error.php");
                }
            }
        }   
        if(!$user_found) {
            $_SESSION["error_code"] = 1;
            header(header:"Location: login_error.php");
        }
    } else {
        $_SESSION["error_code"] = 3;
        header(header: "Location: ../pages/error.html");
    }

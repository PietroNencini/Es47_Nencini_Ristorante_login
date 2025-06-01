<?php

    //? LE QUERY DI QUESTO SCRIPT NON SONO PARAMETRIZZATE IN QUANTO I PARAMETRI USATI SONO RACCOLTI IN MODO SICURO SENZA CHE CI SIA RISCHIO DI SQL INJECTION

    session_start();

    include "../connection.php";

    if(!isset($_SESSION["error_code"]) || !isset($_SESSION["session_user"])) {      // Controllo sulla sessione
        header(header: "Location: ../../pages/error.html");
        exit;
    }

    $restaurant_id = $_POST["restaurant"];
    $review_value = $_POST["rating"];

    if($restaurant_id != "not_available") {                   // not_available è il valore della option se non ci sono ristoranti disponibili

        if($result_1 = $conn->query(query: "SELECT id_cliente FROM utente WHERE username = '".$_SESSION["session_user"]."'")) {
            if($result_1->num_rows > 0) {
                $user_id = $result_1->fetch_assoc()["id_cliente"];
            }

            $first_check_query = "SELECT count(*) AS num_rec FROM recensione WHERE id_utente = '$user_id' AND id_ristorante = '$restaurant_id'";
            if($user_rest_check = $conn->query($first_check_query)) {
                if($user_rest_check->fetch_assoc()["num_rec"] > 0) {
                    $_SESSION["error_code"] = 7;

                    if($rest_result = $conn->query("SELECT nome FROM ristorante WHERE id_ristorante = '$restaurant_id'")) {
                        $_SESSION["rest_error"] = $rest_result->fetch_assoc()["nome"];
                    } else {
                        header("Location: ../../pages/error.html");
                    }
                } else {
                    $query_insert = "INSERT INTO recensione(id_utente, id_ristorante, voto, data_rec) VALUES('$user_id', '$restaurant_id', '$review_value', NOW())";
    
                    if(!$conn->query(query: $query_insert)) {
                        header("Location: ../../pages/error.html");
                    }
                    
                    $_SESSION["error_code"] = ($conn->affected_rows > 0) ? -2 : 3;
                }
            }
        }
    } else {
        $_SESSION["error_code"] = 6;
    }
    header("Location: ../welcome.php");
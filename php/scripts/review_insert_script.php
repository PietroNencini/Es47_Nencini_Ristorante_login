<?php


    session_start();

    include "../connection.php";

    if(!isset($_SESSION["error_code"]) || !isset($_SESSION["session_user"])) {
        header(header: "Location: ../../pages/error.html");
    }

    $restaurant_id = $_POST["restaurant"];
    $review_value = $_POST["vote"];

    if($restaurant_id != "not_available") {
        if($result_1 = $conn->query(query: "SELECT id_cliente FROM utente WHERE username = '".$_SESSION["session_user"]."'")) {
            if($result_1->num_rows > 0) {
                $user_id = $result_1->fetch_assoc()["id_cliente"];
            } 
        }
    
        $query_insert = "INSERT INTO recensione(id_utente, id_ristorante, voto, data_rec) VALUES('$user_id', '$restaurant_id', '$review_value', NOW())";
    
        if(!$conn->query(query: $query_insert)) {
            header("Location: ../../pages/error.html");
        }
    
        $_SESSION["error_code"] = ($conn->affected_rows > 0) ? -2 : 3;
    } else {
        $_SESSION["error_code"] = 6;
    }
    header("Location: ../welcome.php");
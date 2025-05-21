<?php

    function getUserIDByUsername($username) {
        include "connection.php";
        if($result = $conn->query(query: "SELECT U.id_cliente AS id FROM utente U LEFT JOIN recensione RV ON RV.id_utente = U.id_cliente WHERE U.username = '$username'")) {
            if($result->num_rows > 0) {
                return $result->fetch_assoc()["id"];
            } else {
                return false;
            }
        } else {
            header("Location: ../../pages/error.html");
        } 
    }
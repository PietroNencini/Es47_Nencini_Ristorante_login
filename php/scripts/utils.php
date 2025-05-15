<?php

    function getUserIDByUsername($username) {
        include "connection.php";
        if($result = $conn->query(query: "SELECT U.id_cliente AS id FROM recensione RV INNER JOIN utente U ON RV.id_utente = U.id_cliente WHERE U.username = 'Nencio2006'")) {
            if($result->num_rows > 0) {
                return $result->fetch_assoc()["id"];
            } else {
                return false;
            }
        } else {
            header("Location: ../../pages/error.html");
        } 
    }

    // La select deve essere creata fuori dalla funzione, che invece si occupa delle <option>
    
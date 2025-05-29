<?php

    include "../connection.php";

    $idRistorante = $_GET['id_ristorante'];
    if($result = $conn->query("SELECT latitudine as lat, longitudine as lon FROM ristorante WHERE id_ristorante = $idRistorante")) {

        $result = $result->fetch_assoc();

    } else {
        header("Location: ../../pages/error.html");
        exit;
    }

    $lat = $result['lat'];
    $lon = $result['lon'];
    $data = array('lat'=>$lat , 'lon'=>$lon);
    echo json_encode($data);


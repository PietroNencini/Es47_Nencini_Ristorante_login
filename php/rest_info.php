<?php

    session_start();

    if (!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if (!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        header(header: "Location: ../index.php");
        exit;
    }

    include "connection.php";

    $id_rest = $_GET["nome_ristorante"];


    if($result = $conn->query("SELECT nome, indirizzo, citta FROM ristorante WHERE id_ristorante = $id_rest")) {

        $info_ristorante = $result->fetch_assoc();

    } else {
        header("Location: ../pages/error.html");
        $_SESSION["error_code"] = 3;
        exit;
    }

?>
<!DOCTYPE html>
<html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ristorante</title>
        <!--* BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!--*CSS PERSONALE-->
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <!--*ALTRO CSS-->
        <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
        <!--*CSS STELLINE-->
        <link rel="stylesheet" type="text/css" href="../css/stars.css">
        <!--*LEAFLET-->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""/>
        
    </head>

    <body id="restaurant_info_page">
        
        <header class="d-flex align-items-center justify-content-center bg-warning">
            <span><img id="icon" src="../images/logo.png" alt="risto&rece" width="96px" class="d-block mx-auto"></span>
            <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
        </header>


        <div class="w-75 mx-auto my-5 bg-white rounded-4 text-center p-3">

            <h1> INFORMAZIONI RISTORANTE </h1>

            

            <div id="rest_map" style="height: 600px">

            </div>

        </div>


        <!--SCRIPT LEAFLET-->
         <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <!--MIO SCRIPT-->
        <script src="../javascript/map.js"></script>
    </body>

</html>
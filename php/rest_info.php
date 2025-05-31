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


    if($result = $conn->query("SELECT nome, indirizzo, citta as città, latitudine, longitudine FROM ristorante WHERE id_ristorante = $id_rest")) {

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
        <!--* FAVICON -->
        <link rel="shortcut icon" href="../images/favicons/cutlery.png" type="image/x-icon">
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

    <body id="restaurant_info_page" class="has_footer" onload="showMap('rest_map' ,<?php echo $info_ristorante['latitudine'] ?>, <?php echo $info_ristorante['longitudine'] ?>)">
        
        <!--<header class="d-flex align-items-center justify-content-center bg-warning">
            <span><img id="icon" src="../images/icons/R&R_definitivo.png" alt="risto&rece" width="96px" class="d-block mx-auto"></span>
            <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
        </header>-->

        <header class="w-100 bg-warning">
            <div class="container">
                <nav class="navbar navbar-expand-lg sticky-top">
                    <div class="container-fluid fs-5">
                        <a class="navbar-brand jaini text-center" href="../pages/website_intro.php">
                            <span style="font-size: 3rem;">
                                <img src="../images/icons/R&R_definitivo.png" alt="risto&rece" width="96px"
                                class="d-inline-block align-text-center">
                            <span class="ms-2">RISTO&RECE </span> </span>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse ps-3" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="../pages/website_intro.php">Homepage</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Area Personale</a>
                                </li>
                                
                            </ul>
                            <div class="ms-auto" role="search">
                                <div class="profile_elements" id="nav_right">
                                    <a class="nav-link" href="profile.php">
                                        <span class="d-flex align-items-center"></span>
                                            <i class="bi bi-person-fill" style="font-size: 3rem;" id="profile_icon"></i>
                                        </span>
                                    </a>
                                
                                    <!--<button id="logout_button" type="submit" class="w-25 btn btn-danger fw-bold fs-5 d-block mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()"> LOGOUT </button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>


        <div id="rest_info_page_container" class="w-75 mx-auto my-5 bg-white rounded-4 text-center p-3">

            <h2> Informazioni su: <?php echo $info_ristorante["nome"]; ?> </h2>

            <div id="ristor_info" class="w-50 mx-auto my-4 row fs-5">
                <div class="col col-md-6">
                    <div class="info_show"> 
                        <img src="../images/location.png" alt="indirizzo:">
                        <p> <?php echo $info_ristorante["indirizzo"]; ?> </p>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="info_show">
                        <img src="../images/houses.png" alt="citta:">
                        <p> <?php echo $info_ristorante["città"]; ?> </p>
                    </div>
                </div>
                <div class="">
                    <div class="info_show">
                        <img src="../images/planet.png" alt="posizione:">
                        <p> <?php echo $info_ristorante["latitudine"] . ", " . $info_ristorante["longitudine"]; ?></p>
                        <button type="button" class="btn copy_button ms-3" onclick="copyText()"></button>
                        <img id="checked_icon" src="../images/check.png" alt="copied" style="display: none;">
                        <input id="copy_text" type="text" value="<?php echo $info_ristorante["latitudine"] . ", " . $info_ristorante["longitudine"]; ?>" hidden>
                    </div>
                </div>
            </div>
            
            <div id="rest_map_container" class="w-75 mx-auto" style="box-shadow: 0px 0px 10px 0px black; border-radius: 10px">
                <div id="rest_map" style="height: 400px">

                </div>
                <button class="btn btn-light fw-bold" onclick="moveToLocation('rest_map', <?php echo $info_ristorante['latitudine']?>, <?php echo $info_ristorante['longitudine']?>)"> RIPOSIZIONA </button>
            </div>
            <div class="my-4">
                <hr class="w-75 mx-auto">
                <h4> Recensioni </h4>
                <div id="ristor_reviews" class="w-50 mx-auto">
                    <table class="table table-bordered border-warning rounded-3">
                        <thead class='table-light'>
                        <?php
                            if($result = $conn -> query("SELECT r.data_rec as Data_pubblicazione, r.voto, u.username as Utente FROM recensione as r INNER JOIN utente as u ON r.id_utente = u.id_cliente WHERE id_ristorante = $id_rest")) {
                                if($result->num_rows > 0) {
                                    echo "<tr class='table-warning-subtle'>";
                                    while($head = $result->fetch_field()) {
                                        $output = $head->name;
                                        if(str_contains($head->name, "_")) {
                                            $output = str_replace("_", " ", $head->name); 
                                        }
                                        echo "<th> $output </th>";
                                    }
                                    echo "</tr></thead> <tbody>";
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        foreach($row as $value) {
                                            echo "<td> $value </td>";
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><th> Nessuna recensione disponibile </th></tr></thead>";
                                }
                            } else {
                                echo "<tr><th> ERRORE: Impossibile recuperare recensioni al momento: ".$id_rest." </th></tr>";
                            }
                        ?>
                        <tr>
                            <?php
                                if($result = $conn->query("SELECT avg(voto) as media FROM recensione WHERE id_ristorante = $id_rest")) {
                                    $avg = $result->fetch_assoc()["media"];
                                    $avg = number_format($avg, 2);
                                } else {
                                    header("Location: ../pages/error.html");
                                }
                            ?>
                            <th id="review_avg" colspan="3"></th>
                        </tr>
                    </table>
                </div>

            </div>

            <button type="button" class="btn btn-warning fw-bold" onclick="window.location.href = 'welcome.php'"> TORNA INDIETRO </button>
        </div>

        <!--finestra di LOGOUT (si apre al click del pulsante prima)-->
        <div id="logout-box" class="d-none"></div>

        <!--? SCRIPT DI BOOTSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <!--SCRIPT LEAFLET-->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <!--MIO SCRIPT-->
        <script src="../javascript/map.js"></script>
        <script src="../javascript/script.js"></script>
        <script src="../javascript/footer.js"></script>
        <script src="../javascript/logout.js"></script>
        <script>
            setAverage(<?php echo $avg ?>);
        </script>

    </body>

</html>
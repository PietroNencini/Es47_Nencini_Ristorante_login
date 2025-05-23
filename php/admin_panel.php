<?php

    function getOut() {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    session_start();

    include "connection.php";

    $permit_admin = [];

    if(!isset($_SESSION["error_code"]))
        $_SESSION["error_code"] = 0;

    if(!isset($_SESSION["session_user"])) {
        getOut();
    }

    if($result = $conn->query("SELECT username FROM utente WHERE is_admin = 1")) {
        while($row = $result->fetch_assoc()) {
            array_push($permit_admin, $row["username"]);
        }
    } else {
        header("Location: ../pages/error.html");
        exit;
    }

    if (in_array($_SESSION["session_user"], $permit_admin) == false) {
        getOut();
    }
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login effettuato</title>
    <!--* FAVICON -->
    <link rel="shortcut icon" href="../images/favicons/protection.png" type="image/x-icon">
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--*LEAFLET-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <!--*CSS PERSONALE-->
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <!--*css logout -->
    <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
</head>

<body id="admin_page" onload="showMap('admin_map' , 43.77311306353422, 11.255404837603264, false, true)">
    <header class="d-flex align-items-center justify-content-center text-white"
        style="background-color: rgb(0, 9, 145)">
        <h1 class="home_title jaini text-center"> Pagina di amministrazione </h1>
    </header>

    <div id="admin_page_container"
        class="my-5 border border-1 border-black rounded-4 p-3 mx-auto w-75 bg-secondary-subtle shadow-lg">

        <div id="rists_container">
            
            <?php
                switch ($_SESSION["error_code"]) {
                    case -3:
                        $output = "<p class='text-center fs-4 bg-success-subtle fw-bold rounded-3 mt-2 mb-3 fs-3'> Ristorante inserito con successo </p>";
                        break;
                    case 0:
                        $output = "";
                        break;
                    case 8:
                        $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-3'> ERRORE: Ristorante già presente o non aggiungibile </p>";
                        break;
                    case 3:
                        $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-3'> ERRORE: impossibile connettersi al servizio </p>";
                        break;
                    default:
                        getOut();
                        exit;
                }
                echo $output;
                $_SESSION["rest_error"] = "N/A";
                $_SESSION["error_code"] = 0;
            ?>

            <h4 class="text-center my-2"> RISTORANTI ATTUALI NEL SISTEMA </h4>
            <table id="restaurants_table" class="table w-75 mx-auto my-3 rounded rounded-3">
                <?php
                $rest_query = "SELECT * FROM ristorante";
                if ($result = $conn->query($rest_query)) {

                    if ($result->num_rows > 0) {
                        echo "<thead> <tr>";
                        while ($field = $result->fetch_field()) {
                            echo "<th> " . $field->name . " </th>";
                        }
                        echo "<th class='text-center'> Numero di recensioni </th>";
                        echo "</tr></thead><tbody>";
                        while ($row = $result->fetch_assoc()) {

                            $rec_result = $conn->query("SELECT count(*) as num_rec FROM ristorante RT INNER JOIN recensione RC on RT.id_ristorante = RC.id_ristorante WHERE RT.id_ristorante = " . $row["id_ristorante"] . "");
                            $num_rec = $rec_result->fetch_assoc()["num_rec"];
                            echo "<tr>";
                            foreach ($row as $value) {
                                echo "<td> $value </td>";
                            }
                            echo "<td class='bg-info-subtle text-center'> $num_rec </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><th>Nessun ristorante disponibile</th></tr>";
                    }
                } else {
                    echo "<p> ERRORE nella richiesta </p>";
                }
                ?>
            </table>

        <hr>

        </div>
        <div id="rist_form_container" class="text-center">
            <h4 class="text-center my-2"> INSERIMENTO RISTORANTI </h4>
            <form action="./scripts/rest_insert.php" method="post" class="w-50 mx-auto">
                <label for="r_name">Nome</label>
                <input type="text" id="r_name" name="r_name" class="form-control" required>
                <label for="r_address">Indirizzo</label>
                <input type="text" id="r_address" name="r_address" class="form-control" required>
                <label for="r_city">Città</label>
                <input type="text" id="r_city" name="r_city" class="form-control" required>
                <div class="row">
                    <div class="col col-md-6">
                        <label for="r_latit">Latitudine</label>
                        <input type="number" id="r_latit" name="r_latit" class="form-control latlng_input" min="-90" max="90" step="0.00000000000001" required>
                    </div>
                    <div class="col col-md-6">
                        <label for="r_longit">Longitudine</label>
                        <input type="number" id="r_longit" name="r_longit" class="form-control latlng_input" min="-180" max="180" step="0.00000000000001" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-25 mt-3 fw-bolder"> INSERISCI </button>
            </form> 
            <div id="admin_map" style="height: 400px;" class="my-3 w-75 mx-auto">

            </div>
        </div>

        <hr>
        <button id="logout_button" class="Btn mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()">
            <div class="sign">
                <svg viewBox="0 0 512 512">
                    <path
                        d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                    </path>
                </svg>
            </div>
            <div class="text">Logout</div>
        </button>
    </div>


    <!--finestra di LOGOUT (si apre al click del pulsante prima)-->
    <div id="logout-box" class="d-none">
        <div class="logout-content">
            <h2> Sei sicuro di voler effettuare la disconnessione? </h2>
            <h5> Sarà necessario ripetere l'accesso per poter tornare a questa pagina </h5>
            <div class="buttons">
                <form action="./scripts/logout_script.php" method="post">
                    <button id="confirm-logout" type="submit" class="btn btn-danger"
                        onclick="hide('logout-box'), enable_scroll()">CONFERMA</button>
                    <button id="cancel-logout" type="button" class="btn btn-outline-danger"
                        onclick="hide('logout-box'), enable_scroll()">ANNULLA</button>
                </form>
            </div>
        </div>
    </div>

    <!--? SCRIPT DI BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!--SCRIPT LEAFLET-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <!--? JAVASCRIPT PERSONALE-->
    <script src="../javascript/map.js"></script>
    <script src="../javascript/script.js"></script>
</body>

</html>
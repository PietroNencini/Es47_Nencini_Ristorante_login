<?php
    session_start();

    include "connection.php";

    if (!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if (!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        //header(header: "Location: ../index.php");
        echo "Faccio schifo";
        exit;
    }

    if (!isset($_SESSION["rest_error"])) {
        $_SESSION["rest_error"] = "N/A";
    }

    $logged_user = $_SESSION["session_user"];

    if($result = $conn->query("SELECT is_admin FROM utente WHERE username = '$logged_user'")) {
        $row = $result->fetch_assoc();
        if($row["is_admin"] == 1) {
            header("Location: admin_panel.php");
            exit;
        }
    } else {
        header("Location: ../pages/error.html");
        exit;
    }

    $info_list = ["USERNAME", "NOME", "COGNOME", "EMAIL", "MEMBRO DAL"];
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login effettuato</title>
    <!--* FAVICON -->
    <link rel="shortcut icon" href="../images/favicons/user.png" type="image/x-icon">
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--*CSS PERSONALE-->
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <!--*ALTRO CSS-->
    <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
    <!--*CSS STELLINE-->
    <link rel="stylesheet" type="text/css" href="../css/stars.css">
    <!--*CSS PULSANTE ELIMINA-->
    <link rel="stylesheet" href="../css/delete_button.css">
    
</head>

<body id="personal_page" class="has_footer">

    <header class="d-flex align-items-center justify-content-center bg-warning">
        <span><img id="icon" src="../images/logo.png" alt="risto&rece" width="96px" class="d-block mx-auto"></span>
        <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
    </header>

    <div id="results_container"
        class="my-5 border rounded-4 p-3 mx-auto w-75 bg-secondary-subtle">
        <?php
            switch ($_SESSION["error_code"]) {
                case 0:
                    $output = "<h3 class='text-center p-3 w-25 mx-auto rounded-3 text-white' id='login_made'> ACCESSO EFFETTUATO </h3> <p class='text-center fs-4 '> Benvenuto <span class='fw-bold'> $logged_user </span> </p>";
                    break;
                case -2:
                    $output = "<p class='text-center fs-4'> Grazie per la tua recensione, <span class='fw-bold'> $logged_user </span> </p>";
                    break;
                case 3:
                    $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-3'> ERRORE: impossibile inserire la recensione, controlla i dati e riprova </p>";
                    break;
                case 7:
                    $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-3'> ERRORE: Hai già dato una recensione al ristorante " . $_SESSION["rest_error"] . " </p>";
                    break;
                default:
                    echo "ERRORE";
                    exit;
            }
            echo $output;
            $_SESSION["rest_error"] = "N/A";
            $_SESSION["error_code"] = 0;
        ?>

        <hr>

        <div id="info_container" class="w-50 mx-auto">
            <p class=" fw-bold fs-4 "> Informazioni utente </p>
            <ul id="user_info" style="list-style-type: none;">
                <?php
                $query = "SELECT username, nome, cognome, email, data_reg FROM utente WHERE username = '$logged_user' ";
                if ($result = $conn->query(query: $query)) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $count = 0;
                            foreach ($row as $value) {
                                echo "<li>" . $info_list[$count] . ": <b> $value </b></li>";
                                $count++;
                            }
                        }
                    } else {
                        echo "non funge";
                    }
                } else {
                    echo "c'è un problema";
                }
                ?>
            </ul>
        </div>
        <hr>
        <div id="reviews_space">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <form action="./scripts/delete_review.php" method="post" >


                        <div id="rev_table_container" class="w-100 mx-auto px-5 rounded-3">
                            <table id="revs_table" class="table table-bordered border-warning rounded-3"
                                style="border-radius: 0.3rem !important;">
                                <?php
                                    include "./scripts/utils.php";
                                    $required_id = getUserIDByUsername($logged_user);
                                    $rev_query = "SELECT RT.nome AS Ristorante, RT.Indirizzo, RV.voto as Valutazione, RV.data_rec as Data, RV.id_recensione as ID  FROM recensione RV INNER JOIN ristorante RT ON RV.id_ristorante = RT.id_ristorante WHERE RV.id_utente = $required_id";
                                    $rev_result = $rev_result = $conn->query(query: $rev_query);
                                    if ($rev_result) {
                                        $num_rec_output = "<p class='fs-4 text-center'> Recensioni totali: $rev_result->num_rows </p>";
                                        if ($rev_result->num_rows > 0) {
                                            echo "<thead class='table-light'> <tr class='table-warning-subtle'>";
                                            while ($field = $rev_result->fetch_field()) {
                                                if($field->name != "ID") {
                                                    echo "<th> $field->name </th>";
                                                }
                                            }
                                            echo " <th> SELEZIONA </th> ";
                                            echo "</tr> </thead> <tbody>";
                                            while ($row = $rev_result->fetch_assoc()) {
                                                echo "<tr>";
                                                foreach ($row as $key => $value) {
                                                    if($key != "ID") {
                                                        echo "<td> $value </td>";
                                                    }
                                                }
                                                echo "<td> <div class='form-check mx-auto'>
                                                        <input name='deleteRev[]' class='form-check-input' type='checkbox' value='$row[ID]'>
                                                    </div> </td>";
                                                echo "</tr>";
                                            }
                                            echo "<tr> <td colspan='$rev_result->field_count'> $num_rec_output </td> </tr> </tbody>";
                                        } else {
                                            echo $num_rec_output;
                                        }
                                    } else {
                                        echo "ERRORE: $conn->error \n $rev_query";
                                    }
                                ?>
                            </table>
                            <div id="deleteButContainer">
                                <button class="btn btn-secondary" type="submit" disabled>
                                    <span><i class="bi bi-trash3-fill"></i></span>
                                    Elimina
                                </button>
                            </div>
                        </div>
                            

                    </form>
                </div>
                <div class="col-12 col-lg-6">
                    <aside class="p-2 bg-white text-center rounded-5">
                        <p class="text-center fs-4"> Vuoi aggiungere una recensione ?</p>
                        <form id="review_form" action="./scripts/review_insert_script.php" method="post">
                            <label for="restaurant" class="form-label"> Ristorante: </label>
                            <select name="restaurant" class="form-select">
                                <?php
                                if ($result = $conn->query(query: "SELECT id_ristorante AS id, nome FROM ristorante")) {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["id"] . "'> " . $row["nome"] . " </option>";
                                        }
                                    } else {
                                        echo "<option value='not_available'> Nessun ristorante disponibile </option>";
                                    }
                                } else {
                                    echo "ERRORE";
                                }
                                ?>
                            </select>
                            <label for="#" class="me-2"> Valutazione: </label>
                            <div class="rating d-flex justify-content-center align-items-center">
                                <input value="5" name="rating" id="star5" type="radio"/>
                                <label title="5 stars" for="star5">
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgOne">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgTwo">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <div class="ombre"></div>
                                </label>

                                <input value="4" name="rating" id="star4" type="radio" />
                                <label title="4 stars" for="star4">
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgOne">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgTwo">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <div class="ombre"></div>
                                </label>

                                <input value="3" name="rating" id="star3" type="radio" />
                                <label title="3 stars" for="star3">
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgOne">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgTwo">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <div class="ombre"></div>
                                </label>

                                <input value="2" name="rating" id="star2" type="radio" />
                                <label title="2 stars" for="star2">
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgOne">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgTwo">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <div class="ombre"></div>
                                </label>

                                <input value="1" name="rating" id="star1" type="radio" />
                                <label title="1 star" for="star1">
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgOne">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                        stroke="#000000" fill="none" viewBox="0 0 24 24" height="35" width="35"
                                        xmlns="http://www.w3.org/2000/svg" class="svgTwo">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <div class="ombre"></div>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-warning fw-bold d-block mx-auto"> REGISTRA </button>
                        </form>
                    </aside>
                </div>
            </div>
            <hr>
        </div>
        <div id="resturant_info_space">
            <div class="bg-white w-75 mx-auto text-center p-3 rounded-5">
                <p class="fs-4"> Vuoi saperne di più su un ristorante? </p> <br>
                <form action="rest_info.php" method="get">
                    <label for="nome_ristorante" class="form-label"> CERCALO QUI! </label>
                    <select name="nome_ristorante" class="form-select w-25 mx-auto mt-3 mb-4">
                        <?php
                            if ($result = $conn->query(query: "SELECT id_ristorante AS id, nome FROM ristorante")) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["id"] . "'> " . $row["nome"] . " </option>";
                                    }
                                } else {
                                    echo "<option value='not_available'> Nessun ristorante disponibile </option>";
                                }
                            } else {
                                echo "ERRORE";
                                exit;
                            }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-warning fw-bold"> RICERCA </button>
                </form>
            </div>
        </div>
        <hr>
        <!--<button id="logout_button" type="submit" class="w-25 btn btn-danger fw-bold fs-5 d-block mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()"> LOGOUT </button>-->
        <!-- From Uiverse.io by vinodjangid07 -->
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
    <!--? JAVASCRIPT PERSONALE-->
    <script src="../javascript/script.js"></script>
    <script src="../javascript/footer.js"></script>
</body>

</html>
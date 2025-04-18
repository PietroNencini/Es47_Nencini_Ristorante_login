<?php
    session_start();

    if(!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if(!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        header(header: "Location: ../index.php");
    }

    $logged_user = $_SESSION["session_user"];

    $info_list = ["USERNAME", "NOME", "COGNOME", "EMAIL", "MEMBRO DAL"];
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login effettuato</title>
        <!--* BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!--*CSS PERSONALE-->
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body id="personal_page">

        <header class="d-flex align-items-center justify-content-center bg-warning">
            <span><img id="icon" src="../images/logo.png" alt="risto&rece" width=96px" class="d-block mx-auto"></span>
            <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
        </header>
        
        <div id="results_container" class="my-5 border border-1 border-black rounded-4 p-3 mx-auto w-75 bg-secondary-subtle shadow-lg">
            <?php
                switch($_SESSION["error_code"]) {
                    case 0:
                        $output = "<h3 class='text-center p-3 w-25 mx-auto rounded-3 text-white'> ACCESSO EFFETTUATO </h3> <p class='text-center fs-4 '> Benvenuto <span class='fw-bold'> $logged_user </span> </p>";
                        break;
                    case -2:
                        $output = "<p class='text-center fs-4'> Grazie per la tua recensione, <span class='fw-bold'> $logged_user </span> </p>";
                        break;
                    case 3:
                        $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-3'> ERRORE: impossibile inserire la recensione, controlla i dati e riprova </p>";
                        break;                        
                    default:
                        echo "ERRORE";
                        exit;
                }
                echo $output;
                $_SESSION["error_code"] = 0;
            ?>
            
            <hr>

            <div id="info_container" class="w-50 mx-auto">
                <p class=" fw-bold fs-4 "> Informazioni utente </p>
                <ul id="user_info">
                    <?php 
                        include "connection.php";
                        $query = "SELECT username, nome, cognome, email, data_reg FROM utente WHERE username = '$logged_user' ";
                        if($result = $conn->query(query: $query)) {
                            if($result->num_rows > 0) {
                                while($row= $result->fetch_assoc()) {
                                    $count = 0;
                                    foreach($row as $value) {
                                        echo "<li>".$info_list[$count].": <b> $value </b></li>";
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
                    <div class="col col-sm-6">
                        <div id="rev_table_container" class="w-100 mx-auto px-5">
                            <table id="revs_table" class="table table-bordered border-warning rounded-3" style="border-radius: 0.3rem !important;">    
                                <?php
                                    include "./scripts/utils.php";
                                    $required_id = getUserIDByUsername($logged_user);
                                    $rev_query = "SELECT RT.nome, RT.indirizzo, RV.voto, RV.data_rec FROM recensione RV INNER JOIN ristorante RT ON RV.id_ristorante = RT.id_ristorante WHERE RV.id_utente = $required_id";
                                    if($rev_result = $conn->query(query: $rev_query)) {
                                        $num_rec_output = "<p class='fs-4 text-center'> Recensioni totali: $rev_result->num_rows </p>";
                                        if($rev_result->num_rows > 0) {
                                            echo "<thead class='table-light'> <tr class='table-warning-subtle'>";
                                            while($field = $rev_result->fetch_field()) {
                                                echo "<th> $field->name </th>";
                                            }
                                            echo "</tr> </thead> <tbody>";
                                            while($row = $rev_result->fetch_assoc()) {
                                                echo "<tr>";
                                                foreach($row as $value) {
                                                    echo "<td> $value </td>";
                                                }
                                                echo"</tr>";
                                            }
                                            echo "<tr> <td colspan='4'> $num_rec_output </td> </tr> </tbody>";
                                        } else {
                                            echo $num_rec_output;
                                        }
                                    } else {
                                        echo "ERRORE: Impossibile trovare recensioni";
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <aside class="p-2 bg-white text-center rounded-5">
                            <p class="text-center fs-4"> Vuoi aggiungere una recensione ?</p>
                            <form id="review_form" action="./scripts/review_insert_script.php" method="post">
                                <label for="restaurant" class="form-label"> Ristorante: </label>
                                <select name="restaurant" class="form-select">
                                    <?php
                                        if($result = $conn->query(query: "SELECT id_ristorante AS id, nome FROM ristorante")) {
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='".$row["id"]."'> ".$row["nome"]." </option>";
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
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="vote" value="1" class="form-check-input" id="vote-1">
                                    <label for="vote-1" class="form-check-label"> 1 </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="vote" value="2" class="form-check-input" id="vote-3">
                                    <label for="vote-1" class="form-check-label"> 2 </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="vote" value="3" class="form-check-input" id="vote-3" checked>
                                    <label for="vote-3" class="form-check-label"> 3 </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="vote" value="4" class="form-check-input" id="vote-4">
                                    <label for="vote-4" class="form-check-label"> 4 </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="vote" value="5" class="form-check-input" id="vote-5">
                                    <label for="vote-5" class="form-check-label"> 5 </label>
                                </div>
                                <button type="submit" class="btn text-white fw-bold d-block mx-auto" style="background-color: black !important;"> REGISTRA </button>
                            </form>
                        </aside>
                    </div>
                </div>
                <hr>
            </div>
            <form action="./scripts/logout_script.php" method="post">
                <button type="submit" class="btn btn-danger fw-bold fs-5 d-block mx-auto"> LOGOUT </button>
            </form>
        </div>


        <!--? SCRIPT DI BOOTSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!--? JAVASCRIPT PERSONALE-->
        <script src="../../../javascript/script.js"></script>
    </body>
</html>

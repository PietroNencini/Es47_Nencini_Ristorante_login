<?php
    session_start();

    if(!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if(!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        header(header: "Location: ../index.php");
    }

    $logged_user = $_SESSION["session_user"];

    $log_user_id = "";

    $info_list = ["ID:", "USERNAME", "PASSWORD", "NOME:", "COGNOME:", "EMAIL:", "MEMBRO DAL:"];
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
        <!--CSS PERSONALE-->
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>

        <header class="d-flex align-items-center justify-content-center bg-warning">
            <span><img id="icon" src="../images/logo.png" alt="risto&rece" width=96px" class="d-block mx-auto"></span>
            <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
        </header>
        
        <div id="results_container" class="my-5 border border-1 border-black rounded-4 p-3 mx-auto w-75 bg-secondary-subtle shadow-lg">
            <h3 class="text-center p-3 w-25 mx-auto rounded-3 text-white"> ACCESSO EFFETTUATO </h3>
            <?php
                switch($_SESSION["error_code"]) {
                    case 0:
                        $output = "<p class='text-center fs-4 '> Benvenuto <span class='fw-bold'> $logged_user </span> </p>";
                        break;
                    case -2:
                        $output = "<p class='text-center fs-4'> Grazie per la tua recensione, <span class='fw-bold'> $logged_user </span> </p>";
                        break;
                    case 3:
                        $output = "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-5'> ERRORE: impossibie inserire la recensione, controlla i dati e riprova </p>";
                        break;                        
                    default:
                        echo "ERRORE";
                        exit;
                }
                $_SESSION["error_code"] = 0;
            ?>
            
            <hr>

            <div id="info_container" class="w-50 mx-auto">
                <p class=" fw-bold fs-4 "> Informazioni utente </p>
                <ul id="user_info">
                    <?php 
                        include "connection.php";
                        $query = "SELECT * FROM utente WHERE username = '$logged_user' ";
                        if($result = $conn->query(query: $query)) {
                            if($result->num_rows > 0) {
                                while($row= $result->fetch_assoc()) {
                                    $count = 0;
                                    foreach($row as $value) {
                                        if($count == 0)
                                            $log_user_id = $value;
                                        echo "<li>".$info_list[$count]."<b> $value </b></li>";
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
                                    $rev_query = "SELECT RT.nome, RT.indirizzo, RV.voto, RV.data_rec FROM recensione RV INNER JOIN ristorante RT ON RV.cod_risto = RT.codice WHERE RV.id_utente = $log_user_id;";
                                    if($rev_result = $conn->query(query: $rev_query)) {
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
                                                echo"</tr> </tbody>";
                                            }
                                        } else {
                                            "Non hai ancora scritto recensioni: VERGOGNATI!";
                                        }
                                    } else {
                                        echo "ERRORE";
                                    }
                                ?>
                            </table>
                        </div>
                        <p class="fs-4 text-center mt-4"> Recensioni totali: 
                            <?php 
                                $rev_query = "SELECT * FROM utente U INNER JOIN recensione R ON U.id_cliente = R.id_utente WHERE U.username = '$logged_user'";
                                if($rev_result = $conn->query(query: $rev_query)) {
                                    echo $rev_result->num_rows;
                                } else {
                                    echo "c'è un problema";
                                }
                            ?>
                        </p>
                    </div>
                    <div class="col col-sm-6">
                        <aside class="px-4 bg-white rounded-5">
                            <p for="#" class="text-center"> Vuoi aggiungere una recensione ?</p>
                            <form id="review_form" action="./scripts/review_insert_script.php" method="post">
                                <label for="restaurant" class="form-label"> Ristorante: </label>
                                <select name="restaurant" class="form-select">
                                    <?php 
                                        if($result = $conn->query(query: "SELECT codice AS id, nome FROM ristorante")) {
                                            if($result->num_rows) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='".$row["id"]."'> ".$row["nome"]." </option>";
                                                }
                                            } else {
                                                echo "<option value='not_available'> Nessun ristorante disponibile </option>";
                                            }
                                        } else {
                                            echo "ERRORE: Impossibile trovare ristoranti";
                                        }
                                    ?>
                                </select>
                                <label for="#"> Valutazione </label>
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
            </div>
            <hr>
            <form action="./scripts/logout_script.php" method="post">
                <button type="submit" class="btn btn-danger fw-bold fs-5 d-block mx-auto"> LOGOUT </button>
            </form>
        </div>

    </body>
</html>

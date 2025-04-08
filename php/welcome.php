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
            <hr>
            <p class="text-center fs-4 "><?php echo "Benvenuto <span class='fw-bold'> $logged_user </span>"?> </p>
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
            <div id="reviews_space" class="w-100">
                <p class="fs-4 text-center"> Recensioni scritte: 
                    <?php 
                        $rev_query = "SELECT * FROM utente U INNER JOIN recensione R ON U.id_cliente = R.id_utente WHERE U.username = '$logged_user'";
                        if($rev_result = $conn->query(query: $rev_query)) {
                            echo $rev_result->num_rows;
                        } else {
                            echo "c'è un problema";
                        }
                    ?>
                </p>
                <div id="rev_table_container" class="w-50 mx-auto">
                    <table id="revs_table" class="table border border-warning rounded-3" style="border-radius: 0.3rem !important;">    
                        <?php
                            $rev_query = "SELECT RT.nome, RT.indirizzo, RV.voto, RV.data_rec FROM recensione RV INNER JOIN ristorante RT ON RV.cod_risto = RT.codice WHERE RV.id_utente = $log_user_id;";
                            if($rev_result = $conn->query($rev_query)) {
                                if($rev_result->num_rows > 0) {
                                    echo "<tr class='bg-'>";
                                    while($field = $rev_result->fetch_field()) {
                                        echo "<th> ".$field->name." </th>";
                                    }
                                    echo "</tr>";
                                    while($row = $rev_result->fetch_assoc()) {
                                        echo "<tr>";
                                        foreach($row as $value) {
                                            echo "<td> $value </td>";
                                        }
                                        echo"</tr>";
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
            </div>
            <hr>
            <form action="./scripts/logout_script.php" method="post">
                <button type="submit" class="btn btn-danger fw-bold fs-5 d-block mx-auto"> LOGOUT </button>
            </form>
        </div>

    </body>
</html>

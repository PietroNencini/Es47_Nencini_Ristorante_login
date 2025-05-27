<?php
    session_start();

    include "connection.php";

    if (!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if (!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        header(header: "Location: ../index.php");
        exit;
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
    <body id="">
        
        <div id="user_info_container">

            <div id="info_container" class="w-50 mx-auto">
                <p class=" fw-bold fs-4 "> Informazioni utente </p>
                <ul id="user_info" style="list-style-type: none;">
                    <?php
                    $query = "SELECT U.username as USERNAME, U.nome as NOME, U.cognome as COGNOME, U.email AS EMAIL, U.data_reg as MEMBRO DAL, count(R.id_utente) as RECENSIONI:  
                            FROM utente U INNER JOIN recensione R ON U.id_utente = R.id_utente WHERE U.username = '$logged_user'";
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
            <div id="change_pw_container" class="text-center">
                <button id="button_to_delete" type="button" class="btn btn-warning fw-bold" onclick="managePwChangeForm()"> CAMBIO PASSWORD </button>
                <form action="./scripts/change_password.php" method="post" class="d-none" id="change_pw_form">
                    <label for="new_password"><input type="password" name="new_password" class="form-control" placeholder="nuova password..." minlength="8" required></label>
                    <button type="submit" class="btn btn-warning fw-bold"> CAMBIA </button>
                </form>
            </div>
            <hr>


        </div>

        <script src="../javascript/script.js"></script>
        <script src="../javascript/footer.js"></script>
    </body>

</html>

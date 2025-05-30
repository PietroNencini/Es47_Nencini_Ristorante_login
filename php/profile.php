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
        
    </head>
    <body id="profile_page" class="has_footer">
        
        <header class="w-100 bg-warning">
            <div class="container">
                <nav class="navbar navbar-expand-lg sticky-top">
                    <div class="container-fluid fs-5">
                        <a class="navbar-brand jaini text-center" href="../pages/website_intro.html">
                            <span style="font-size: 3rem;">
                                <img src="../images/logo.png" alt="risto&rece" width="96px"
                                class="d-inline-block align-text-center">
                            RISTO&RECE </span>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse ps-3" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="../pages/website_intro.html">Homepage</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="welcome.php">Area Personale</a>
                                </li>
                                
                            </ul>
                            <div class="ms-auto" role="search">
                                <div class="profile_elements" id="nav_right">
                                    <a class="nav-link active" aria-current="page" href="#">
                                        <span class="d-flex align-items-center"></span>
                                            <i class="bi bi-person-fill" style="font-size: 3rem; opacity: 1 !important;" id="profile_icon"></i>
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

        <div class="content">            
            <div id="page_container" class="my-5 border rounded-4 p-3 mx-auto w-75 bg-secondary-subtle">

                <div id="info_container" class="w-50 mx-auto">
                    <h2 class="text-center"> INFORMAZIONI UTENTE </h2>
                    <hr />
                    <ul id="user_info" style="list-style-type: none;">
                        <?php
                        $query = "SELECT U.username as USERNAME, U.nome as NOME, U.cognome as COGNOME, U.email AS EMAIL, date(U.data_reg) as REGISTRAZIONE, count(R.id_utente) as RECENSIONI  
                                FROM utente U INNER JOIN recensione R ON U.id_cliente = R.id_utente WHERE U.username = '$logged_user'";
                        $query_last_rev = "SELECT date(data_rec) as ULTIMA_RECENSIONE 
                                FROM recensione WHERE id_utente = (SELECT id_utente FROM utente WHERE username = '$logged_user') 
                                ORDER BY data_rec DESC LIMIT 1";
                        if ($result = $conn->query(query: $query)) {
                            if($result_last_rev = $conn->query(query: $query_last_rev)) {
                                if ($result->num_rows > 0 && $result_last_rev->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        foreach ($row as $key => $value) {
                                            $field_name = $key == "REGISTRAZIONE" ? "MEMBRO DAL" : $key;
                                            echo "<li> $field_name: <b> $value </b></li>";

                                        }
                                        $last_rev = $result_last_rev->fetch_assoc()["ULTIMA_RECENSIONE"];
                                        echo "<li> ULTIMA RECENSIONE: <b> $last_rev </b></li>";
                                    }
                                } else {
                                    echo "Impossibile completare la richiesta dei dati: $conn->error";
                                }
                            }
                        } else {
                            echo "c'è un problema";
                        }
                        ?>
                    </ul>
                    <hr>
                </div>
                
                <div id="change_pw_container" class="text-center">
                    <button id="button_to_delete" type="button" class="btn btn-warning fw-bold" onclick="managePwChangeForm()"> CAMBIO PASSWORD </button>
                    <form action="./scripts/change_password.php" method="post" class="d-none" id="change_pw_form">
                        <label for="new_password"><input type="password" name="new_password" class="form-control" placeholder="nuova password..." minlength="8" required></label>
                        <button type="submit" class="btn btn-warning fw-bold"> CAMBIA </button>
                    </form>
                </div>

            </div>

        </div>

        <!--finestra di LOGOUT (si apre al click del pulsante prima)-->
        <div id="logout-box" class="d-none"></div>


        <script src="../javascript/script.js"></script>
        <script src="../javascript/footer.js"></script>
        <script src="../javascript/logout.js"></script>
    </body>

</html>

<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--* TITOLO DELLA PAGINA-->
    <title>Risto & rece</title>
    <!--* FAVICON-->
    <link rel="icon" type="image/x-icon" href="./images/logo.png">
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--* CSS PERSONALE-->
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="d-flex align-items-center justify-content-center bg-warning">
        <span><img id="icon" src="./images/logo.png" alt="risto&rece" width=96px" class="d-block mx-auto"></span>
        <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
    </header>

    <div id="home_form_container" class="w-75 mx-auto bg-white p-4 mt-4">

        <div id="form_inside" class="w-50 border border-1 border-black rounded-3 p-3 mx-auto my-5">
            <form id="login_form" action="php/scripts/login_script.php" method="post">
                <label for="username" class="form-label">Nome utente</label>
                <input type="text" name="username" id="username" class="form_input form-control" minlength="4" required>

                <label for="password" class="form-label"> Password</label>
                <input type="password" name="password" id="password" class="form_input form-control" minlength="8" required>
            
                <button type="submit" class="btn btn-warning fw-bold"> ACCEDI </button>
            </form>

            <?php 
                if (isset($_SESSION["error_code"])) {
                    
                    switch($_SESSION["error_code"]) {
                        case 1:
                            $output = "Utente non trovato";
                            break;
                        case 2:
                            $output = "Password errata";
                            break;
                        default:
                            $output = "BOH";
                    }

                    echo "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-5'> ERRORE: $output </p>";

                    unset($_SESSION["error_code"]);
                }
            ?>

            <p> Non hai un account? <a href="./php/registration.php"> Registrati ora </a> </p>
        </div>    
    </div>



    <!--? SCRIPT DI BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--? JAVASCRIPT PERSONALE-->
    <script src="./javascript/script.js"></script>
</body>
</html>
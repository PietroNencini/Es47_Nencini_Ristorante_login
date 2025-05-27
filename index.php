<?php
session_start();

if (!isset($_SESSION["error_code"]))
    $_SESSION["error_code"] = 0;

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--* CSS PERSONALE-->
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body class="log_page has_footer">

    
    
    <header class="d-flex align-items-center justify-content-center bg-warning">
        <span><img id="icon" src="./images/logo.png" alt="risto&rece" width=96px" class="d-block mx-auto"></span>
        <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
    </header>
    

    <div class="content">
        <div class="d-flex align-items-center justify-content-center">
            <div id="home_form_container" class="w-75 mx-auto bg-secondary-subtle p-4">

                <p class="text-center fs-5"> Inserisci le credenziali per accedere alle tue risorse e sfruttare le funzionalità del nostro servizio </p>

                <div id="form_inside" class="w-50 bg-white  rounded-3 p-3 mx-auto my-5">
                    <form id="login_form" action="php/scripts/login_script.php" method="post">
                        <label for="username" class="form-label">Nome utente</label>
                        <input type="text" name="username" id="username" class="form_input form-control" minlength="4"
                            required>
                        <label for="password" class="form-label"> Password</label>
                        <input type="password" name="password" id="password" class="form_input form-control"
                            minlength="8" required>
                        <button type="submit" class="btn btn-warning fw-bold my-3"> ACCEDI </button>
                    </form>

                    <?php
                        if (isset($_SESSION["error_code"])) {
                            $error = true;
                            switch ($_SESSION["error_code"]) {
                                case 1:
                                    $output = "Utente non trovato";
                                    break;
                                case 2:
                                    $output = "Password errata";
                                    break;
                                default:
                                    $error = false;
                            }
                            if ($error)
                                echo "<p class='bg-danger text-white fw-bold text-center rounded-3 mt-2 mb-3 fs-5'> ERRORE: $output </p>";
                            unset($_SESSION["error_code"]);
                        }
                    ?>

                    <p class="my-3"> Non hai un account? <a href="./php/registration.php"> Registrati ora </a> </p>

                    <!--in progress-->
                    <p class="my-3"><a href="#" onclick="document.write('<p>mi dispiace</p>')"> Password
                            dimenticata</a>?</p>
                </div>
            </div>
        </div>
        </di>



        <!--? SCRIPT DI BOOTSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <!--? JAVASCRIPT PERSONALE-->
        <script src="./javascript/script.js"></script>
        <script src="./javascript/footer.js"></script>
</body>

</html>
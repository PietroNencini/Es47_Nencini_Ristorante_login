<?php
    session_start();

    if(!isset($_SESSION["error_code"])) 
        $_SESSION["error_code"] = 0;

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--* FAVICON -->
    <link rel="shortcut icon" href="../images/favicons/add-user.png" type="image/x-icon">
    <!--* TITOLO DELLA PAGINA-->
    <title>Risto & rece</title>
    <!--* FAVICON-->
    <link rel="icon" type="image/x-icon" href="./images/logo.png">
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--* CSS PERSONALE-->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="log_page has_footer">
    <header class="d-flex align-items-center justify-content-center bg-warning">
        <span><img id="icon" src="../images/logo.png" alt="risto&rece" width=96px" class="d-block mx-auto"></span>
        <h1 class="home_title jaini text-center"> RISTO&RECE </h1>
    </header>

    <div id="home_form_container" class="w-75 mx-auto bg-secondary-subtle p-4 mt-4">

        <div id="form_inside" class="w-50 rounded-3 p-3 mx-auto my-5 bg-white">
            <h3 class="text-center"> REGISTRAZIONE NUOVO UTENTE </h3>
            <hr>
            <form id="login_form" action="./scripts/registration_script.php" method="post">
                <label for="name" class="form-label"> Nome </label>
                <input type="text" name="name" id="name" class="form_input form-control" required>

                <label for="surname" class="form-label"> Cognome </label>
                <input type="text" name="surname" id="surname" class="form_input form-control" required>

                <label for="email" class="form-label"> email </label>
                <input type="email" name="email" id="email" class="form_input form-control" required>

                <label for="username" class="form-label">Nome utente</label>
                <input type="text" name="username" id="username" class="form_input form-control" minlength="4" required>

                <label for="password" class="form-label"> Password</label>
                <input type="password" name="password" id="password" class="form_input form-control" minlength="8" required>
            
                <div class="form-check my-3">
                    <input class="form-check-input" type="radio" name="terms_cond" id="terms_cond1" required>
                    <label class="form-check-label" for="terms_cond1"> Accetto i termini e le condizioni di &copyRisto&Rece *</label>
                </div>
                <button type="submit" class="btn btn-warning fw-bold my-3"> CREA ACCOUNT </button>
            </form>

            <?php 
                if (isset($_SESSION["error_code"])) {
                    $error = true;
                    switch($_SESSION["error_code"]) {
                        case 4:
                            $output = "Nome utente già in uso, provane un altro";
                            break;
                        case 5:
                            $output = "Indirizzo email già presente, un fà i'furbo";
                            break;
                        default:
                            $error = false;
                    }
                    if($error)
                        echo "<p class='bg-danger text-white fw-bold text-center rounded-3 my-2 fs-5'> ERRORE: $output </p>";
                    $_SESSION["error_code"] = 0;
                }
            ?>

            <p> Hai già un profilo? <a href="../index.php"> Accedi </a> </p>
        </div>    
    </div>



    <!--? SCRIPT DI BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--? JAVASCRIPT PERSONALE-->
    <script src="../javascript/script.js"></script>
    <script src="../javascript/footer.js"></script>
</body>
</html>
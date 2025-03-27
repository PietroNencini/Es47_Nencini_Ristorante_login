<?php
    session_start();

    if(!isset($_SESSION["error_code"])) {
        header(header: "Location: ../index.html");  
    }
    if(isset($_SESSION["session_user"])) {
        unset($_SESSION["session_user"]);
    }

    session_destroy();
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--* BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>ERRORE LOGIN</title>
    </head>
    <body>

        <h1 class="w-100 text-center bg-danger text-white p-3">ERRORE NEL LOGIN</h1>
        
        <div class="my-5 border border-1 border-black rounded-3 p-3 mx-auto w-75 bg-secondary-subtle shadow-lg">
            <p class="text-center fw-bold fs-4 ">
                <?php
                    switch($_SESSION["error_code"]) {
                        case 1:
                            echo "Utente non trovato";
                            break;
                        case 2:
                            echo "Password errata";
                            break;
                        case 3:
                            echo "Errore nella richiesta, ci scusiamo per il problema";
                            break;
                        case 4:
                            echo "Nome utente già in uso, prova con un altro";
                        case 5:
                            echo "Indirizzo email già in uso, non fare il furbo!";
                        default:
                            echo "Errore sconosciuto";
                    }
                ?>
            </p>
        </div>

        <p class="text-center"><a href="../index.html" class="link fw-bold fs-4">Torna alla pagina di login</a></p>
    </body>
</html>
<?php
    session_start();

    if(isset($_SESSION["error_code"])) {
        unset($_SESSION["error_code"]);
    }
    if(isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        unset($_SESSION["session_user"]);
    }

    session_destroy();

    header("Location: ../../index.php");



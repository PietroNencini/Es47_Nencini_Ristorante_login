

<?php

    //* ATTENZIONE: Questa pagina inizialmente non conteneva codice PHP, ma in seguito a modifiche necessarie apportate al dito è stato necessario cambiare il formato
    //* Per non causare problemi tra i percorsi e rendere più semplice la gestione dei file, la pagina risulta comunque tra quelle HTML
    session_start();

    include "../php/connection.php";

    if($result = $conn->query("SELECT count(*) as total FROM utente WHERE is_admin = 0")) {
        $total_users = $result->fetch_assoc()["total"]; 
    } else {
        header("Location: error.html");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il nostro servizio</title>
    <!--* FAVICON -->
    <link rel="shortcut icon" href="../images/favicons/user.png" type="image/x-icon">
    <!--* BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--*CSS PERSONALE-->
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <!--*ALTRO CSS-->
    <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
    
</head>

<body id="info_page" class="has_footer">

    <header class="w-100 bg-warning">
        <div class="container">
            <nav class="navbar navbar-expand-lg sticky-top">
                <div class="container-fluid fs-5">
                    <a class="navbar-brand jaini text-center" href="#">
                        <span style="font-size: 3rem;">
                            <img src="../images/icons/R&R_definitivo.png" alt="risto&rece" width="96px"
                            class="d-inline-block align-text-center">
                        <span class="ms-2">RISTO&RECE </span></span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse ps-3" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Homepage</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(!isset($_SESSION["session_user"])) echo "disabled"?>" href="<?php echo isset($_SESSION["session_user"]) ? "../php/welcome.php" : "#" ?>" onclick="disable_scroll()">
                                    Area Personale</a>
                            </li>
                            
                        </ul>
                        <div class="ms-auto" role="search">
                            <div class="profile_elements" id="nav_right">
                                <?php
                                    if(isset($_SESSION["session_user"])) {
                                        echo "<a class='nav-link' href='../php/profile.php'>
                                            <span class='d-flex align-items-center'></span>
                                                <i class='bi bi-person-fill' style='font-size: 3rem;' id='profile_icon'></i>
                                            </span>
                                            </a>";
                                    } else {
                                        echo "<a class='nav-link w-50' href='../php/registration.php'>
                                            <button class='btn btn-primary fw-bold'>
                                                REGISTRATI
                                            </button>
                                            </a>
                                            <a class='nav-link w-50' href='../'>
                                                <button class='btn btn-success fw-bold'>
                                                    ACCEDI
                                                </button>
                                            </a>";
                                    }
                                ?>
                                <!--
                                <a class="nav-link" href="../php/profile.php">
                                    <span class="d-flex align-items-center"></span>
                                        <i class="bi bi-person-fill" style="font-size: 3rem;" id="profile_icon"></i>
                                    </span>
                                </a>
                                -->
                                <!--<button id="logout_button" type="submit" class="w-25 btn btn-danger fw-bold fs-5 d-block mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()"> LOGOUT </button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="content">
        <div class="w-75 mx-auto bg-secondary-subtle p-5 rounded-5" id="informazioni">
            <div class="row">
                <div class="col col-md-6 fs-5">
                    <p> Risto&Rece è il nostro servizio che permette di lasciare recensioni nei tuoi ristoranti preferiti </p>
                    <p> Ogni utente può lasciare una recensione e visualizzare le recensioni dei ristoranti </p>
                    <p> <b><?php echo $total_users ?></b> utenti si sono già uniti alla nostra community, fallo anche tu!</p>
                </div>
                <div class="col col-md-6">
                    <img src="../images/icons/R&R.png" width="256px" height="256px" alt="logo" class="d-block mx-auto">
                </div>
            </div>
        </div>
    </div>

    <!--finestra di LOGOUT (si apre al click del pulsante prima)-->
    <div id="logout-box" class="d-none">
    </div>

    <script src="../javascript/script.js"> </script>
    <script src="../javascript/footer.js"> </script>
    <?php
        if(isset($_SESSION["session_user"])) {
            echo "<script src='../javascript/logout.js'></script>";
        }
    ?>
</body>

</html>
<?php
    session_start();

    if(!isset($_SESSION["error_code"])) {
        $_SESSION["error_code"] = 0;
    }
    if(!isset($_SESSION["session_user"])) {         //? Nel caso si accedesse a questa pagina senza aver fatto il login
        header(header: "Location: ../index.html");
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--* BOOTSTRAP-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Login effettuato</title>
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
            <p class="text-center fs-4 "><?php echo "Benvenuto <span class='fw-bold'>" . $_SESSION["session_user"] . "</span>"?> </p>
            <hr>

            <div id="info_container">
                <ul>
                    <?php 
                        include "connection.php";
                        $query = "SELECT * FROM utente";
                        
                        if($result = $conn->query($query)) {
                            
                            while($row= $result->fetch_assoc()) {
                                
                                foreach($row as $value) {
                                    
                                }

                            }

                        }
                    ?>
                </ul>
            </div>


            <form action="logout_script.php" method="post">
                <button type="submit" class="btn btn-danger fw-bold fs-5 d-block mx-auto"> LOGOUT </button>
            </form>
        </div>

    </body>
</html>

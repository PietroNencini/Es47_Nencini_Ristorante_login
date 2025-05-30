document.addEventListener("DOMContentLoaded", function () {
    createLogoutButton();
    createBox();
})

/** 
 * <!--<div class="logout-content">
            <h2> Sei sicuro di voler effettuare la disconnessione? </h2>
            <h5> Sarà necessario ripetere l'accesso per poter tornare a questa pagina </h5>
            <div class="buttons">
                <form action="./scripts/logout_script.php" method="post">
                    <button id="confirm-logout" type="submit" class="btn btn-danger"
                        onclick="hide('logout-box'), enable_scroll()">CONFERMA</button>
                    <button id="cancel-logout" type="button" class="btn btn-outline-danger"
                        onclick="hide('logout-box'), enable_scroll()">ANNULLA</button>
                </form>
            </div>
        </div>-->
*/
function createBox() {
    // Recupera il div con id logout-box
    let logoutBox = document.getElementById("logout-box");

    if (!logoutBox) {
        console.error("Elemento con id 'logout-box' non trovato.");
        return;
    }

    // Crea il div principale
    let logoutContent = document.createElement("div");
    logoutContent.className = "logout-content";

    // Titolo
    let heading = document.createElement("h2");
    heading.textContent = "Sei sicuro di voler effettuare la disconnessione?";

    // Sottotitolo
    let subheading = document.createElement("h5");
    subheading.textContent = "Sarà necessario ripetere l'accesso per poter tornare a questa pagina";

    // Div per i pulsanti
    let buttonsDiv = document.createElement("div");
    buttonsDiv.className = "buttons";

    // Form
    let form = document.createElement("form");
    form.action = "./scripts/logout_script.php";
    form.method = "post";

    // Pulsante di conferma logout
    let confirmButton = document.createElement("button");
    confirmButton.id = "confirm-logout";
    confirmButton.type = "submit";
    confirmButton.className = "btn btn-danger";
    confirmButton.textContent = "CONFERMA";
    confirmButton.setAttribute("onclick", "hide('logout-box'); enable_scroll();");

    // Pulsante di annullamento logout
    let cancelButton = document.createElement("button");
    cancelButton.id = "cancel-logout";
    cancelButton.type = "button";
    cancelButton.className = "btn btn-outline-danger";
    cancelButton.textContent = "ANNULLA";
    cancelButton.setAttribute("onclick", "hide('logout-box'); enable_scroll();");

    // Assemblaggio degli elementi
    form.appendChild(confirmButton);
    form.appendChild(cancelButton);
    buttonsDiv.appendChild(form);
    logoutContent.appendChild(heading);
    logoutContent.appendChild(subheading);
    logoutContent.appendChild(buttonsDiv);

    // Aggiunta al logout-box
    logoutBox.appendChild(logoutContent);
}


/**
 * <!--<button id="logout_button" type="submit" class="w-25 btn btn-danger fw-bold fs-5 d-block mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()"> LOGOUT </button>-->
                                <!-- From Uiverse.io by vinodjangid07 -->
                                <!--<button id="logout_button" class="Btn mx-auto" onclick="show('logout-box', 'flex'), disable_scroll()">
                                    <div class="sign">
                                        <svg viewBox="0 0 512 512">
                                            <path
                                                d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="text">Logout</div>
                                </button>-->
 */
function createLogoutButton() {
    // Recupera il div con id nav_right
    let navRight = document.getElementById("nav_right");

    if (!navRight) {
        console.error("Elemento con id 'nav_right' non trovato.");
        return;
    }

    // Creazione del pulsante logout
    let logoutButton = document.createElement("button");
    logoutButton.id = "logout_button";
    logoutButton.className = "Btn mx-auto";
    logoutButton.setAttribute("onclick", "show('logout-box', 'flex'); disable_scroll();");

    // Creazione della parte visiva del pulsante
    let signDiv = document.createElement("div");
    signDiv.className = "sign";

    let svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svgElement.setAttribute("viewBox", "0 0 512 512");

    let pathElement = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathElement.setAttribute("d", 
        "M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
    );

    // Assemblaggio della parte visiva
    svgElement.appendChild(pathElement);
    signDiv.appendChild(svgElement);

    // Creazione della parte testuale
    let textDiv = document.createElement("div");
    textDiv.className = "text";
    textDiv.textContent = "Logout";

    // Assemblaggio del pulsante
    logoutButton.appendChild(signDiv);
    logoutButton.appendChild(textDiv);

    // Aggiunta al nav_right
    navRight.appendChild(logoutButton);
}


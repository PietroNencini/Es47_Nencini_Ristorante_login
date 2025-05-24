function hideReviewContainer() {
    let container = document.getElementById("rev_table_container");
}

function show(id, display) {
    let element = document.getElementById(id);
    element.classList.remove("d-none");
    element.classList.add("d-" + display);
}

function hide(id) {
    let element = document.getElementById(id);
    element.classList.add("d-none");
}

function disable_scroll() {
    document.body.classList.add("no-scroll");
}

function enable_scroll() {
    document.body.classList.remove("no-scroll");
}

function copyText() {
    let input = document.getElementById("copy_text");
    //input.select();
    let checked_icon = document.getElementById("checked_icon");
    checked_icon.style.display = "block";
    navigator.clipboard.writeText(input.value)
    .then(() => {
        console.log("Copiato!");
    })
    .catch(err => {
        console.error("Errore nella copia: ", err);
    });
}

function setAverage(avg) {
    let space = document.getElementById("review_avg");
    if(avg == 0) {
        space.style.display = "none";
        return;
    }
    space.innerHTML = "Media recensioni: " + avg;
    if (avg <= 2) {
        space.style.backgroundColor = "rgba(255, 0, 0, 0.3)";
    } else if(avg < 4) {
        space.style.backgroundColor = "rgba(255, 255, 0, 0.3)";
    } else {
        space.style.backgroundColor = "rgba(0, 255, 0, 0.3)";
    }
}

function manageDeleteButton() {
    let button = document.getElementById("delete_review_button");
    let checkboxes = document.getElementsByClassName("del_rev");
    for(let i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked) {
            button.disabled = false;
            return;
        }
    }
    button.disabled = true;
}



function managePwChangeForm() {
    hide("button_to_delete");
    show("change_pw_form", "block");
}


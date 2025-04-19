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



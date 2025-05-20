let space = document.getElementsByTagName("body");
if(space[0].classList.contains("has_footer")) {
    createFooter();
}

function createFooter() {
    let footer = document.createElement("footer");
    footer.className = "bg-warning py-4 mt-5";
    
    let container = document.createElement("div");
    container.className = "container text-center text-md-start";
    
    let row = document.createElement("div");
    row.className = "row";
    
    let col1 = createFooterColumn("Chi siamo", "Informazioni sull'azienda", "🛈");
    let col2 = createFooterColumn("Contatti", "Email e telefono", "📞");
    let col3 = createFooterColumn("Privacy", "Politiche sui dati", "🔒");
    let col4 = createFooterColumn("Seguici", "Social network", "🌍");

    row.appendChild(col1);
    row.appendChild(col2);
    row.appendChild(col3);
    row.appendChild(col4);
    
    container.appendChild(row);
    footer.appendChild(container);
    document.body.appendChild(footer);
}

function createFooterColumn(title, text, icon) {
    let col = document.createElement("div");
    col.className = "col-12 col-md-3 mb-3";

    let heading = document.createElement("h5");
    heading.innerHTML = `${icon} ${title}`;

    let paragraph = document.createElement("p");
    paragraph.textContent = text;

    col.appendChild(heading);
    col.appendChild(paragraph);

    return col;
}
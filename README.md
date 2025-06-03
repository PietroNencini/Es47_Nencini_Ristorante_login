# RISTO&RECE #
Si tratta di un progetto semplicissimo che mostra il funzionamento di un applicazione web con HTML, CSS e Javascript, a cui viene aggiunto PHP per collegarsi al database dove sono memorizzati i dati necessari all'applicazione per funzionare, e per generare contenuti dinamici nelle varie pagine

Il sito web è adesso disponibile su: https://ristorece.altervista.org/

## FUNZIONALITÀ ##
Le funzionalità offerte dall'applicazione per dimostrazione di come si realizzano in PHP sono in breve: <br>
* Registrazione del proprio account
* Login/out alla propria area di gestione
* Modifica della password (attualmente per modificare altri dati è possibile farlo solo accedendo al DB)
* Possibilità di visionare informazioni di base sui ristoranti attualmente inseriti nel sistema (la lista è in aggiornamento)
* Accesso alla pagina dell'admin (vedi credenziali in fondo) per aggiungere ristoranti a piacere da recensire, anche attraverso l'interazione della mappa

## COMPONENTI ##
L'insieme dei linguaggi di programmazione e di markup utilizzati per creare l'applicazione web:

* <b>HTML</b> per le pagine statiche
* <b>CSS</b> per lo stile e la formattazione di tutte le pagine
* <b>JAVASCRIPT</b> Per realizzare un frontend interattivo agli eventi lato client, insieme a una libreria
    * LEAFLET: Libreria JS che permette l'interazione con le mappe satellitari
* <b>PHP</b> Affiancato alle pagine HTML dinamiche, fa da tramite per il collegamento al database.
    * MSQLi: API che permette l'interazione col DB relazionale SQL
* <b>MySQL</b> è il DBMS che gestisce i dati lato server

## UTENTI ##
Lista di username e password degli utenti con cui è possibile interagire (per vedere degli esempi di pagine già riempite dai dati nel database). <br>
Ogni utente, oltre alle credenziali di accesso, deve indicare nome, cognome e email.

<table>
    <tr>
        <th>
            USERNAME
        </th>
        <th>
            PASSWORD
        </th>
    <tr>
        <td>
            koala14
        </td>
        <td>
            lalala45
        </td>
    </tr>
    <tr>
        <td>
            Hermano
        </td>
        <td>
            lululu45
        </td>
    </tr>
    <tr>
        <td>
            qwerty_pro
        </td>
        <td>
            azerty56!
        </td>
    </tr>
    <tr>
        <td>
            Diescii
        </td>
        <td>
            Location
        </td>
    </tr>
    <tr>
        <td>
            Giorgione
        </td>
        <td>
            Perfetto!!
        </td>
    </tr>
    <tr>
        <td>
            Hotwheels
        </td>
        <td>
            superfast
        </td>
    </tr>
    <tr>
        <td>
            LoStrigo23
        </td>
        <td>
            kaer_morhen
        </td>
    </tr>
    <tr>
        <td>
            Supercar
        </td>
        <td>
            curva_stretta
        </td>
    </tr>
    <tr>
        <td>
            the_dark_side
        </td>
        <td>
            order_66
        </td>
    </tr>
    <tr>
        <td>
            Masterchef
        </td>
        <td>
            Cucina18
        </td>
    </tr>
</table>
utente speciale <br>

* username: <b>admin</b>
* password: <b>ristorante</b>

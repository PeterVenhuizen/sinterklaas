// haal surprises op uit de DB
const surprisePlanner = document.getElementById('surprise-planner');
const template = document.getElementById('surprise-template');

postData('controllers/get_surprise.php', { method: 'GET' })
    .then(data => {
        console.log(data);
        if (data.success) {
            for (let record of data.records) {
                surprisePlanner.appendChild(createSurpriseDiv(template, record));
            }
        }
    })
    .catch(error => {
        console.error(error);
    });

createSurpriseDiv = (template, record) => {
    let clone = template.content.cloneNode(true);

    const div = clone.querySelector('.surprise');
    if (record.isActief) 
        div.classList.add("actief");

    const time = clone.querySelector('time');
    time.setAttribute("datetime", record.datum);
    time.textContent = formatSQLDateToDutchFormat(record.datum);

    const spanPrijs = clone.querySelectorAll(".prijs");
    spanPrijs[0].textContent = record.prijsKlein;
    spanPrijs[1].textContent = record.prijsGroot;

    const i = clone.querySelectorAll('i');
    i[0].classList.add(record.isActief ? "fa-calendar-check" : "fa-calendar");
    i[1].classList.add(record.isGesloten ? "fa-lock" : "fa-lock-open");

    return clone;
}

// voeg nieuwe surprise toe aan de DB
const insertSurprise = document.getElementById('nieuwe-surprise');

// wijzig surprise in de DB

// verwijder surprise (nice to have) en vereist een heel SQL transactie om 
// alle gekoppelde records te verwijderen

// select deelnemers voor de actieve surprise

// doe een trekking voor de actieve surprise met de geselecteerde deelnemers
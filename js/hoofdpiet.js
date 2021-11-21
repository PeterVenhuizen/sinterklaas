// haal surprises op uit de DB
const surprisePlanner = document.getElementById('surprise-planner');
const template = document.getElementById('surprise-template');

postData('controllers/get_surprise.php', { method: 'GET' })
    .then(data => {
        if (data.success) {
            for (let record of data.records) {
                surprisePlanner.appendChild(createSurpriseDiv(template, record));
            }
        }
    })
    .catch(error => console.error(error));

createSurpriseDiv = (template, record) => {
    let clone = template.content.cloneNode(true);

    const div = clone.querySelector('.surprise');
    div.setAttribute('data-surprise-id', record.ID);
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
    i[0].addEventListener('click', wijzigActieveSurprise);
    i[1].classList.add(record.isGesloten ? "fa-lock" : "fa-lock-open");

    return clone;
}

// voeg nieuwe surprise toe aan de DB
const showInsertButton = document.getElementById('show-insert-form');
showInsertButton.addEventListener('click', showModal);

const insertSurprise = document.getElementById('insert-surprise');
insertSurprise.addEventListener('submit', event => {
    event.preventDefault();
    const formData = new FormData(insertSurprise);
    const plainFormData = Object.fromEntries(formData.entries());

    fetch('controllers/insert_surprise.php', 
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(plainFormData)
        })
        .then(response => location.reload())
        .catch(error => console.error(error));
});

// wijzig actieve surprise
wijzigActieveSurprise = function(event) {
    if (this.classList.contains('fa-calendar')) {
        const surpriseID = this.parentNode.getAttribute('data-surprise-id');
        fetch('controllers/wijzig_actieve_surprise.php', 
            {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 'id': surpriseID })
            })
            .then(response => location.reload())
            .catch(error => console.error(error));
    }
}

// verwijder surprise (nice to have) en vereist een heel SQL transactie om 
// alle gekoppelde records te verwijderen

// select deelnemers voor de actieve surprise

// doe een trekking voor de actieve surprise met de geselecteerde deelnemers
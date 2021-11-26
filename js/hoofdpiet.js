let IS_LOCKED = false;

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

	if (record.isActief && record.isGesloten) {
		IS_LOCKED = true;
		lockUp();
	}

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
fetch('controllers/get_surprise_users.php')
	.then(response => response.json())
	.then(data => {
		data.records.forEach(record => {

			const div = document.createElement('div');
			div.classList.add('drag-user');
			div.textContent = record.username;

			if (!IS_LOCKED) {
				div.setAttribute('draggable', 'true');
				div.setAttribute('data-user-id', record.id);
				div.addEventListener('dragstart', handleDragStart)
			}

			(data.selected.includes(record.id))
				? targets[1].appendChild(div)
				: targets[0].appendChild(div);

		});

	})
	.catch(error => console.error(error));

/* drag and drop handlers */
function lockUp() {
	targets[0].classList.add('is-locked');
	targets[1].classList.add('is-locked');
	opslaanButton.setAttribute('disabled', true);
}

function handleDragStart(e) {
	e.dataTransfer.setData("text", e.target.getAttribute('data-user-id'));
	e.target.classList.add('being-dragged');
}

function handleDragEnterLeave(e) {
	(e.type === 'dragenter') 
		? this.classList.add('drag-enter') 
		: this.classList.remove('drag-enter');
}

function handleOverDrop(e) {
	e.preventDefault();
	if (e.type != 'drop') {
		e.target.classList.remove('being-dragged');
		return;
	}

	const dragUserId = e.dataTransfer.getData('text');
	const draggedEl = document.querySelector(`[data-user-id="${dragUserId}"]`);

	if (draggedEl.parentNode === this) {
		this.classList.remove('drag-enter');
		return;
	}

	draggedEl.parentNode.removeChild(draggedEl);
	this.appendChild(draggedEl);
	this.classList.remove('drag-enter');
}

const draggable = document.querySelectorAll('[draggable]');
draggable.forEach(d => d.addEventListener('dragstart', handleDragStart));

const targets = document.querySelectorAll('[data-drop-target]');
targets.forEach(target => {
	target.addEventListener('dragover', handleOverDrop);
	target.addEventListener('drop', handleOverDrop);
	target.addEventListener('dragenter', handleDragEnterLeave);
	target.addEventListener('dragleave', handleDragEnterLeave);
});

const opslaanButton = document.getElementById('save-surprise-deelnemers');
opslaanButton.addEventListener('click', (e) => {
	const selectedUserIds = Array.prototype.map.call(
		targets[1].querySelectorAll('.drag-user'), 
		el => el.getAttribute('data-user-id'));

	fetch('controllers/set_surprise_users.php', 
		{
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ 'ids': selectedUserIds })
		})
		.then(response => location.reload())
		.catch(error => console.error(error));
});

// doe een trekking voor de actieve surprise met de geselecteerde deelnemers
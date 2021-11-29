// get all the HTML elements I need
const template = document.getElementById('wishlist-line');
const myListUL = document.getElementById('my-wishlist');
const insertForm = document.getElementById('form-insert-wish');
const updateForm = document.getElementById('form-update-wish');

createWishElementWithHTMLTemplate = (template, wish) => {
    let clone = template.content.cloneNode(true);
    const li = clone.querySelector('li');
    li.setAttribute('data-wish-id', wish.wishID);

    const i = clone.querySelector('i');
    i.addEventListener('click', fillUpdateForm);
    i.addEventListener('click', showModal);

    const span = clone.querySelectorAll('span');
    
    const wishHasAStoreURL = wish.store_url.length > 0;
    if (wishHasAStoreURL) {
        const a = createDOMElement('a', wish.description, 
            { href: wish.store_url, target: '_blank' });
        span[0].appendChild(a);
    } else {
        span[0].textContent = wish.description;
    }

    span[1].textContent = String(wish.price).replace('.', ',');
    return clone;
}

createWishElementWithJQuery = (wish) => {

    let $wishLi;
    if (wish.store_url) {     
        $wishLi = $('<li/>', { 'data-wish-id': wish.wishID })
            .append($('<i/>', { 'class': 'fas fa-pen-square' }))
            .append($('<span/>', { text:  `€${String(wish.price).replace('.', ',')} / ` }))
            .append($('<a/>', { 'href': wish.store_url, text: `${wish.description}`, 'target': '_blank' }));
    } else {
        $wishLi = $('<li/>', { text: `€${wish.price} / ${wish.description}`, 'data-wish-id': wish.wishID })
            .prepend($('<i/>', { 'class': 'fas fa-pen-square' }))
    }
    return $wishLi;
}

laadLootjeEnSpelregels = () => {
    fetch('controllers/get_lootje_en_spelregels.php')
        .then(response => response.json())
        .then(data => {
            const divLootje = document.createElement('div');
            divLootje.id = 'lootje';
            divLootje.classList.add('wishlist', 'bg-blueish');
            divLootje.innerHTML = (data.lootje != "") 
                ? `Je hebt het lootje van: <div>${data.lootje}</div>`
                : 'Hier komt je lootje te staan zodra er een trekking heeft plaatsgevonden.';

            const divSpelregels = document.createElement('div');
            divSpelregels.id = 'spelregels';
            divSpelregels.classList.add('wishlist', 'bg-yellowish');
            
            const h3 = document.createElement('h3');
            h3.textContent = 'Spelregels:';
            
            const ul = document.createElement('ul');
            ul.innerHTML = `<li>Datum: ${formatSQLDateToDutchFormat(data.surprise.datum)}</li>
                <li>Klein cadeau: &euro;${data.surprise.prijsKlein}</li>
                <li>Groot cadeau: &euro;${data.surprise.prijsGroot}</li>`;

            const p = document.createElement('p');
            p.innerText = `Gedicht(je) + groot cadeau voor de persoon op je lootje en klein cadeautje voor iedereen, inclusief de persoon op je lootje`;

            divSpelregels.append(h3, ul, p);

            const main = document.querySelector('main');
            main.append(divLootje, divSpelregels);
        })
        .catch(error => console.error(error));
}

// load wishes from DB
let wishes = {};
window.addEventListener('load', () => {

    laadLootjeEnSpelregels();

    $myListULForJQuery = $('#my-wishlist');

    postData('controllers/get_my_wishlist.php', { method: 'GET' })
        .then(data => {
            if (data.success) {
                for (let w of data.wishes) {

                    // create a new Wish object and store it
                    let wish = new Wish(w.ID, w.userID, w.beschrijving,
                        w.prijs, w.winkel, w.url);
                    wishes[wish.wishID] = wish;

                    if (browserSupportsHTMLTemplate()) {
                        myListUL.appendChild(createWishElementWithHTMLTemplate(template, wish));

                    } else {
                        // myListUL.appendChild(createWishElementWithJQuery(wish));
                        $myListULForJQuery.append(createWishElementWithJQuery(wish));
                    }

                }
            } else {
                $myListULForJQuery.append(
                    $('<li/>', { text: 'Je lijstje is nog leeg. Voeg snel dingen toe!' })
                );
            }
        })
        .catch((error) => {
            console.error(error);
        })
});

getFormData = (event) => {
    let myForm = document.getElementById(event.target.id);
    let formData = new FormData(myForm);

    // comma getallen zijn normaal in Nederland, maar werken niet fijn samen 
    // met JavaScript en MySQL
    formData.set('prijs', String(formData.get('prijs')).replace(',', '.'));
    return formData;
}


insertForm.addEventListener('submit', (event) => {
    event.preventDefault();
    let formData = getFormData(event);
    let wish = new Wish(undefined, USER_ID, 
        formData.get('cadeau'), formData.get('prijs'),
        formData.get('winkel'), formData.get('link'));
    wish.insertWishInDB();
    // location.reload();
});

// update
function fillUpdateForm() {
    let wish_id = this.parentNode.getAttribute('data-wish-id');
    let wish = wishes[wish_id];

    const formUpdate = document.getElementById('form-update-wish');
    const input = formUpdate.querySelectorAll('input');
    input[0].value = wish_id;
    input[1].value = wish.description;
    input[2].value = String(wish.price).replace('.', ',');
    input[3].value = wish.store;
    input[4].value = wish.store_url;
}

// submit
updateForm.addEventListener('submit', (event) => {
    event.preventDefault();
    let formData = getFormData(event);

    let wish = new Wish(formData.get('wish_id'), USER_ID, 
        formData.get('cadeau'), formData.get('prijs'),
        formData.get('winkel'), formData.get('link'));   

    wish
        .updateWishInDB(
            formData.get('cadeau'), formData.get('prijs'),
            formData.get('winkel'), formData.get('link')
        )
        .then(hasBeenUpdated => {
            (hasBeenUpdated) 
                ? location.reload()
                : console.log("error");
        });
});
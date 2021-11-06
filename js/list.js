// get all the HTML elements I need
const template = document.getElementById('wishlist-line');
const myListUL = document.getElementById('my-wishlist');
const insertForm = document.getElementById('form-insert-wish');
const updateForm = document.getElementById('form-update-wish');

browserSupportsHTMLTemplate = () => {
    return 'content' in document.createElement('template');
    // return false;
}

createDOMElement = (element, textContent, attributes={}) => {
    const el = document.createElement(element);
    for (const [key, value] of Object.entries(attributes)) {
        el.setAttribute(key, value);
    }
    el.textContent = textContent;
    return el;
}

createWishElementWithHTMLTemplate = (wish) => {
    let clone = template.content.cloneNode(true);
    const li = clone.querySelector('li');
    li.setAttribute('data-wish-id', wish.wishID);
    li.addEventListener('click', fillUpdateForm);
    li.addEventListener('click', showModal);

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

    // const li = createDOMElement('li', '', { 'data-wish-id': wish.wishID });
    // const i = createDOMElement('i', '', { class: 'fas fa-pen-square' });

    // const wishHasAStoreURL = wish.store_url.length > 0;
    // if (wishHasAStoreURL) {
    //     const span = createDOMElement('span', `€${String(wish.price).replace('.', ',')} / `);
    //     const a = createDOMElement('a', wish.description, 
    //         { href: wish.store_url, target: '_blank' });
    //     span.appendChild(a);
    //     li.append(i, span);
    // } else {
    //     li.prepend(i);
    // }

    // console.log(li);
    // return li;

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

// load wishes from DB
let wishes = {};
window.addEventListener('load', () => {

    $myListULForJQuery = $('#my-wishlist');

    postData('controllers/get_my_wishlist.php', { method: 'GET' })
        .then(data => {
            console.log(data);
            if (data.success) {
                for (let w of data.wishes) {

                    // create a new Wish object and store it
                    let wish = new Wish(w.wishID, w.userID, w.description,
                        w.price, w.store, w.store_url);
                    wishes[wish.wishID] = wish;

                    if (browserSupportsHTMLTemplate()) {
                        myListUL.appendChild(createWishElementWithHTMLTemplate(wish));

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
    location.reload();
});

// update
function fillUpdateForm() {
    let wish_id = this.getAttribute('data-wish-id');
    let wish = wishes[wish_id];

    const formUpdate = document.getElementById('form-update-wish');
    const input = formUpdate.querySelectorAll('input');
    input[0].value = this.getAttribute('data-wish-id');
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
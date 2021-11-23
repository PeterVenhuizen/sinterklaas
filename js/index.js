const main = document.querySelector('main');
const wishlistTemplate = document.getElementById('wishlist-template');
const wishlistItemTemplate = document.getElementById('wishlist-item-template');
const WISHES = {};

loadAllWishlistButOfTheLoggedInUser = () => {

    fetch('controllers/get_everyone_but_my_wishlist.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let wishes = data.wishes;
                createWishlists(wishes);
            } else {
                const wishlist = document.createElement('div');
                wishlist.classList.add('wishlist', 'bg-pinkish');
                
                const p = document.createElement('p');
                p.classList.add('empty-p');
                p.innerHTML = 'Nog niet niemand heeft een lijstje aangemaakt!!! &#128543;<br/><br/>Ben jij de eerste?';
                
                wishlist.appendChild(p);
                main.appendChild(wishlist);
            }
        })
        .catch(error => console.error(error));
}

createWishlists = (wishes) => {

    let index = 0;
    let username = wishes[0].username;
    let wishlist = wishlistTemplate.content.cloneNode(true);

    const h2 = wishlist.querySelector('h2');
    h2.textContent = wishes[0].username;

    const wishlistUL = wishlist.querySelector('ul');

    let repeatWhileWishesLeftForThisUser;
    do {
        saveWishInGlobalWishes(wishes[index]);
        wishlistUL.appendChild(createWishlistItem(wishes[index]));
        index++;
        repeatWhileWishesLeftForThisUser = wishes[index] !== undefined 
            && username === wishes[index].username;
    } while (repeatWhileWishesLeftForThisUser);

    if (index < wishes.length) {
        createWishlists(wishes.slice(index));
    }

    appendWishlistAndStyleIt(wishlist);

}

saveWishInGlobalWishes = (item) => {
    WISHES[item.ID] = new Wish(item.ID, item.userID,
        item.beschrijving, item.prijs, item.winkel, item.url);
}

createWishlistItem = (item) => {

    let wishlistItem = wishlistItemTemplate.content.cloneNode(true);
    const li = wishlistItem.querySelector('li');
    li.setAttribute('data-wish-id', item.ID);

    const i = wishlistItem.querySelector('i');
    i.classList.add(item.isGekocht === 1 ? 'fa-check-square' : 'fa-square');

    let itemHasBeenBought = item.isGekocht === 1;
    if (itemHasBeenBought) {
        li.classList.add('bought');
        i.classList.add('fa-check-square');
    } else {
        i.classList.add('fa-square');
        i.addEventListener('click', showConfirmationModal);
    }

    const span = wishlistItem.querySelectorAll('span');
    const wishHasAStoreURL = item.url !== null;
    if (wishHasAStoreURL) {
        const a = createDOMElement('a', item.beschrijving, 
            { href: item.url, target: '_blank' });
        span[0].appendChild(a);
    } else {
        span[0].textContent = item.beschrijving;
    }

    span[1].textContent = String(item.prijs).replace('.', ',');

    return wishlistItem;
}

appendWishlistAndStyleIt = (wishlist) => {
    main.appendChild(wishlist);
    styleWishlist();
}

styleWishlist = () => {
    const wishlistEl = document.querySelector('.wishlist:last-of-type');
    addRandomWishlistStyleAndColor(wishlistEl);
    putTapeInTheMiddle(wishlistEl);
    rotateTapeRandomly(wishlistEl);
}

addRandomWishlistStyleAndColor = (wishlistEl) => {
    let paperClasses = ['note-paper', 'holed-paper', 'squared-paper'];
    let bgColorClasses = ['bg-blueish', 'bg-greenish', 'bg-yellowish', 'bg-pinkish', 'bg-offwhite'];

    wishlistEl.classList.add(paperClasses[randomIntFromInterval(0, paperClasses.length - 1)]);
    wishlistEl.classList.add(bgColorClasses[randomIntFromInterval(0, bgColorClasses.length - 1)]);
}

putTapeInTheMiddle = (wishlistEl) => {
    const topTape = wishlistEl.querySelector('.top-tape');
    topTape.style.left = (wishlistEl.offsetWidth - topTape.offsetWidth) / 2;
}

rotateTapeRandomly = (wishlistEl) => {
    const topTape = wishlistEl.querySelector('.top-tape');
    const randomRotation = randomIntFromInterval(-3, 3);
    topTape.style.transform = `rotate(${randomRotation}deg)`;
}


/* Wish buying confirmation/cancelation */
const btnBevestig = document.querySelector('.btn-bevestig');
const btnAnnuleer = document.querySelector('.btn-annuleer');

// attach wishID and show modal
showConfirmationModal = (event) => {
    let wish_id = event.target.parentElement.getAttribute('data-wish-id');
    btnBevestig.setAttribute('data-wish-id', wish_id);
    showModal();
}

// buy confirmation event
buyPresent = (event) => {
    event.preventDefault();
    let wish_id = event.target.getAttribute('data-wish-id');
    WISHES[wish_id].setWishAsBoughtInDB()
        .then(hasBeenBought => {
            if (hasBeenBought) {
                location.reload();
            }
        }) 
        .catch(error => console.error(error));
}
btnBevestig.addEventListener('click', buyPresent);

// close modal
btnAnnuleer.addEventListener('click', (event) => {
    event.preventDefault();
    hideModal();
})

/* Load all wishlists not owned by the logged-in user */
window.addEventListener('load', loadAllWishlistButOfTheLoggedInUser);
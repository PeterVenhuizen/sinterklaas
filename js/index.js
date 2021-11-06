const main = document.querySelector('main');
const wishlistTemplate = document.getElementById('wishlist-template');
const wishlistItemTemplate = document.getElementById('wishlist-item-template');
const WISHES = {};

loadAllWishlistButOfTheLoggedInUser = () => {

    fetch('controllers/get_everyone_but_my_wishlist.php')
        .then(response => response.json())
        .then(data => {
            let wishes = data.wishes;
            createWishlists(wishes);
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
    WISHES[item.wishID] = new Wish(item.wishID, item.userID,
        item.description, item.price, item.store, item.store_url);
}

createWishlistItem = (item) => {

    let wishlistItem = wishlistItemTemplate.content.cloneNode(true);
    const li = wishlistItem.querySelector('li');
    li.setAttribute('data-wish-id', item.wishID);

    const i = wishlistItem.querySelector('i');
    i.classList.add(item.bought === 1 ? 'fa-check-square' : 'fa-square');

    let itemHasBeenBought = item.bought === 1;
    if (itemHasBeenBought) {
        i.classList.add('fa-check-square');
    } else {
        i.classList.add('fa-square');
        i.addEventListener('click', buyPresent);
    }

    const span = wishlistItem.querySelectorAll('span');
    const wishHasAStoreURL = item.store_url.length > 0;
    if (wishHasAStoreURL) {
        const a = createDOMElement('a', item.description, 
            { href: item.store_url, target: '_blank' });
        span[0].appendChild(a);
    } else {
        span[0].textContent = item.description;
    }

    span[1].textContent = String(item.price).replace('.', ',');

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

buyPresent = (event) => {
    console.log(event.target);
    console.log(event.target.parentElement.getAttribute('data-wish-id'));
    let wish_id = event.target.parentElement.getAttribute('data-wish-id');
    WISHES[wish_id].setWishAsBoughtInDB()
        .then(hasBeenBought => {
            if (hasBeenBought) {
                location.reload();
            }
        }) 
        .catch(error => console.error(error));
}

window.addEventListener('load', loadAllWishlistButOfTheLoggedInUser);
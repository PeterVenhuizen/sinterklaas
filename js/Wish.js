class Wish {
    #wishID;
    #userID;
    #description;
    #price;
    #store;
    #store_url;
    #bought;

    constructor(wishID, userID, description, price, store="", store_url="", bought=false) {
        this.#userID = parseInt(userID);
        this.#description = description;
        this.#price = parseFloat(price);
        this.#store = store;
        this.#store_url = store_url;
        this.#bought = bought;
        // this.#wishID = Number.isFinite(wishID) ? wishID : this.#insertWishInDB();
        this.#wishID = wishID;
    }

    /* Insert in DB and get the wish identifier */
    async insertWishInDB() {
        postData("controllers/wish_insert.php", {
            userID: this.#userID,
            description: this.#description,
            price: this.#price,
            store: this.#store,
            store_url: this.#store_url
        })
        .then(data => {
            console.log(data);
            this.#wishID = data.id;
        });
    }

    /* All getter methods */
    get wishID() { return this.#wishID; }
    get userID() { return this.#userID; }
    get description() { return this.#description; }
    get price() { return this.#price; }
    get store() { return this.#store; }
    get store_url() { return this.#store_url; }
    get hasBeenBought() { return this.#bought; }

    /* Set a present as bought in DB */
    async setWishAsBoughtInDB() {
        return postData("controllers/wish_set_bought.php", { wishID: this.#wishID })
            .then(hasBeenBought => hasBeenBought);
    }

    /* Update Wish data in DB and return if update query succeeded */
    async updateWishInDB(description, price, store, store_url) {

        return postData("controllers/wish_update.php", { 
            wishID: this.#wishID,
            description: description,
            price: price,
            store: store,
            store_url: store_url
        })
        .then(hasBeenUpdated => hasBeenUpdated);
    }
}
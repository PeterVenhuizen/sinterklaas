class Wishlist {
    #userID;
    #wishes;

    constructor(userID) {
        this.#userID = userID;
        this.#wishes = {};
    }

    addWish(wish) {
        this.#wishes[wish.wishID] = wish;
    }

    getWish(wishID) {
        return this.#wishes[wishID];
    }

    /* Add a follower of this list */
    async addFollower(followerID) {
        return postData("controllers/follower_insert.php", {
            userID: this.#userID,
            followerID: followerID
        })
        .then(hasBeenAdded => hasBeenAdded);
    }

    /* Remove a follower of this list */
    async removeFollower(followerID) {
        return postData("controllers/follower_delete.php", {
            userID: this.#userID,
            followerID: followerID
        })
        .then(hasBeenRemoved => hasBeenRemoved);
    }
    
}
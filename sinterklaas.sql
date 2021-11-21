CREATE TABLE surprise (
    ID INTEGER NOT NULL AUTO_INCREMENT,
    datum DATE NOT NULL,
    prijsKlein FLOAT NOT NULL DEFAULT 12.50,
        CONSTRAINT prijsKleinGroterDanNul CHECK (prijsKlein > 0),
    prijsGroot FLOAT NOT NULL DEFAULT 25,
        CONSTRAINT prijsGrootGroterDanNul CHECK (prijsGroot > 0),
    isActief BOOLEAN DEFAULT 1,
        CONSTRAINT enkelEenSurpriseIsActief UNIQUE (isActief),
    isGesloten BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY(ID)
);

BEGIN TRANSACTION;
UPDATE surprise SET isActief = NULL WHERE isActief;
UPDATE surprise SET isActief = TRUE WHERE ID = ?;
COMMIT;

CREATE TABLE surprise_to_user (
    surpriseID INTEGER NOT NULL,
    userID INTEGER NOT NULL,
    PRIMARY KEY (surpriseID, userID),
    FOREIGN KEY (surpriseID) REFERENCES surprise(ID),
    FOREIGN KEY (userID) REFERENCES users(id)
);

CREATE TABLE surprise_lootjes (
    surpriseID INTEGER NOT NULL,
    userID INTEGER NOT NULL,
    getrokkenID INTEGER NOT NULL,
    PRIMARY KEY (surpriseID, userID, getrokkenID),
    FOREIGN KEY (surpriseID) REFERENCES surprise(ID),
    FOREIGN KEY (userID) REFERENCES surprise_to_user(userID),
    FOREIGN KEY (getrokkenID) REFERENCES surprise_to_user(userID)
);
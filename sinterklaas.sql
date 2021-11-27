CREATE TABLE lijstje (
    ID INTEGER NOT NULL AUTO_INCREMENT,
    userID INTEGER NOT NULL,
    surpriseID INTEGER NOT NULL,
    beschrijving VARCHAR(255) NOT NULL,
    prijs FLOAT NOT NULL,
    winkel VARCHAR(255) DEFAULT NULL,
    url TEXT DEFAULT NULL,
    isGekocht BOOLEAN DEFAULT 0,
    PRIMARY KEY (ID),
    FOREIGN KEY (userID) REFERENCES users(id),
    FOREIGN KEY (surpriseID) REFERENCES surprise(ID)
);

INSERT INTO lijstje (userID, surpriseID, beschrijving, prijs)
    VALUES (?, (SELECT ID FROM surprise WHERE isActief), ?, ?);

SELECT lijstje.*, (SELECT username FROM users WHERE users.id = lijstje.userID) AS naam 
FROM lijstje
INNER JOIN (
    SELECT ID FROM surprise
    WHERE isActief
) surprise on surprise.ID = lijstje.surpriseID
WHERE userID != ?

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
    getrokkenID INTEGER DEFAULT NULL,
    PRIMARY KEY (surpriseID, userID),
    FOREIGN KEY (surpriseID) REFERENCES surprise(ID),
    FOREIGN KEY (userID) REFERENCES users(id),
    FOREIGN KEY (getrokkenID) REFERENCES users(id),
    CONSTRAINT eenDeelnemerKanNietHunEigenLootjeHebben CHECK (userID != getrokkenID)
);

SELECT id, username FROM users WHERE privileges >= 1;
SELECT userID FROM surprise_to_user 
WHERE surpriseID = (SELECT ID FROM surprise WHERE isActief);

SELECT 
    (SELECT username FROM users WHERE users.id = surprise_to_user.userID) AS username,
    (SELECT username FROM users WHERE users.id = surprise_to_user.getrokkenID) AS lootje
FROM surprise_to_user
INNER JOIN (
    SELECT surprise.ID FROM surprise
    WHERE isActief
) surprise ON surprise.ID = surprise_to_user.surpriseID
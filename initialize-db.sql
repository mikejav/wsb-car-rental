CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(124),
    password VARCHAR(256),
    firstName VARCHAR(124),
    lastName VARCHAR(124)
);

INSERT INTO users VALUES (null, 'test@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Jan', 'Kowalski'); -- haslo: test

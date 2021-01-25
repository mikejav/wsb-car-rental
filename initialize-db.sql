CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(124),
    password VARCHAR(256),
    firstName VARCHAR(124),
    lastName VARCHAR(124)
);

INSERT INTO users VALUES (null, 'test@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Jan', 'Kowalski'); -- haslo: test

CREATE TABLE vehicles (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    manufacturer VARCHAR(124),
    model VARCHAR(124),
    describtion VARCHAR(124),
    production_date DATE,
    first_registration_date DATE,
    color VARCHAR(124),
    doors_count INT,
    engine_displacement DOUBLE,
    fuel_type VARCHAR(32)
);

INSERT INTO vehicles VALUES (null, 'Audi', 'A3', 'Test1', NOW(), NOw(), 'BLACK', 3, 1.9, 'DIESEL');
INSERT INTO vehicles VALUES (null, 'Lexus', 'LS', 'Test2', NOW(), NOw(), 'BLACK', 5, 3, 'PETROL');
INSERT INTO vehicles VALUES (null, 'Toyota', 'Yaris', 'Test3', NOW(), NOw(), 'RED', 3, 1.6, 'PETROL');
INSERT INTO vehicles VALUES (null, 'Toyota', 'Prius', 'Test4', NOW(), NOw(), 'SILVER', 5, 1.5, 'HYBRID');
INSERT INTO vehicles VALUES (null, 'Fiat', '500', 'Test5', NOW(), NOw(), 'WHITE', 3, 1.4, 'PETROL');

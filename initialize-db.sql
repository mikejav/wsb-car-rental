CREATE TABLE systemUsers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(124),
    password VARCHAR(256),
    firstName VARCHAR(124),
    lastName VARCHAR(124)
);

INSERT INTO systemUsers VALUES (null, 'test@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Jan', 'Kowalski'); -- haslo: test

CREATE TABLE vehicles (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    manufacturer VARCHAR(124),
    model VARCHAR(124),
    segment VARCHAR(64),
    describtion VARCHAR(124),
    production_date DATE,
    first_registration_date DATE,
    color VARCHAR(124),
    doors_count INT,
    engine_displacement DOUBLE,
    fuel_type VARCHAR(32)
);

INSERT INTO vehicles VALUES (null, 'Audi', 'A3', 'A', 'Test1', NOW(), NOw(), 'BLACK', 3, 1.9, 'DIESEL');
INSERT INTO vehicles VALUES (null, 'Lexus', 'LS', 'B', 'Test2', NOW(), NOw(), 'BLACK', 5, 3, 'PETROL');
INSERT INTO vehicles VALUES (null, 'Toyota', 'Yaris', 'D', 'Test3', NOW(), NOw(), 'RED', 3, 1.6, 'PETROL');
INSERT INTO vehicles VALUES (null, 'Toyota', 'Prius', 'A', 'Test4', NOW(), NOw(), 'SILVER', 5, 1.5, 'HYBRID');
INSERT INTO vehicles VALUES (null, 'Fiat', '500', 'A', 'Test5', NOW(), NOw(), 'WHITE', 3, 1.4, 'PETROL');

CREATE TABLE customers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(124),
    password VARCHAR(256),
    firstName VARCHAR(124),
    lastName VARCHAR(124),
    type VARCHAR(32),
    address1 VARCHAR(124),
    address2 VARCHAR(124),
    city VARCHAR(124),
    postcode VARCHAR(16),
    createdAt DATETIME
);

INSERT INTO customers VALUES (null, 'customer1@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Edgar', 'V. Humphreys', 'B2C', '4041 Simpson Square', '', 'Duke', '73532', NOW());
INSERT INTO customers VALUES (null, 'customer2@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Amanda', 'C. Moore', 'B2B', '3795 Jarvisville Road', '', 'Jersey City', '07307', NOW());
INSERT INTO customers VALUES (null, 'customer3@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Lee', 'Hansley', 'B2C', '1513 Conference Center Way', '', 'Great Falls', '22066', NOW());
INSERT INTO customers VALUES (null, 'customer4@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Robert', 'J. Hendricks', 'B2C', '1601 Kerry Way', '', 'Los Angeles', '90017', NOW());
INSERT INTO customers VALUES (null, 'customer5@example.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Debra', 'C. Long', 'B2B', '3157 Pike Street', '', 'San Diego', '92126', NOW());

CREATE TABLE rentals (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fromDate DATE,
    toDate DATE,
    customerId INT,
    vehicleId INT
);

INSERT INTO rentals VALUES (null, now(), now(), 1, 2);
INSERT INTO rentals VALUES (null, now(), now(), 3, 4);
INSERT INTO rentals VALUES (null, now(), now(), 4, 1);

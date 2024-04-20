DROP TABLE IF EXISTS Pets;
DROP TABLE IF EXISTS Owners;


CREATE TABLE Owners (
    owner_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(255),
    address VARCHAR(255),
    password VARCHAR(255),
    deleted INT,
    created datetime,
    updated datetime
);

CREATE TABLE Pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT,
    name VARCHAR(255),
    species VARCHAR(255),
    breed VARCHAR(255),
    age INT,
    medical_history TEXT,
    picture VARCHAR(255),
    FOREIGN KEY (owner_id) REFERENCES Owners(owner_id),
    deleted INT,
    created datetime,
    updated datetime
);

CREATE TABLE Services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    deleted INT,
    created datetime,
    updated datetime,
    promo_code VARCHAR(50),
    promo_amt DECIMAL(10, 2)
);

CREATE TABLE Appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT,
    date DATE,
    time TIME,
    service_id INT,
    status VARCHAR(255) DEFAULT 'Scheduled',
    FOREIGN KEY (pet_id) REFERENCES Pets(pet_id),
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
);

CREATE TABLE AppointmentRating (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    rating INT,
    comment TEXT,
    clinic_comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES Appointments(appointment_id)
    ON DELETE CASCADE
);


CREATE TABLE Staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(255),
    photo_url VARCHAR(255),
    qualifications TEXT,
    specialization TEXT
);

CREATE TABLE ClinicInfo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address TEXT,
    phone VARCHAR(255),
    email VARCHAR(255),
    hours TEXT
);

INSERT INTO ClinicInfo (address, phone, email, hours)
VALUES ('1234 Pet Street, PetTown, PT 12345', '555-1234', 'contact@petclinic.com', 'Mon-Fri: 9 AM - 5 PM, Sat: 9 AM - 12 PM');


INSERT INTO Staff (name, email, password, role, photo_url, qualifications, specialization)
VALUES
('John Doe', 'clinicadmin@test.com', '$2y$10$ICu1R6G3fazOG/bYulAeQOhCaOl8eIxgvvZDAuSpMIC/O4Ou17n4a', 'clinicadmin', 'images/johndoe.jpg',  'MSc in Veterinary Medicine', 'Veterinary Surgeon'),
('Jane Smith', 'staff@test.com', '$2y$10$ICu1R6G3fazOG/bYulAeQOhCaOl8eIxgvvZDAuSpMIC/O4Ou17n4a', 'staff', 'images/janesmith.jpg', 'PhD in Veterinary Pharmacology', 'Pharmacologist');


INSERT INTO Owners (name, email, phone, address, password, deleted, created, updated)
VALUES ('John Doe', 'john.doe@example.com', '555-1234', '1234 Maple Street', '$2y$10$4UoC5/1zJi2n97lVn1nNcOQdP7ZELzO0HO4YRvkXmQgFv0sN6F.u2', 


INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('General Consultation', 'A routine check-up to assess a pet''s overall health and to address any minor concerns.', 50.00, 0, NOW(), NOW());

INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Vaccinations', 'Essential vaccinations to protect pets from various diseases. Includes Rabies, DHPP, Bordetella, and others.', 20.00, 0, NOW(), NOW());

-- Inserting Microchipping
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Microchipping', 'A microchip is implanted under the pet''s skin for identification purposes.', 45.00, 0, NOW(), NOW());

-- Inserting Spaying (Female)
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Spaying', 'Surgical procedure to prevent female pets from reproducing, contributing to population control and offering health benefits.', 200.00, 0, NOW(), NOW());

-- Inserting Neutering (Male)
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Neutering', 'Surgical procedure to prevent male pets from reproducing, contributing to population control and offering health benefits.', 150.00, 0, NOW(), NOW());

-- Inserting Dental Cleaning
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Dental Cleaning', 'Professional cleaning of a pet''s teeth to prevent dental diseases and maintain overall health.', 80.00, 0, NOW(), NOW());

-- Inserting Emergency Services
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Emergency Services', 'Immediate care for pets in critical condition or experiencing severe health issues.', 100.00, 0, NOW(), NOW());

-- Inserting Basic Grooming Services
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Basic Grooming', 'Includes bathing, haircuts, nail trimming, and ear cleaning to keep pets clean and comfortable.', 60.00, 0, NOW(), NOW());

-- Inserting Deluxe Grooming Services
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Deluxe Grooming', 'Deluxe grooming package includes additional services like dematting and teeth brushing.', 90.00, 0, NOW(), NOW());

-- Inserting Behavioral Training
INSERT INTO SERVICES (name, description, price, deleted, created, updated) 
VALUES ('Behavioral Training', 'Training sessions to address behavioral issues and promote positive behaviors in pets.', 75.00, 0, NOW(), NOW());

INSERT INTO Pets (owner_id, name, species, breed, age, medical_history, picture, deleted, created, updated)
VALUES
(1, 'Buddy', 'Dog', 'Golden Retriever', 3, 'No known allergies.', 'path/to/image1.jpg', 0, NOW(), NOW()),
(1, 'Charlie', 'Dog', 'Labrador', 5, 'Needs regular medication for arthritis.', 'path/to/image2.jpg', 0, NOW(), NOW())

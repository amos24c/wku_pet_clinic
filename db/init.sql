

CREATE TABLE Owners (
    owner_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(255),
    address VARCHAR(255),
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
    updated datetime
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



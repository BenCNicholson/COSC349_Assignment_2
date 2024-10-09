-- Create the database
CREATE DATABASE IF NOT EXISTS roomDB;

-- Use the database
USE roomDB;

-- Create the Room table
CREATE TABLE Room (
    roomID INT AUTO_INCREMENT,
    roomNumber INT NOT NULL,
    roomDesc VARCHAR(100) NOT NULL,
    number_rooms INT NOT NULL,
    costPerNight DECIMAL(19,4) NOT NULL,
    isBooked BOOLEAN NOT NULL,
    PRIMARY KEY (roomID)
);

-- Create the Client table
CREATE TABLE Client (
    email VARCHAR(80),
    first_name VARCHAR(40) NOT NULL,
    last_name VARCHAR(40) NOT NULL,
    _password VARCHAR(255) NOT NULL,
    PRIMARY KEY (email),
    CHECK (email LIKE '%@%')
);

-- Create the Booking table
CREATE TABLE Booking (
    email VARCHAR(80),
    roomID INT,  -- Fixed syntax here
    cost DECIMAL(19,4) NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    roomNumber INT NOT NULL,
    roomDesc VARCHAR(100) NOT NULL,
    FOREIGN KEY (email) REFERENCES Client(email),
    FOREIGN KEY (roomID) REFERENCES Room(roomID),
    PRIMARY KEY (email, roomID)
);

-- Create the Admin_ table
CREATE TABLE Admin_ (
    email VARCHAR(80),
    _password VARCHAR(255) NOT NULL,
    FOREIGN KEY (email) REFERENCES Client(email),
    PRIMARY KEY (email)  -- Removed extra comma
);

-- Insert data into the Room table
INSERT INTO Room (roomNumber, roomDesc, number_rooms, costPerNight, isBooked) VALUES 
(10, 'The sea suite', 3, 95.00, FALSE),
(15, 'The X suite', 2, 140.00, FALSE),
(11, 'The Y suite', 1, 100.00, FALSE),
(12, 'The Gamma suite', 3, 200.00, FALSE);

-- Insert data into the Client table
INSERT INTO Client (email, first_name, last_name, _password) VALUES 
('john@example.com', 'John', 'Smith', 'root'),
('admin@example.com', 'Admin', 'admin', 'root');

-- Insert data into the Admin_ table
INSERT INTO Admin_ (email, _password) VALUES 
('admin@example.com', 'root');

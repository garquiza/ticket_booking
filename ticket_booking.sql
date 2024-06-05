CREATE DATABASE IF NOT EXISTS ticket_booking;

USE ticket_booking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    role ENUM('admin-developer', 'admin-client', 'user') NOT NULL
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_feature TINYINT(1) DEFAULT 0,
    cinema_feature TINYINT(1) DEFAULT 0,
    site_name VARCHAR(255) NOT NULL,
    h1_text VARCHAR(255) NOT NULL,
    p_text TEXT NOT NULL
);

INSERT INTO users (username, password, role) VALUES ('devadmin', 'password', 'admin-developer');
INSERT INTO users (username, password, role) VALUES ('clientadmin', 'password', 'admin-client');
INSERT INTO settings (id) VALUES (1);


CREATE TABLE busbooking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_type VARCHAR(20) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    departure_date DATE NOT NULL,
    return_date DATE,
    departure_time TIME NOT NULL,
    return_time TIME,
    passenger_quantity INT NOT NULL,
    selected_seats VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE moviebooking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    select_movie VARCHAR(255) NOT NULL,
    movie_date DATE NOT NULL,
    movie_time TIME NOT NULL,
    ticket_quantity INT NOT NULL,
    seats VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL
);

CREATE TABLE manage_movie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(255) NOT NULL,
    movie_time TIME NOT NULL
);


CREATE TABLE manage_bus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(100) NOT NULL,
    location_type ENUM('round_trip', 'one_way') NOT NULL,
    bus_number VARCHAR(255) NOT NULL,
    bus_driver VARCHAR(255) NOT NULL;
);

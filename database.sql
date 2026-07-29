CREATE DATABASE IF NOT EXISTS namaa_campus_events
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE namaa_campus_events;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(150) NOT NULL,
    short_description VARCHAR(300) NOT NULL,
    full_description TEXT NOT NULL,
    image VARCHAR(180) NOT NULL,
    available_seats INT NOT NULL DEFAULT 0,
    organizer VARCHAR(150) NOT NULL,
    registration_deadline DATE NOT NULL,
    intended_audience VARCHAR(180) NOT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    college VARCHAR(100) NOT NULL,
    academic_level VARCHAR(40) NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_namaa_registration_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

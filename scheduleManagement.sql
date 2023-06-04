CREATE DATABASE schedule_management;
USE schedule_management;

CREATE TABLE member (
    username VARCHAR(100) PRIMARY KEY,
    password VARCHAR(640) NOT NULL
);

CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    start DATETIME,
    finish DATETIME,
    contents VARCHAR(150),
    place VARCHAR(150),
    FOREIGN KEY (username) REFERENCES member(username)
);


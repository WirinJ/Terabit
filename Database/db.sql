CREATE DATABASE Terabit;

CREATE TABLE comments (
    cid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uid varchar(128) NOT NULL,
    date datetime NOT NULL,
    message TEXT NOT NULL,
    post_id int(11) NOT NULL,
    reply int(11) NULL,
    likes int(11) NOT NULL
);

CREATE TABLE likes (  
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
    user varchar(255) NOT NULL,  
    comid int(11) NOT NULL, 
    type varchar(10) NOT NULL
);

CREATE TABLE gebruikers (
    userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Naam varchar(255) NOT NULL,
    Achternaam varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    username varchar(255) NOT NULL,
    wachtwoord varchar(50) NOT NULL,
    credits int(255) NOT NULL DEFAULT '1',
    Bio varchar(1000),
    Skills varchar(1000),
    hash varchar(100) NOT NULL,
    active INT(1) NOT NULL DEFAULT '0'
);

CREATE TABLE projecten (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Titel varchar(755) NOT NULL,
    Afbeelding varchar(255) NOT NULL,
    Beschrijving varchar(3000) NOT NULL, 
    date datetime NOT NULL,
    Source varchar(255),
    User varchar(255) NOT NULL,
    Afbeeldingen varchar(500) NOT NULL,
    likes int(11) NOT NULL,
    Milestones TEXT NULL
);
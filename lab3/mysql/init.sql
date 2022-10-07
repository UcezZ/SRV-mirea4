CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT,DELETE ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;

CREATE TABLE IF NOT EXISTS user (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    login varchar(32) not null,
    pwdcrc INT(11) UNSIGNED not null,
    PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS book (
    ID INT NOT NULL AUTO_INCREMENT,
    author varchar(64),
    name varchar(64),
    url varchar(255),
    PRIMARY KEY (ID)
);
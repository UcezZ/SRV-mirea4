CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user' @'%' IDENTIFIED BY 'password';
GRANT SELECT,
    UPDATE,
    INSERT,
    DELETE ON appDB.* TO 'user' @'%';
FLUSH PRIVILEGES;
USE appDB;
CREATE TABLE IF NOT EXISTS user (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    login varchar(32) NOT NULL,
    pwdcrc INT(11) UNSIGNED NOT NULL,
    locale VARCHAR(2) NOT NULL DEFAULT 'en',
    theme VARCHAR(8) NOT NULL DEFAULT 'dark',
    PRIMARY KEY (ID)
);
INSERT INTO user (ID, login, pwdcrc) (
        SELECT 1,
            'admin',
            2647319041
        WHERE NOT EXISTS (
                SELECT *
                FROM user
                WHERE ID = 1
                LIMIT 1
            )
    );
CREATE TABLE IF NOT EXISTS token (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    ID_user INT(11) NOT NULL,
    value varchar(32) NOT NULL,
    expires DATETIME NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_token_ID_user FOREIGN KEY (ID_user) REFERENCES user(ID) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS pdf (
    ID INT NOT NULL AUTO_INCREMENT,
    ID_user INT(11) NOT NULL,
    name varchar(128),
    size INT(10) UNSIGNED NOT NULL,
    alias VARCHAR(8) NOT NULL,
    PRIMARY KEY (ID),
    CONSTRAINT FK_pdf_ID_user FOREIGN KEY (ID_user) REFERENCES user(ID) ON UPDATE CASCADE ON DELETE CASCADE
);
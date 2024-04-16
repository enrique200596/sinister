CREATE DATABASE sinister CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE sinister;
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    birthdate DATETIME NOT NULL,
    email VARCHAR(128) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    accessKey VARCHAR(32),
    created_at DATETIME DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = INNODB;
INSERT INTO users (email, password, accessKey)
VALUES('luis@mail.com', '123456', 'Administrator');
INSERT INTO users (email, password, accessKey)
VALUES('jose@mail.com', '123456', 'Executive');
INSERT INTO users (email, password, accessKey)
VALUES('daniel@mail.com', '123456', 'Operator');
CREATE DATABASE IF NOT EXISTS brocolis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE brocolis;

CREATE TABLE users (
    id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    email      VARCHAR(255)   NOT NULL,
    password   VARCHAR(255)   NOT NULL,
    username   VARCHAR(100)   NOT NULL,
    created_at DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE sessions (
    id         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED   NOT NULL,
    token      VARCHAR(64)    NOT NULL,
    created_at DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME       NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_token (token),
    CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

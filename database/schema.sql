CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED          NOT NULL AUTO_INCREMENT,
    email      VARCHAR(255)          NOT NULL,
    password   VARCHAR(255)          NOT NULL,
    username   VARCHAR(100)          NOT NULL,
    role       ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sessions (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED NOT NULL,
    token      VARCHAR(64)  NOT NULL,
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_token (token),
    CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS files (
    fileId     INT          NOT NULL AUTO_INCREMENT,
    name       VARCHAR(255) NOT NULL,
    extension  VARCHAR(10),
    size       INT          NOT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (fileId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

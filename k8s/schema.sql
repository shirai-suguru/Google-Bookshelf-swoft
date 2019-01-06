CREATE DATABASE `bookshelf`;

use bookshelf;

CREATE TABLE IF NOT EXISTS books (
    `id`            INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `title`         VARCHAR(255),
    `author`        VARCHAR(255),
    `published_date`    VARCHAR(255),
    `image_url`     VARCHAR(255),
    `description`   VARCHAR(255),
    `created_by`    VARCHAR(255),
    `created_by_id` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
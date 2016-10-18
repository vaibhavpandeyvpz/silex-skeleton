CREATE TABLE IF NOT EXISTS `users`
(
  `id` BIGINT UNSIGNED AUTO_INCREMENT,
  `name` VARCHAR (128) NULL,
  `email` VARCHAR (128) NOT NULL,
  `password` VARCHAR (128) NOT NULL,
  `roles` VARCHAR (255) NOT NULL DEFAULT 'ROLE_USER',
  `salt` VARCHAR (16) NOT NULL,
  `is_confirmed` BOOLEAN NOT NULL DEFAULT FALSE,
  `is_enabled` BOOLEAN NOT NULL DEFAULT TRUE,
  `is_locked` BOOLEAN NOT NULL DEFAULT FALSE,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`email`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `email_confirmation_tokens`
(
  `id` BIGINT UNSIGNED AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `token` VARCHAR (64) NOT NULL,
  `email_hash` VARCHAR (32) NOT NULL,
  `is_consumed` BOOLEAN NOT NULL DEFAULT FALSE,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`token`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `login_history`
(
  `id` BIGINT UNSIGNED AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `browser` VARCHAR (64) NOT NULL,
  `os` VARCHAR (64) NOT NULL,
  `device` VARCHAR (64) NOT NULL,
  `ip_address` VARCHAR (24) NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `password_reset_tokens`
(
  `id` BIGINT UNSIGNED AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `token` VARCHAR (64) NOT NULL,
  `is_consumed` BOOLEAN NOT NULL DEFAULT FALSE,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`token`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;
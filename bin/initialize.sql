SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
	                     `id` varchar(36) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `name` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `module` varchar(40) COLLATE utf8mb4_czech_ci DEFAULT NULL,
	                     `title` varchar(60) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `description` varchar(160) COLLATE utf8mb4_czech_ci DEFAULT NULL,
	                     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


DROP TABLE IF EXISTS `user_auth_tokens`;
CREATE TABLE `user_auth_tokens` (
	                                `id` varchar(36) COLLATE utf8mb4_czech_ci NOT NULL,
	                                `user_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
	                                `token_value` varchar(20) COLLATE utf8mb4_czech_ci NOT NULL,
	                                `remote_address` varchar(60) COLLATE utf8mb4_czech_ci NOT NULL,
	                                `user_agent` text COLLATE utf8mb4_czech_ci NOT NULL,
	                                `created_at` datetime NOT NULL,
	                                `updated_at` datetime DEFAULT NULL,
	                                PRIMARY KEY (`id`),
	                                KEY `user_id` (`user_id`),
	                                CONSTRAINT `user_auth_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	                     `id` varchar(36) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `username` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `password` varchar(60) COLLATE utf8mb4_czech_ci NOT NULL,
	                     `created_at` datetime NOT NULL,
	                     `updated_at` datetime DEFAULT NULL,
	                     `deleted_at` datetime DEFAULT NULL,
	                     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
	('a5daf9fb-ee9e-11ef-ab78-525400f7d77d',	'demo',	'$2y$10$lUbI0NMIJY/F2QcTS/l6vudS69KmKO9HOGVYrmlaZn9lZOqB55FHi',	NOW(),	NULL,	NULL);

DROP TABLE IF EXISTS `users_x_roles`;
CREATE TABLE `users_x_roles` (
	                             `id` int unsigned NOT NULL AUTO_INCREMENT,
	                             `user_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
	                             `role_id` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
	                             PRIMARY KEY (`id`),
	                             KEY `user_id` (`user_id`),
	                             KEY `role_id` (`role_id`),
	                             CONSTRAINT `users_x_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
	                             CONSTRAINT `users_x_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

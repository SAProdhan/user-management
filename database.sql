CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO users VALUES ('1', 'sakeef', 'saprodhan.sa@gmail.com', '1', '$2y$10$MT/nXNj0gW.xtUUgXaUmRuI17t.f9PAgbTtc5QWw7rW32nDeFRH1S', '2024-04-27 07:20:25', '2024-04-27 07:20:25');

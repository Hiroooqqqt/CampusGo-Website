

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` enum('available','occupied') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `rooms` (`id`, `name`, `status`) VALUES
(1, 'Room 1', 'occupied'),
(2, 'Room 2', 'available'),
(3, 'Room 3', 'occupied'),
(4, 'Room 4', 'occupied'),
(5, 'Alvarado 102', 'available'),
(6, 'Room 6', 'available'),
(7, 'Science Laboratory', 'available'),
(8, 'NB1A', 'occupied'),
(9, 'NB1B', 'available'),
(10, 'Computer Laboratory 1', 'available'),
(11, 'Computer Laboratory 2', 'occupied'),
(12, 'CPE Laboratory 3', 'available'),
(13, 'Audio Visual Room 4', 'occupied'),
(14, 'Drawing Room', 'available'),
(15, 'Room 205A', 'available'),
(16, 'Food Laboratory', 'occupied'),
(17, 'NB2A', 'occupied'),
(18, 'NB2B', 'occupied'),
(19, 'Campus Library', 'occupied');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `profile_image` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;


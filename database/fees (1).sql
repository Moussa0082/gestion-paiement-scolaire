-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 15 sep. 2023 à 18:26
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fees`
--

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `level` varchar(150) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`id`, `course`, `description`, `level`, `total_amount`, `date_created`) VALUES
(1, 'Course 2', 'Sample III VVVV', '2023-2024', 4500, '2020-10-31 11:01:15'),
(2, 'IG', 'Informatique de gestion (IG)', '2023-2024', 30000, '2022-08-25 18:17:15'),
(3, '1 ère Année', 'Un an', '1', 50000, '2023-08-25 18:29:49'),
(4, '1 ère Année', 'une année', '2023-2024', 67500, '2023-09-11 16:43:26'),
(5, '2 eme annéé', 'hebvhjbvevvvvvvvvvvvvvvv', '2023-2024', 200000, '2023-09-13 00:43:11');

-- --------------------------------------------------------

--
-- Structure de la table `fees`
--

CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fees`
--

INSERT INTO `fees` (`id`, `course_id`, `description`, `amount`) VALUES
(1, 1, 'Tuition', 3000),
(3, 1, 'sample', 1500),
(4, 2, 'Annnuel', 30000),
(5, 3, 'Mensuel', 50000),
(6, 4, '1 ère tranche', 22500),
(7, 4, '2 ème tranche', 22500),
(8, 4, '3 ème tranche', 22500),
(9, 5, 'hvbchj', 200000);

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `ef_id` int(30) NOT NULL,
  `amount` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`id`, `ef_id`, `amount`, `remarks`, `date_created`) VALUES
(1, 1, 1000, 'sample', '2020-10-31 14:25:35'),
(2, 1, 500, 'sample 2', '2020-10-31 14:47:15'),
(3, 3, 25000, 'tres bien', '2023-09-14 22:16:11'),
(4, 4, 20000, 'Première tranche', '2023-08-25 18:32:04'),
(5, 4, 10000, 'deuxième tranche', '2023-08-25 18:33:55'),
(6, 4, 20000, 'Troisième tranche', '2023-08-25 18:35:19'),
(7, 1, 200, 'par chèque bancaire', '2023-09-09 23:14:35'),
(8, 0, 0, '', '2023-09-10 15:44:57'),
(11, 0, 0, '', '2023-09-11 00:01:01'),
(12, 0, 0, '', '2023-09-11 00:01:31'),
(13, 2, 600, 'dsnjefkjsnkfvvvvvvvvvvvvvvvvvvvvvvvvvvv', '2023-09-14 22:22:19'),
(14, 1, 700, 'gsfgcsgvq', '2023-09-14 21:45:44'),
(15, 9, 100000, 'trimestrielle', '2023-09-15 11:20:05');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `id` int(30) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `id_no`, `name`, `contact`, `prenom`, `date_created`) VALUES
(1, '06232014', 'John Smith', '+18456-5455-55', 'Sample Address', '2020-10-31 11:24:42'),
(2, '1415', 'George Wilson', '+18456-5455-55', 'Sample Address', '2020-10-31 11:29:38'),
(3, 'MB8251', 'Bane', '82511723', 'New York', '2023-02-09 01:14:23'),
(4, 'GFATGFAGF', 'Aly', '82511723', 'MG', '2023-08-25 18:28:29'),
(6, 'yfyu', 'gug', 'goiu', 'oui\r\n', '2023-09-09 00:01:50'),
(8, 'fytf', 'fgy', 'gfyg', 'yfyuu', '2023-09-09 00:02:18'),
(11, 'pohuv', 'gcg', 'chgvchg', ' hg', '2023-09-09 00:02:55'),
(14, 'GGCGGVHV', 'hb jhbjhb', 'hjbjb', 'hv hgvhj', '2023-09-13 23:06:41'),
(16, 'ASH645790', 'Sall', '652424452', 'Adama', '2023-09-15 11:13:42'),
(17, 'tygdftdctr', 'gfvhg', 'vhg', 'gfytfytfy', '2023-09-15 11:14:53'),
(18, 'Gfsrrsrfdtrd', 'gfcftc', 'gfg', 'gdtfcdftr', '2023-09-15 11:15:23');

-- --------------------------------------------------------

--
-- Structure de la table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `ef_no` varchar(200) NOT NULL,
  `course_id` int(30) NOT NULL,
  `total_fee` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `student_ef_list`
--

INSERT INTO `student_ef_list` (`id`, `student_id`, `ef_no`, `course_id`, `total_fee`, `date_created`) VALUES
(1, 2, '2020-654278', 1, 4500, '2020-10-31 12:04:18'),
(2, 1, '2020-65427823', 1, 4500, '2020-10-31 13:12:13'),
(3, 1, '00223', 2, 30000, '2022-08-25 18:18:09'),
(4, 4, '00223400', 3, 50000, '2023-08-25 18:31:15'),
(7, 14, 'FCGFCGVCT12', 5, 200000, '2023-09-15 00:55:10'),
(8, 6, 'OG202387', 5, 200000, '2023-09-15 01:00:42'),
(9, 16, 'AS202354', 5, 200000, '2023-09-15 11:18:18');

-- --------------------------------------------------------

--
-- Structure de la table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Système de gestion scolaire', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

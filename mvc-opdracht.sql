-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 17 jun 2023 om 22:05
-- Serverversie: 8.0.30
-- PHP-versie: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc-opdracht`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `battle`
--

CREATE TABLE `battle` (
  `id` int NOT NULL,
  `date` datetime NOT NULL,
  `type` enum('5 min max','10 min max','20 min max') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `winner_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `robot`
--

CREATE TABLE `robot` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `weapon` varchar(255) DEFAULT NULL,
  `armour` varchar(255) DEFAULT NULL,
  `propulsion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `robot_battle`
--

CREATE TABLE `robot_battle` (
  `id` int NOT NULL,
  `robot_id` int NOT NULL,
  `battle_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `battle`
--
ALTER TABLE `battle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `winner_id` (`winner_id`);

--
-- Indexen voor tabel `robot`
--
ALTER TABLE `robot`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `robot_battle`
--
ALTER TABLE `robot_battle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `battle_id` (`battle_id`),
  ADD KEY `robot_id` (`robot_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `battle`
--
ALTER TABLE `battle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `robot`
--
ALTER TABLE `robot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `robot_battle`
--
ALTER TABLE `robot_battle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `battle`
--
ALTER TABLE `battle`
  ADD CONSTRAINT `battle_ibfk_1` FOREIGN KEY (`winner_id`) REFERENCES `robot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `robot_battle`
--
ALTER TABLE `robot_battle`
  ADD CONSTRAINT `robot_battle_ibfk_1` FOREIGN KEY (`battle_id`) REFERENCES `battle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `robot_battle_ibfk_2` FOREIGN KEY (`robot_id`) REFERENCES `robot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

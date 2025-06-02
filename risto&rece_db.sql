-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 21, 2025 alle 20:02
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ristorante_recensioni`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `id_recensione` int(11) NOT NULL,
  `voto` int(11) NOT NULL CHECK (`voto` >= 1 and `voto` <= 5),
  `data_rec` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_utente` bigint(11) NOT NULL,
  `id_ristorante` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`id_recensione`, `voto`, `data_rec`, `id_utente`, `id_ristorante`) VALUES
(1, 3, '2025-04-18 09:28:52', 1, 1),
(2, 4, '2025-04-25 17:57:07', 1, 5),
(3, 3, '2025-04-25 17:57:07', 4, 7),
(4, 2, '2025-04-25 17:57:07', 3, 5),
(5, 1, '2025-04-25 17:57:07', 5, 2),
(6, 3, '2025-04-25 17:57:07', 3, 2),
(7, 2, '2025-04-25 17:57:07', 1, 6),
(8, 5, '2025-04-25 17:57:07', 5, 5),
(9, 4, '2025-05-03 08:58:01', 1, 10),
(10, 1, '2025-05-20 15:44:22', 1, 9),
(11, 2, '2025-05-21 17:01:50', 2, 3),
(12, 1, '2025-05-21 17:12:22', 2, 9),
(13, 5, '2025-05-21 17:40:41', 8, 4),
(14, 4, '2025-05-21 17:45:53', 8, 8),
(15, 3, '2025-05-21 17:46:02', 8, 12),
(16, 1, '2025-05-21 17:52:12', 9, 1),
(17, 1, '2025-05-21 17:54:48', 9, 2),
(18, 1, '2025-05-21 17:54:53', 9, 3),
(19, 1, '2025-05-21 17:54:58', 9, 4),
(20, 5, '2025-05-21 17:55:02', 9, 9),
(21, 4, '2025-05-21 17:56:08', 11, 1),
(22, 5, '2025-05-21 17:56:11', 11, 2),
(23, 4, '2025-05-21 17:56:23', 11, 4),
(24, 1, '2025-05-21 17:57:22', 12, 7),
(25, 4, '2025-05-21 17:57:26', 12, 10),
(26, 3, '2025-05-21 17:57:29', 12, 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `id_ristorante` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `latitudine` decimal(9,7) NOT NULL DEFAULT 43.7800127 CHECK (`latitudine` between -90.0000000 and 90.0000000),
  `longitudine` decimal(9,7) NOT NULL DEFAULT 11.1997685 CHECK (`longitudine` between -180.0000000 and 180.0000000)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`id_ristorante`, `nome`, `indirizzo`, `citta`, `latitudine`, `longitudine`) VALUES
(1, 'Il Torrione', 'Via Roma, 78', 'Scarperia e San Piero', 43.9963822, 11.3550834),
(2, 'Borgo Bistrot', 'Viale Fratelli Kennedy, 45', 'Borgo S. Lorenzo', 43.9537458, 11.3974672),
(3, 'La casa del prosciutto', 'Via Ponte a Vicchio, 1', 'Vicchio', 43.9281474, 11.4671659),
(4, 'Passaguai', 'Piazza Giuseppe Garibaldi, 2', 'Borgo S. Lorenzo', 43.9538952, 11.3870686),
(5, 'I\'Cantuccio', 'Via Angelo Gatti, 3/B', 'Borgo S. Lorenzo', 44.0038586, 11.4289982),
(6, 'Da Bertone', 'Via XXIV Maggio 60', 'Lastra a Signa', 43.7711397, 11.1091447),
(7, 'L\'amorino', 'Piazza Luciano Manara 5/7', 'Scandicci', 43.7566392, 11.1878941),
(8, 'La valle dei re', 'Piazza Piave 2', 'Scandicci', 43.7536633, 11.3870686),
(9, 'La musica', 'Via Vecchia Pisana 108', 'Malmantile', 43.7457531, 11.0685361),
(10, 'Il Rustico', 'Piazza Garibaldi, 2', 'Scarperia e San Piero', 43.9940724, 11.3546458),
(12, 'La Bisboccina', 'Via Provinciale, 38', 'Scarperia e San Piero', 43.9617429, 11.3238335);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (  
  `id_cliente` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwrd` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_reg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_cliente`, `username`, `passwrd`, `nome`, `cognome`, `email`, `data_reg`, `is_admin`) VALUES
(1, 'koala13', '2f73897cecf3a38974cad0743c269bd499b264f13f73262cfec771b61cc8a296', 'Ezio', 'Auditore', 'nencinipietro2006@gmail.com', '2025-05-21 16:41:31', 0),
(2, 'Hermano', '62648d1b1678a8fd0e84f310dd12f4bb7834a670818cebdbcaa69130ac05d20e', 'Armando', 'Diaz', 'diazelgrande@yahoo.com', '2025-05-21 16:39:09', 0),
(3, 'qwerty_pro', 'a3461f3df3269957ae40e173ebdae13bbf1de559c57ed1294b17594099f3f220', 'Rodrigo', 'Parigi', 'rodrithebest@gmail.com', '2025-05-21 16:39:32', 0),
(4, 'tommipari', 'a95240c37239a94198a0b86dfb8a38fac46463919aa9bf41e10d16d1a957d197', 'Tommaso', 'Parigi', 'tommaso.parigi06@gmail.com', '2025-04-02 22:00:00', 0),
(5, 'noklosupestar', '92f681fbbca7cf50385b3d0606215519a376f4a4046ac7d93db6f91e0a70b36c', 'Niccolò', 'Mancini', 'niccolomancini3@gmail.com', '2025-04-07 22:00:00', 0),
(6, 'admin', '0e151beee3ce8e972d9899cffb0a6eabeb33f26f30800ddfe2a1dda77baa3e4d', 'admin_n', 'admin_c', 'ristorece.admin@info.it', '2025-05-17 10:58:47', 1),
(7, 'Diescii', '15b61974b2707a7b3d4201385e0f01f4ff5eb1f17c5639d98788ee5add2025cd', 'Alessandro', 'Borghese', 'iborghe12@cucinaitaliana.com', '2025-05-21 17:35:38', 0),
(8, 'Giorgione', '67984990fd8df7a994884e64dfe339172ede40a575f5c31462fdc977d5ea60ca', 'Giorgio', 'Armani', 'unamail@acaso.it', '2025-05-21 16:53:08', 0),
(9, 'Hotwheels', '6548856c43c4633603a1a76f105901d5c6bc04c4744354c8453a9b9cf800eabc', 'Giuseppa', 'Profitti', 'lagiuse@gmail.com', '2025-05-21 16:53:08', 0),
(10, 'LoStrigo23', 'e2f2a13f10e59042bb065a177e9d9bf53914f39477078f033eed904ae99ef4f5', 'Geralt', 'Di Rivia', 'geralt.rivia@strighitalia.com', '2025-05-21 16:53:08', 0),
(11, 'Supercar', '5b88429ef44f4fd7391ea62048e8efa7766eade7d548a265d6f183ba71021d40', 'Peugeot', '206', 'mycar@cars.com', '2025-05-21 16:53:08', 0),
(12, 'the_dark_side', '35f6fcf958ab8e3ba080eb72dd7b2155af5be5a75f393a56f31f1dba9018f336', 'Anakin', 'Skywalker', 'skywalker.anakin@jediorder.cor', '2025-05-21 17:01:02', 0),
(13, 'Masterchef', '03ec0f879a5c0336e4be0938332256a60c6d4200d76d859f3fc6434da229c6ca', 'Antonino', 'Cannavacciuolo', 'anto.canna@cucineitaliane.com', '2025-05-21 17:58:08', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`id_recensione`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_ristorante` (`id_ristorante`);

--
-- Indici per le tabelle `ristorante`
--
ALTER TABLE `ristorante`
  ADD PRIMARY KEY (`id_ristorante`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `id_recensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  MODIFY `id_ristorante` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id_cliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_cliente`),
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`id_ristorante`) REFERENCES `ristorante` (`id_ristorante`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

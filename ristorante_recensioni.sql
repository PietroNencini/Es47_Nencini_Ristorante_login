-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 25, 2025 alle 20:10
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
(8, 5, '2025-04-25 17:57:07', 5, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `id_ristorante` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`id_ristorante`, `nome`, `indirizzo`, `citta`) VALUES
(1, 'Il Torrione', 'Via Roma, 78', 'Scarperia e San Piero'),
(2, 'Borgo Bistrot', 'Viale Fratelli Kennedy, 45', 'Borgo S. Lorenzo'),
(3, 'La casa del prosciutto', 'Via Ponte a Vicchio, 1', 'Vicchio'),
(4, 'Passaguai', 'Piazza Giuseppe Garibaldi, 2', 'Borgo S. Lorenzo'),
(5, 'I\'Cantuccio', 'Via Angelo Gatti, 3/B', 'Borgo S. Lorenzo'),
(6, 'Da Bertone', 'Via XXIV Maggio 60', 'Lastra a Signa'),
(7, 'L\'amorino', 'Piazza Luciano Manara 5/7', 'Scandicci'),
(8, 'La valle dei re', 'Piazza Piave 2', 'Scandicci'),
(9, 'La musica', 'Via Vecchia Pisana 108', 'Malmantile');

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
  `data_reg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_cliente`, `username`, `passwrd`, `nome`, `cognome`, `email`, `data_reg`) VALUES
(1, 'Nencio2006', '2f73897cecf3a38974cad0743c269bd499b264f13f73262cfec771b61cc8a296', 'Pietro', 'Nencini', 'nencinipietro2006@gmail.com', '2025-04-15 19:37:30'),
(2, 'Hermano', 'lululu45', 'Armando', 'Diaz', 'diazelperro@yahoo.com', '2025-03-20 08:29:38'),
(3, 'qwerty_pro', 'azerty56!', 'Rodrigo', 'Parigi', 'rodrithebest@gmail.com', '2025-03-20 08:30:32'),
(4, 'tommipari', 'a95240c37239a94198a0b86dfb8a38fac46463919aa9bf41e10d16d1a957d197', 'Tommaso', 'Parigi', 'tommaso.parigi06@gmail.com', '2025-04-02 22:00:00'),
(5, 'noklosupestar', '92f681fbbca7cf50385b3d0606215519a376f4a4046ac7d93db6f91e0a70b36c', 'Niccolò', 'Mancini', 'niccolomancini3@gmail.com', '2025-04-07 22:00:00');

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
  MODIFY `id_recensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  MODIFY `id_ristorante` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id_cliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

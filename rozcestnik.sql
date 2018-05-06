-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Čas generovania: St 21.Jún 2017, 00:06
-- Verzia serveru: 5.6.26
-- Verzia PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `rozcestnik`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rozcestnik_cubes`
--

CREATE TABLE IF NOT EXISTS `rozcestnik_cubes` (
  `cube_id` tinyint(4) NOT NULL,
  `url` varchar(120) COLLATE utf8mb4_slovak_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_slovak_ci NOT NULL,
  `title` varchar(30) COLLATE utf8mb4_slovak_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_slovak_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `category` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `rozcestnik_cubes`
--

INSERT INTO `rozcestnik_cubes` (`cube_id`, `url`, `name`, `title`, `color`, `visible`, `category`) VALUES
(3, 'http://python.input.sk', 'Programovanie 1, 2', '', '', 1, 1),
(4, 'http://edi.fmph.uniba.sk/~tomcsanyi/sys1.html', 'PP - Systémové programovanie ', '', '', 1, 1),
(5, 'http://www.dcs.fmph.uniba.sk/siete/', 'PC siete', '', '', 1, 1),
(6, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=533', 'Webové aplikácie', '', '', 1, 1),
(7, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=528', 'Linux pre používateľov', 'Marek Nagy', '', 1, 1),
(8, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=526', 'SAIT', 'Winczer Michal', 'red', 1, 1),
(9, 'https://moodle.uniba.sk/moodle/inf11/course/index.php?categoryid=132', 'Moodle', '', '', 1, 2),
(10, 'http://capek.ii.fmph.uniba.sk/list', 'L.I.S.T', '', '', 1, 2),
(11, 'http://www.sccg.sk/~lucan/', 'Ročníkový projekt 1', '', '', 1, 3),
(12, 'https://votr.uniba.sk/', 'Votr', '', '', 1, 2),
(13, 'https://moja.uniba.sk/', 'moja.uniba.sk', '', '', 1, 3);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rozcestnik_messages`
--

CREATE TABLE IF NOT EXISTS `rozcestnik_messages` (
  `mid` smallint(3) NOT NULL,
  `uid` tinyint(4) NOT NULL,
  `text` text COLLATE utf8mb4_slovak_ci NOT NULL,
  `predmet` tinyint(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `cas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `rozcestnik_messages`
--

INSERT INTO `rozcestnik_messages` (`mid`, `uid`, `text`, `predmet`, `status`, `cas`) VALUES
(2, 3, 'SKUSKA 27! prva.', 2, 1, '2017-06-20 19:30:44'),
(5, 3, 'Svet je iluzia.', 0, 1, '2017-06-20 19:30:44'),
(6, 3, 'AHOJTEEEE', 0, 1, '2017-06-20 19:30:53'),
(7, 3, 'sme v Matrixe?', 0, 1, '2017-06-20 19:37:33'),
(9, 3, 'SAIT bol fajn', 6, 1, '2017-06-20 19:41:39'),
(10, 3, 'Midterm - 21.5!', 1, 1, '2017-06-20 20:10:22'),
(11, 3, 'Linux hotovo!', 5, 1, '2017-06-20 20:11:22'),
(12, 3, 'WA bolo tazke', 4, 1, '2017-06-20 20:11:35');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rozcestnik_predmety`
--

CREATE TABLE IF NOT EXISTS `rozcestnik_predmety` (
  `pid` tinyint(1) NOT NULL,
  `predmet` varchar(18) COLLATE utf8mb4_slovak_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `rozcestnik_predmety`
--

INSERT INTO `rozcestnik_predmety` (`pid`, `predmet`) VALUES
(0, '-'),
(1, 'Programovanie'),
(2, 'PP-SP'),
(3, 'PC siete'),
(4, 'WA'),
(5, 'Linux'),
(6, 'SAIT');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `rozcestnik_users`
--

CREATE TABLE IF NOT EXISTS `rozcestnik_users` (
  `user_id` int(5) NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_slovak_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8mb4_slovak_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_slovak_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8mb4_slovak_ci NOT NULL,
  `user_table` tinytext COLLATE utf8mb4_slovak_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `rozcestnik_users`
--

INSERT INTO `rozcestnik_users` (`user_id`, `email`, `pass`, `name`, `surname`, `user_table`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Adminovsky', 'rozcestnik_cubes', 1),
(3, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', 'test', 'user3', 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user3`
--

CREATE TABLE IF NOT EXISTS `user3` (
  `cube_id` tinyint(4) NOT NULL,
  `url` varchar(120) COLLATE utf8mb4_slovak_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_slovak_ci NOT NULL,
  `title` varchar(30) COLLATE utf8mb4_slovak_ci DEFAULT NULL,
  `color` varchar(20) COLLATE utf8mb4_slovak_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `category` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `user3`
--

INSERT INTO `user3` (`cube_id`, `url`, `name`, `title`, `color`, `visible`, `category`) VALUES
(3, 'http://python.input.sk', 'Programovanie 1, 2', '', '', 1, 1),
(4, 'http://edi.fmph.uniba.sk/~tomcsanyi/sys1.html', 'PP - Systémové programovanie ', '', '', 1, 1),
(5, 'http://www.dcs.fmph.uniba.sk/siete/', 'PC siete', '', '', 1, 1),
(6, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=533', 'Webové aplikácie', '', '', 1, 1),
(7, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=528', 'Linux pre používateľov', 'Marek Nagy', '', 1, 1),
(8, 'https://moodle.uniba.sk/moodle/inf11/course/view.php?id=526', 'SAIT', 'Winczer Michal', 'red', 1, 1),
(9, 'https://moodle.uniba.sk/moodle/inf11/course/index.php?categoryid=132', 'Moodle', '', '', 1, 2),
(10, 'http://capek.ii.fmph.uniba.sk/list', 'L.I.S.T', '', '', 1, 2),
(11, 'http://www.sccg.sk/~lucan/', 'Ročníkový projekt 1', '', '', 1, 3),
(12, 'https://votr.uniba.sk/', 'Votr', '', '', 1, 2),
(13, 'https://moja.uniba.sk/', 'moja.uniba.sk', '', '', 1, 3);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `rozcestnik_cubes`
--
ALTER TABLE `rozcestnik_cubes`
  ADD PRIMARY KEY (`cube_id`);

--
-- Indexy pre tabuľku `rozcestnik_messages`
--
ALTER TABLE `rozcestnik_messages`
  ADD PRIMARY KEY (`mid`);

--
-- Indexy pre tabuľku `rozcestnik_predmety`
--
ALTER TABLE `rozcestnik_predmety`
  ADD PRIMARY KEY (`pid`);

--
-- Indexy pre tabuľku `rozcestnik_users`
--
ALTER TABLE `rozcestnik_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexy pre tabuľku `user3`
--
ALTER TABLE `user3`
  ADD PRIMARY KEY (`cube_id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `rozcestnik_cubes`
--
ALTER TABLE `rozcestnik_cubes`
  MODIFY `cube_id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pre tabuľku `rozcestnik_messages`
--
ALTER TABLE `rozcestnik_messages`
  MODIFY `mid` smallint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pre tabuľku `rozcestnik_predmety`
--
ALTER TABLE `rozcestnik_predmety`
  MODIFY `pid` tinyint(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pre tabuľku `rozcestnik_users`
--
ALTER TABLE `rozcestnik_users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pre tabuľku `user3`
--
ALTER TABLE `user3`
  MODIFY `cube_id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: database-5010259727.webspace-host.com
-- Erstellungszeit: 23. Jan 2024 um 17:01
-- Server-Version: 5.7.42-log
-- PHP-Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbs8693768`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Komponist`
--

CREATE TABLE `Komponist` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Nachname` varchar(14) DEFAULT NULL,
  `Vorname` varchar(23) DEFAULT NULL,
  `Geburtsdatum` varchar(10) DEFAULT NULL,
  `Sterbedatum` varchar(10) DEFAULT NULL,
  `Geburtsjahr` varchar(6) DEFAULT NULL,
  `Sterbejahr` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Komponist`
--

INSERT INTO `Komponist` (`ID`, `Nachname`, `Vorname`, `Geburtsdatum`, `Sterbedatum`, `Geburtsjahr`, `Sterbejahr`) VALUES
(1, 'Mozart', 'Wolfgang Amadeus', '', '', '1756', '1791'),
(3, '(unbekannt)', '', '', '', '', ''),
(4, 'Schumann', 'Robert', '', '', '1810', '1856'),
(5, 'Boccherini', 'Luigi', '', '', '1743', '1805'),
(6, 'Schubert', 'Franz', '', '', '1797', '1828'),
(7, 'Bach', 'Johann Sebastian', '', '', '', ''),
(9, 'Händel', 'Georg Friedrich', '', '', '1685', '1759'),
(10, 'Lully', 'Jean Baptiste', '', '', '1632', '1686'),
(11, 'Ebel', 'Eduard', '', '', '1839', '1905'),
(12, 'Caesar', 'Johann Melchior', '', '', '1648', '1692'),
(13, 'Fischer', 'Johann Caspar Ferdinand', '', '', '1650 ?', '1746'),
(14, 'Fischer', 'Johann', '', '', '1646', '1760'),
(15, 'Haydn', 'Joseph', '', '', '1732', '1809'),
(16, '(Traditional)', '', '', '', '', ''),
(17, 'Franck', 'Cáesar', '', '', '1822', '1890'),
(18, 'Schaum', 'Wesley', '', '', '', ''),
(19, 'de Bériot', 'Charles de', '', '', '1802', '1870'),
(20, 'Grieg', 'Edvard', '', '', '', ''),
(21, 'Haussmann', 'Valentin', '', '', '', ''),
(22, 'Schein', 'Johann Herman', '', '', '', ''),
(23, 'Bingham', 'George', '', '', '', ''),
(24, 'Telemann', 'Georg Philipp', '', '', '', ''),
(25, 'Finger', 'Gottfried', '', '', '1660', '1723'),
(26, 'Jaques', 'Hotteterre', '', '', '', ''),
(27, 'de Boismortier', ' J. Baptiste', '', '', '', ''),
(28, 'de Fesch ', 'Willem', '', '', '', ''),
(29, 'de Montéclair ', 'M. P. ', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Musikstueck`
--

CREATE TABLE `Musikstueck` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `Opus` varchar(3) DEFAULT NULL,
  `SammlungID` int(2) DEFAULT NULL,
  `Nummer` varchar(2) DEFAULT NULL,
  `KomponistID` varchar(2) DEFAULT NULL,
  `Bearbeiter` varchar(26) DEFAULT NULL,
  `Epoche` varchar(18) DEFAULT NULL,
  `Verwendungszweck` varchar(26) DEFAULT NULL,
  `Gattung` varchar(29) DEFAULT NULL,
  `Besetzung` varchar(58) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Musikstueck`
--

INSERT INTO `Musikstueck` (`ID`, `Name`, `Opus`, `SammlungID`, `Nummer`, `KomponistID`, `Bearbeiter`, `Epoche`, `Verwendungszweck`, `Gattung`, `Besetzung`) VALUES
(1, 'Ave Verum', '', 1, '9', '1', 'Pracht, Robert', 'Klassik', 'Hochzeit, Beerdigung', 'Vortragsstück', 'Violine und Klavier'),
(9, 'Alle Affen Alabamas', '', 4, '1', '3', '', '', '', '', 'Violine'),
(10, 'Das Dackeldrama', '', 4, '2', '3', '', '', '', '', 'Violine'),
(11, 'Pausenstück', '', 4, '3', '3', '', '', '', '', 'Violine'),
(12, 'Menuett', '', 1, '10', '1', 'Pracht, Robert', 'Klassik', '(unbestimmt)', 'Vortragsstück', 'Violine und Klavier'),
(13, 'Abendlied', '', 1, '11', '4', 'Pracht, Robert', 'Romantik', '(unbestimmt)', 'Vortragsstück', 'Violine und Klavier'),
(14, 'Menuett', '', 1, '12', '5', 'Pracht, Robert', 'Klassik', '(unbestimmt)', 'Vortragsstück', 'Violine und Klavier'),
(15, 'Ave Maria', '', 1, '13', '6', 'Pracht, Robert', 'Klassik', 'Hochzeit, Beerdigung', 'Vortragsstück', 'Violine und Klavier'),
(16, 'Bourée', '', 1, '14', '7', '', '', '', '', 'Violine und Klavier'),
(17, 'Laßt uns froh und munter sein', '', 5, '1', '3', 'Jähne, Christoph', '', 'Nikolaus', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(18, 'Kling Glöckchen', '', 5, '2', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(19, 'Menuett', '', 5, '3', '9', 'Jähne, Christoph', 'Barock', 'Fest', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(20, 'Schneeflöckchen', '', 5, '4', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(21, 'Festlicher Marsch', '', 5, '5', '9', 'Jähne, Christoph', 'Barock', 'Fest', 'Marsch', 'Streichquartett, Streichorchester'),
(22, 'Bourée', '', 5, '6', '9', 'Jähne, Christoph', 'Barock', 'Fest', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(23, 'Macht hoch die Tür', '', 5, '7', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(24, 'Menuett', '', 5, '8', '10', 'Jähne, Christoph', 'Barock', 'Fest', 'Tanzsatz', 'Streichorchester, 3 Violinen, Viola, Bass'),
(25, 'Leise rieselt der Schnee', '', 5, '9', '11', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(26, 'Sarabanda', '', 5, '10', '12', 'Jähne, Christoph', 'Frühbarock', '(unbestimmt)', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(27, 'Vom Himmel hoch', '', 5, '11', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(28, 'Menuett', '', 5, '12', '13', 'Jähne, Christoph', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Streichorchester, 2 Violinen, 2 Viola, Bass'),
(29, 'Es ist ein Ros entsprungen', '', 5, '13', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(30, 'Menuett', '', 5, '14', '9', 'Jähne, Christoph', 'Barock', 'Fest', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(31, 'Stille Nacht', '', 5, '15', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(32, 'Gavotte', '', 5, '16', '14', 'Jähne, Christoph', 'Frühbarock', '(unbestimmt)', 'Tafelmusik', 'Streichquartett, Streichorchester'),
(33, 'Oh freudenreicher Tag', '', 5, '17', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(34, 'Bourrée', '', 5, '18', '12', 'Jähne, Christoph', 'Frühbarock', '(unbestimmt)', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(35, 'Laßt uns das Kindelein wiegen', '', 5, '19', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(36, 'Alle Jahre wieder', '', 5, '20', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichorchester, Streichquartett, 4 Violinen, Viola, Bass'),
(37, 'Ihr Kinderlein kommet', '', 5, '21', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(38, 'Oh du Fröhliche', '', 5, '22', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(39, 'Menuett', '', 5, '23', '14', 'Jähne, Christoph', 'Frühbarock', '(unbestimmt)', 'Tanzsatz', 'Streichquartett, Streichorchester'),
(40, 'Kommet ihr Hirten', '', 5, '24', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(41, 'Was soll das bedeuten', '', 5, '25', '3', 'Jähne, Christoph', '', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(42, 'Ich steh an deiner Krippen hier', '', 5, '26', '7', 'Jähne, Christoph', 'Barock', 'Weihnachten', 'Choralbearbeitung', 'Streichquartett, Streichorchester'),
(43, 'Schlaf mein Kindelein', '', 5, '27', '3', 'Jähne, Christoph', 'Barock', 'Weihnachten', 'Liedbearbeitung', 'Streichquartett, Streichorchester'),
(44, 'Menuett', '', 1, '15', '15', 'Pracht, Robert', 'Klassik', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(45, 'Rondo', '', 1, '16', '6', 'Pracht, Robert', 'Klassik / Romantik', '(unbestimmt)', 'Vortragsstück', 'Violine und Klavier'),
(46, 'Charley Marley', '', 6, '1', '16', '', '(nicht relevant)', '', 'Folklore, karibische', 'Streichorchester: 3 Violinen, 2 Viola, 2 Celli, Bass'),
(47, 'Boysie', '', 6, '2', '16', 'Colledge, Katherine & Hugh', '(nicht relevant)', '(unbestimmt)', 'Folklore, karibische', 'Streichorchester: 3 Violinen, 2 Viola, 2 Celli, Bass'),
(48, 'The Wreck of the Sloop John B', '', 6, '3', '16', 'Colledge, Katherine & Hugh', '(nicht relevant)', '(unbestimmt)', 'Folklore, karibische', 'Streichorchester: 3 Violinen, 2 Viola, 2 Celli, Bass'),
(49, 'Mango Walk', '', 6, '4', '16', 'Colledge, Katherine & Hugh', '(nicht relevant)', '(unbestimmt)', 'Folklore, karibische', 'Streichorchester: 3 Violinen, 2 Viola, 2 Celli, Bass'),
(50, 'Poco allegretto', '', 7, '1', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(51, 'Quasi allegro', '', 7, '2', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(52, 'Chante de la Creuse', '', 7, '3', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(53, 'Maestoso', '', 7, '4', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(54, 'Vieux Noel', '', 7, '5', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(55, 'Vieux Noel', '', 7, '6', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(56, 'Andantino poco allegretto', '', 7, '7', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(57, 'Molto moderato', '', 7, '8', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(58, 'Noel Angevin', '', 7, '9', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(59, 'Vieux Noel', '', 7, '10', '17', '', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(60, 'Poco allegretto', '', 7, '11', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(61, 'Noel Angevin', '', 7, '12', '17', 'Roelcke, Christa', 'Romantik', '(unbestimmt), Gottesdienst', 'Orgelimprovisationsbeareitung', 'Streichquartett, Streichorchester, Blockflötenensemble'),
(62, 'Easy Come, Easy Go', '', 8, '1', '18', 'Kaluza, Günter', '(Modern)', '(unbestimmt)', 'Jazz', 'Streichquartett, Streichorchester'),
(63, 'Lively One', '', 8, '2', '18', 'Kaluza, Günter', '(Modern)', '(unbestimmt)', 'Jazz', 'Streichquartett, Streichorchester'),
(64, 'Scène de Ballet', '100', 9, '', '19', '', 'Romantik', '(unbestimmt)', 'Konzertstück', 'Violine und Klavier'),
(65, 'Peer Gynt Suite Nr. 1', '46', 10, '1', '20', '', 'Romantik', '(unbestimmt)', 'Orchestermusik', 'Symphonie-Orchester'),
(66, 'Pavane - Galliarde', '', 11, '1', '21', '', 'Renaissance', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(67, 'Allemande - Tripla', '', 11, '2', '22', '', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(68, 'Air (Bourrée)', '', 11, '3', '23', '', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(69, 'Air', '', 11, '4', '3', '', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(70, 'Menuett', '', 11, '5', '24', '', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(71, 'Symphony', '', 11, '6', '25', '', 'Barock', '(unbestimmt)', 'Einleitungssatz', 'Violine und Klavier'),
(72, 'Suite', '', 11, '7', '23', '', 'Barock', '(unbestimmt)', 'Suite', 'Violine und Klavier'),
(73, 'Scotch Air', '', 11, '8', '23', '', 'Barock', '(unbestimmt)', 'Tanzsatz', 'Violine und Klavier'),
(74, '\"Rondeau \"\"Le Baron\"\"\"', '', 11, '9', '26', '', 'Barock', '', 'Tanzsatz', 'Violine und Klavier'),
(75, 'Gigue', '', 11, '10', '27', '', 'Barock', '', 'Tanzsatz', 'Violine und Klavier'),
(76, 'Air', '', 11, '11', '3', '', 'Barock', '', 'Tanzsatz', 'Violine und Klavier'),
(77, 'Vivace', '', 11, '12', '28', '', 'Barock', '', 'Sonatensatz', 'Violine und Klavier'),
(78, 'Corrente', '', 11, '13', '29', '', 'Barock', '', 'Tanzsatz', 'Violine und Klavier'),
(79, '14 G. Ph. Telemann Largo', '', 11, '', '', '', '', '', '', ''),
(80, '15 G. Ph. Telemann Sarabande', '', 11, '', '', '', '', '', '', ''),
(81, '16 P. degli Antonii Balletto e Giga. .', '', 11, '', '', '', '', '', '', ''),
(82, '17 P. degli Antoni Allemande', '', 11, '', '', '', '', '', '', ''),
(83, '18 W. Wodiczka Siciliana', '', 11, '', '', '', '', '', '', ''),
(84, '19 J. Aubert Gavotte en Rondeau . .', '', 11, '', '', '', '', '', '', ''),
(85, '20 M. Corrette Le Coucou', '', 11, '', '', '', '', '', '', ''),
(86, '21 J. B. de Boismortier Allegretto . . .', '', 11, '', '', '', '', '', '', ''),
(87, '22 J. Aubert Menuets (E-e)', '', 11, '', '', '', '', '', '', ''),
(88, '23 J. Aubert Menuets (D-d)', '', 11, '', '', '', '', '', '', ''),
(89, '24 M. Corrette Allegro', '', 11, '', '', '', '', '', '', ''),
(90, '25 D. Steibelt Sonatine', '', 11, '', '', '', '', '', '', ''),
(91, '26 M. Hauptmann Andante', '', 11, '', '', '', '', '', '', ''),
(92, '27 M. Hauptmann Sonatine', '', 11, '', '', '', '', '', '', ''),
(93, '28 H. E. Kayser Walzer. Waltz . . .', '', 11, '', '', '', '', '', '', ''),
(94, '29 C. M. v. Weber Romanze', '', 11, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Musikstueck_tmp`
--

CREATE TABLE `Musikstueck_tmp` (
  `ID` int(2) DEFAULT NULL,
  `Titel` varchar(40) DEFAULT NULL,
  `Sammlung` varchar(10) DEFAULT NULL,
  `Bemerkung` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Musikstueck_tmp`
--

INSERT INTO `Musikstueck_tmp` (`ID`, `Titel`, `Sammlung`, `Bemerkung`) VALUES
(1, '1 V. Haußmann Pavane - Galliarde', '', ''),
(2, '2 I. H. Schein. Allemande - Tripla .', '', ''),
(3, '3 G. Bingham Air', '', ''),
(4, '4 Anonym Air', '', ''),
(5, '5 G. Ph. Telemann Menuett', '', ''),
(6, '6 G. Finger Symphony', '', ''),
(7, '7 G. Bingham Suite', '', ''),
(8, '8 G. Bingham Scotch Air', '', ''),
(9, '\"9 J. Hotteterre Rondeau Le Baron\"\"\"', '', ''),
(10, '10 I. B. de Boismortier Gigue', '', ''),
(11, '11 Anonym Air', '', ''),
(12, '12 W. de Fesch Vivace', '', ''),
(13, '13 M. P. de Montéclair Corrente . . .', '', ''),
(14, '14 G. Ph. Telemann Largo', '', ''),
(15, '15 G. Ph. Telemann Sarabande', '', ''),
(16, '16 P. degli Antonii Balletto e Giga. .', '', ''),
(17, '17 P. degli Antoni Allemande', '', ''),
(18, '18 W. Wodiczka Siciliana', '', ''),
(19, '19 J. Aubert Gavotte en Rondeau . .', '', ''),
(20, '20 M. Corrette Le Coucou', '', ''),
(21, '21 J. B. de Boismortier Allegretto . . .', '', ''),
(22, '22 J. Aubert Menuets (E-e)', '', ''),
(23, '23 J. Aubert Menuets (D-d)', '', ''),
(24, '24 M. Corrette Allegro', '', ''),
(25, '25 D. Steibelt Sonatine', '', ''),
(26, '26 M. Hauptmann Andante', '', ''),
(27, '27 M. Hauptmann Sonatine', '', ''),
(28, '28 H. E. Kayser Walzer. Waltz . . .', '', ''),
(29, '29 C. M. v. Weber Romanze', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Sammlung`
--

CREATE TABLE `Sammlung` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(56) DEFAULT NULL,
  `Standort` varchar(10) DEFAULT NULL,
  `VerlagID` int(2) DEFAULT NULL,
  `Bestellnummer` varchar(13) DEFAULT NULL,
  `Bemerkung` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Sammlung`
--

INSERT INTO `Sammlung` (`ID`, `Name`, `Standort`, `VerlagID`, `Bestellnummer`, `Bemerkung`) VALUES
(1, 'Klassische Stücke alter Meister - Heft 2', '', 1, '248', ''),
(4, 'Die fröhliche Violine - Band 1', '', 7, 'ED 7299', 'Noch Musikstücke hinzufügen'),
(5, 'Weihnachtsspielbuch für Streicher', '', 8, '6647', ''),
(6, 'Simply 4 Strings - A Caribbean Suite', '', 9, 'M-060-11415-1', ''),
(7, '\"César Franck - Zwölf Miniaturen  - Aus \"\"L\'Organiste\"\"\"', '', 10, 'M 40.164', 'aus CORONA - Werkreihe für Kammerorchester (Partitur ist zugleich Spielpartitur)'),
(8, 'Rhythm & Blues', '', 11, 'BoE 4102', 'Partitur und Einzelstimmen'),
(9, 'Scène de Ballet', '', 13, '', ''),
(10, 'Peer Gynt Suite Nr. 1', '', 14, '', ''),
(11, 'Musik für Violine und Klavier (Elma und Erich Doflein)', '', 7, 'ED 6027', 'XXX Noch Musikstücke hinzufügen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Satz`
--

CREATE TABLE `Satz` (
  `ID` int(10) UNSIGNED NOT NULL,
  `MusikstueckID` int(2) DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `Tonart` varchar(14) DEFAULT NULL,
  `Taktart` varchar(14) DEFAULT NULL,
  `Tempobezeichnung` varchar(31) DEFAULT NULL,
  `Spieldauer` varchar(3) DEFAULT NULL,
  `Schwierigkeitsgrad2` varchar(5) DEFAULT NULL,
  `Lagen` varchar(7) DEFAULT NULL,
  `Stricharten` varchar(64) DEFAULT NULL,
  `Erprobt` varchar(12) DEFAULT NULL,
  `Bemerkung` varchar(162) DEFAULT NULL,
  `Nr` int(1) DEFAULT NULL,
  `Notenwerte` varchar(129) DEFAULT NULL,
  `Schwierig` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Satz`
--

INSERT INTO `Satz` (`ID`, `MusikstueckID`, `Name`, `Tonart`, `Taktart`, `Tempobezeichnung`, `Spieldauer`, `Schwierigkeitsgrad2`, `Lagen`, `Stricharten`, `Erprobt`, `Bemerkung`, `Nr`, `Notenwerte`, `Schwierig`) VALUES
(1, 1, '-', 'F-Dur', '4/4', 'Andante Sostenuto', '160', '4', '1/1,3', 'Détaché, Legato, Portato', 'nein', 'Übung: Bogeneinteilung, dichter Klang, Vibrato, MelodBes: Vorzeichen, zusätzliche, DynamBes: (viele)', 1, '(verschiedene)', 'Untere Mittelstufe 1 / 2'),
(2, 9, '-', 'C-Dur', '4/4', '(keine)', '', '', '', '', '', '', 1, '', ''),
(3, 10, '-', 'C-Dur', '4/4', '(keine)', '', '', '', '', '', '', 1, '', ''),
(4, 11, '-', 'C-Dur', '4/4', '(keine)', '', '', '', '', '', '', 1, '', ''),
(5, 12, '-', 'Es-Dur', '3/4', 'Allegretto', '250', '4', '1,3', 'Détaché, Legato, Spiccato', 'nein', 'Übung: Spiccato, MelodBes: Vorschläge, kurz, DynamBes: (viele)', 1, '(verschiedene)', 'Untere Mittelstufe 2'),
(6, 13, '-', 'D-Dur', '4/4', 'Ausdrucksvoll und sehr gehalten', '110', '4', '1,3,5', 'Legato', 'nein', 'Übung: Gesangliches Spiel, MelodBes: Nachschläge, Triller, RhytmBes: (vielfältig), DynamBes: Fortepiano', 1, '(verschiedene)', 'Obere Mittelstufe 1'),
(7, 14, '-', 'A-Dur / D-Dur', '3/4', '(keine)', '250', '4', '1,3', 'Akzente, Détaché, Spiccato, Legato', 'ja, sehr gut', 'Übung: Spiccato, MelodBes: Vorschläge, kurz, Nachschläge, Triller,, RhytmBes: Synkopen', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(8, 15, '-', 'B-Dur', '4/4', 'Sehr langsam', '240', '4 / 5', '1,3', 'Legato, Angesetzte Bindungen', 'nein', 'Übung: Gesangliches Spiel, RhytmBes: (sehr vielfältig)', 1, '(verschiedene)', 'Obere Mittelstufe 1'),
(9, 16, '-', '', '', 'Allegro', '', '', '', '', '', '', 1, '', ''),
(10, 17, '-', 'F-Dur', '4/4', '(keine)', '120', '', '1', 'Détaché', 'nein', 'Übung: Ensemblespiel', 1, 'Halbe, Viertel, Achtel, Viertelpause', 'Untere Mittelstufe 1'),
(11, 18, '-', 'G-Dur', '4/4', '(keine)', '150', '', '1', 'Détaché, Portato', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche', 1, 'Ganze, Punktierte Halbe, Halbe, Viertel, Achtel, Viertelpause', 'Unterstufe 2'),
(12, 19, '-', 'd-moll', '3/4', '(keine)', '150', '', '1', 'Angesetzte Bindungen, Détaché', 'nein', 'aus der Feuerwerksmusik, Übung: Ensemblespiel, MelodBes: Triller, RhytmBes: Punktierte Viertel, Synkope', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(13, 20, '-', 'D-Dur', '3/4', '(keine)', '120', '', '1', 'gebundene Achtel, Walzerstrich', 'nein', 'Übung: Ensemblespiel, RhytmBes: Auftakt', 1, 'Halbe, Viertel, Achtel', 'Unterstufe 1'),
(14, 21, '-', 'D-Dur', 'Alla breve', '(keine)', '180', '', '1', 'Détaché, Portato, Angesetzte Bindungen', 'nein', '\"aus \"\"Zwölf Märsche\"\", Übung: Ensemblespiel, RhytmBes: Auftakt, Punktierte Viertel\"', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Sechzehntel', 'Unterstufe 2'),
(15, 22, '-', 'd-moll', 'Alla breve', '(keine)', '210', '', '1', 'gebundene Achtel, Détaché, Angesetzte Bindungen', 'nein', 'aus der Feuerwerksmusik, Übung: Ensemblespiel, MelodBes: chromatische Linie, kleine, Vorzeichen, zusätzliche, RhytmBes: Auftakt, Punktierte Halbe', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(16, 23, '-', 'F-Dur', '6/4', '(keine)', '180', '', '1', 'Détaché, Gebundene Viertel', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt, Fünf-Schlag-Note', 1, 'Punktierte Halbe, Halbe, Viertel', 'Untere Mittelstufe 1'),
(18, 24, '-', 'G-Dur', '3/4', '(keine)', '150', '', '1', 'gebundene Achtel,gebunde Viertel, Détaché, Angesetzte Bindungen', 'nein', '\"aus \"\"Le Carneval\"\", Übung: Ensemblespiel, MelodBes: Pralltriller, Vorzeichen, zusätzliche, RhytmBes: Auftakt, Punktierte Viertel, DynamBes: Echo\"', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(19, 25, '-', 'G-Dur', '6/8', '(keine)', '60', '', '1', 'Détaché, Portato', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Punktierte Achtel, Fünf-Achtel-Note', 1, 'Punktierte Halbe, Punktierte Viertel, Viertel, Punktierte Achtel, Sechzehntel', 'Unterstufe 2'),
(20, 26, '-', 'A-Dur (D-Dur)', '3/4', '(keine)', '150', '', '1', 'Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', '\"aus \"\"Balletsuite\"\", Übung: Ensemblespiel, MelodBes: Pralltriller, Vorzeichen, zusätzliche, RhytmBes: Auftakt, Punktierte Viertel, DynamBes: Echo, Stufendynamik\"', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(21, 27, '-', 'D-Dur', '4/4', '(keine)', '60', '', '1', 'Détaché, Gebundene Achtel', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt, Fermaten', 1, 'Viertel, Achtel', 'Unterstufe 1'),
(22, 28, '-', 'G-Dur', '3/4', '(keine)', '180', '', '1', 'Détaché, Gebundene Achtel, Angesetzte Bindungen, Portato', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, Triller, RhytmBes: Punktierte Viertel', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(23, 29, '-', 'G-Dur', '4/4', '(keine)', '60', '', '1', 'Détaché, Portato', 'ja, sehr gut', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt', 1, 'Punktierte Halbe, Halbe, Viertel', 'Unterstufe 1'),
(24, 30, '-', 'D-Dur', '3/4', '(keine)', '150', '', '1', 'Détaché, Angesetzte Bindungen, Legato', 'nein', '\"aus \"\"Feuerwerksmusik\"\", Übung: Ensemblespiel, MelodBes: Langer Vorschlag, Triller, RhytmBes: Punktierte Viertel\"', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Viertelpausen', 'Unterstufe 2'),
(25, 31, '-', 'C-Dur', '6/4', '(keine)', '120', '', '1', 'Détaché, Legato, Portato', 'nein', 'Übung: Ensemblespiel, RhytmBes: Punktierte Viertel, Fünf-Schlag-Note', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(26, 32, '-', 'a-moll / A-Dur', 'Alla breve', '(keine)', '120', '', '1', 'Détaché, Gebundene Achtel', 'nein', '\"Aus \"\"Tafelmusik\"\", Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt, Punktierte Viertel, Unisono, DynamBes: Echo\"', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(27, 33, '-', 'G-Dur', '4/4', '(keine)', '', '', '1', 'Détaché, Gebundene Achtel', '', 'Sammlung Ditfurth, Übung: Ensemblespiel, RhytmBes: Auftakt, Halbe, Unisono', 1, 'Punktierte Halbe, Halbe, Viertel, Achtel', 'Unterstufe 2'),
(28, 34, '-', 'A-Dur (D-Dur)', '4/4', '(keine)', '120', '', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt, DynamBes: Echo, Stufendynamik', 1, 'Punktierte Halbe, Viertel, Achtel', 'Untere Mittelstufe 1'),
(29, 35, '-', 'G-Dur', '3/4', '(keine)', '120', '', '1', 'Détaché, Legato', 'nein', 'Sammlung Ditfurth, Übung: Ensemblespiel, RhytmBes: Auftakte, verschiedenartige', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(30, 36, '-', 'D-Dur', '4/4', '(keine)', '60', '', '1', 'Détaché, Gebundene Achtel', 'ja, sehr gut', 'Übung: Ensemblespiel, RhytmBes: Punktierte Viertel, Unisono', 1, 'Ganze, Halbe, Punktierte Viertel, Achtel', 'Unterstufe 1'),
(31, 37, '-', 'D-Dur', '4/4', '(keine)', '90', '', '1', 'Détaché, Portato', 'ja, sehr gut', 'Übung: Ensemblespiel, RhytmBes: Auftakt, Unisono', 1, 'Punktierte Halbe, Halbe, Viertel', 'Unterstufe 1'),
(32, 38, '-', 'D-Dur', '4/4', '(keine)', '120', '', '1', 'Détaché, Legato, Portato', 'ja, sehr gut', 'Sizilianische Weise, Übung: Ensemblespiel, RhytmBes: Punktierte Viertel, Unisono', 1, 'Ganze, Halbe, Punktierte Viertel, Viertel, Achtel', 'Unterstufe 2'),
(33, 39, '-', 'a-moll / A-Dur', '3/4', '(keine)', '150', '', '1', 'Détaché, Legato, Abgesetzte Stricharten', 'nein', '\"aus \"\"Tafelmusik\"\", Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Punktierte Viertel, DynamBes: Echo, Crescendo\"', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(34, 40, '-', 'G-Dur', '3/4', '(keine)', '90', '', '1', 'Détaché, Gebundene Achtel, Angesetzte Bindungen', 'nein', 'Übung: Doppelklänge, leichte, Ensemblespiel, MelodBes: Dreiklänge, Doppelklänge', 1, 'Punktierte Halbe, Halbe, Viertel, Achtel', 'Unterstufe 2'),
(35, 41, '-', 'G-Dur', '3/4', '(keine)', '90', '', '1', 'Détaché, Gebundene Achtel', 'nein', 'Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakte, verschiedenartige, Unisono', 1, 'Punktierte Halbe, Halbe, Viertel, Achtel, Viertelpause', 'Unterstufe 2'),
(36, 42, '-', 'd-moll', '4/4', '(keine)', '120', '', '1', 'Détaché', 'nein', 'Für Cello schwieriger, Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Auftakt, Punktierte Viertel', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(37, 43, '-', 'F-Dur', '6/4', '(keine)', '120', '', '1', 'Détaché, Legato', 'nein', 'Herkunft: Aus der Röhn, Übung: Ensemblespiel, MelodBes: Vorzeichen, zusätzliche, RhytmBes: Punktierte Viertel', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(38, 44, '-', 'D-Dur / B-Dur', '3/4', '(keine)', '400', '4', '1,3', 'Détaché, Gebundene Achtel,Spiccato,Martélé', 'nein', 'Übung: Stricharten-Vielfalt,Tonarten,weit entfernte, MelodBes: Triller, DynamBes: Sforzato', 1, '(verschiedene)', 'Untere Mittelstufe 2'),
(39, 45, '-', 'C-Dur', '2/4', 'Moderato', '150', '4 / 5', '1,3', 'Détaché, Legato, Angesetzte Bindungen', 'nein', 'Übung: Lyrisches Spiel mit rhytmischer Vielfalt, RhytmBes: vielfältig,Punktierungen,viele', 1, '(verschiedene)', 'Untere Mittelstufe 2'),
(40, 46, '-', 'D-Dur', '4/4', 'Bright and sunny', '100', '3', '1', 'Détaché', 'nein', 'Traditional from Jamaica, Übung: Ensemblespiel, Exotische Rhytmen, RhytmBes: Calypso Rhythmus', 1, 'Viertel, Punktierte Viertel, Achtel, Ganze Pausen, Halbe Pausen, Viertelpausen', 'Unterstufe 2'),
(41, 47, '-', 'D-Dur', '3/4', 'Like a gentle Waltz', '80', '', '1', 'Détaché, Legato', 'nein', 'Punktierte Viertel / Letato nur in der ersten Stimme, Traditional, from Trinidad and Tobago, Übung: Ensemblespiel', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel, Halbe Pausen, Viertel Pausen', 'Unterstufe 2'),
(42, 48, '-', 'G-Dur', '4/4', 'Not too fast', '120', '', '1', 'Détaché', 'nein', 'Traditional, from the Bahamas, Übung: Ensemblespiel, Exotische Rhytmen,Wechel zwischen ganz lagen und kurzen Notenwerten', 1, 'Punktierte Ganze, Ganze, Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Ganze Pausen, Halbe Pausen, Viertel Pausen', 'Unterstufe 2'),
(43, 49, '-', 'G-Dur', '4/4', 'In calypso style', '80', '', '', 'Détaché, Pizzicato', 'nein', 'Traditional, from the West Indies, Übung: Ensemblespiel, Exotische Rhytmen, RhytmBes: Calypso Rhythmus', 1, 'Ganze, Punktierte Halbe, Halbe, Punktierte Viertel, Achtel, Ganze Pause, Halbe Pausen, Viertel Pausen', 'Unterstufe 2'),
(44, 50, '-', 'a-moll', '4/4', 'Poco Allegretto', '70', '', '1', 'Détaché, Legato', 'nein', 'Oberstimme bewegt, Unterstimmen ruhig, Synkopen in der Oberstimme, 3. Stimme im Violinschlüssel (oktaviert), Übung: Ensemblespiel, RhytmBes: Synkopen, Fermaten', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(45, 51, '-', 'D-Dur', '3/4', 'Quasi allegro', '50', '', '1', 'Détaché, Legato, Angesetzte Bindungen', 'nein', 'Stimmen z.T. zweistimmig, Übung: Ensemblespiel, DynamBes: Fortissimo (alles)', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(46, 52, '-', 'd-moll', '2/4, 3/4', 'Très lent', '100', '', '1', 'Détaché, Legato, Portato', 'nein', 'Viele Taktwechsel!, Übung: Ensemblespiel, Taktwechsel, RhytmBes: Fermaten, Taktwechsel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(47, 53, '-', 'C-Dur', '4/4', 'Maestoso', '110', '', '1', 'Détaché, Angesetzte Bindungen, Legato', 'nein', 'Übung: Ensemblespiel, RhytmBes: Fermaten, DynamBes: Dynamische Kontraste', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(48, 54, '-', 'd-moll', '2/4', 'Maestoso', '100', '', '1', 'Détaché, Angesetzte Bindungen, Legato', 'nein', 'Stimmen manchmal zweigeteilt, Übung: Ensemblespiel, RhytmBes: Punktierte Sechzehntel, Zweiunddreißigstel, DynamBes: Dynamische Kontraste', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(49, 55, '-', 'd-moll', '6/8', 'Andantino', '120', '', '1', 'Détaché, Portato, Portato', 'nein', 'Oberstimme z.T. bewegter, Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(50, 56, '-', 'D-Dur', '3/4', 'Andantino poco allegretto', '60', '', '1', 'Détaché, Legato', 'nein', 'Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(51, 57, '-', 'g-moll', '3/4', 'Molto moderato', '100', '', '1', 'Détaché, Legato', 'nein', '3. Stimme z.T. solistisch, Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(52, 58, '-', 'G-Dur', '3/4', 'Allegretto', '75', '', '1', 'Détaché, Legato', 'nein', 'Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(53, 59, '-', 'g-moll', '3/4', 'Poco lento', '75', '', '1', 'Détaché, Legato', 'nein', 'Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(54, 60, '-', 'G-Dur', '3/4', 'Poco Allegretto', '75', '', '1', 'Détaché, Legato, Martélé, breites', 'nein', 'Übung: Ensemblespiel, RhytmBes: Synkopen', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(55, 61, '-', 'g-moll, G-Dur', '3/8', 'Quasi allegro', '60', '', '1', 'Détaché, Legato, Portato', 'nein', '3. Stimme bewegter, Tempowechsel, Übung: Ensemblespiel', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(56, 62, '-', 'G-Dur', '4/4', 'Allegro', '50', '', '1', 'Détaché, Legato, Martélé', 'nein', 'Violastimme auch als dritte Violine vorhanden, Cellostimme = Kontrabaßstimme, Übung: Ensemblespiel, RhytmBes: Synkopen, Shuffle', 1, '(verschiedene)', 'Untere Mittelstufe 1'),
(57, 63, '-', 'G-Dur', '4/4', 'Vivace', '50', '', '1', 'Détaché, Legato, Angesetzte Bindungen', 'nein', 'Oberstimmen sehr bewegt, Baßstimme einfach, Übung: Ensemblespiel, RhytmBes: Synkopen, Shuffle, Triolen,-Viertel', 1, '(verschiedene)', 'Untere Mittelstufe 2'),
(58, 64, '-', 'a-moll / A-Dur', 'diverse', 'diverse', '600', '4 / 5', 'diverse', 'Akkorde, Legato, Détaché, Staccato, Saltando (Ricochet), Akzente', 'ja, sehr gut', 'Übung: diverse, RhytmBes: (sehr vielfältig)', 1, '(verschiedene)', 'Oberstufe 1'),
(59, 65, 'Morgenstimmung', 'E-Dur', '6/8', 'Allegretto pastorale', '', '', 'diverse', 'Legato, Pizzicato', 'ja, sehr gut', 'Schauspiel-Musik', 1, '', 'Oberstufe 2/Mittelstufe 2'),
(60, 65, 'Ases Tod', 'h-moll', '4/4', 'Andante doloroso', '', '', '', 'Legato', 'ja, sehr gut', 'Schauspiel-Musik', 2, '', 'Oberstufe 2/Mittelstufe 2'),
(62, 65, 'Anitras Tanz', 'C-Dur', '3/4', 'Tempo di Mazurka', '', '', '', 'Spiccato, Pizzicato, Legato', 'ja, sehr gut', 'Schauspiel-Musik', 3, '', 'Oberstufe 2/Mittelstufe 2'),
(63, 65, 'Tanz in der Halle des Bergkönigs', 'h-moll', '4/4', 'Alla marcia e molto marcato', '', '', '', 'Pizzicato, Repetitionen', 'ja, sehr gut', 'Schauspiel-Musik', 4, '', 'Oberstufe 2/Mittelstufe 2'),
(64, 66, '-', 'F-Dur', '4/4,3/4', '(keine)', '300', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Variation, Auch einzeln spielbar, RhytmBes: Auftakt, Punktierte Viertel', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(65, 67, '-', 'd-moll/D-Dur', 'alla breve,3/4', '(keine)', '300', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Variation, Auch einzeln spielbar, RhytmBes: Punktierte Viertel, DynamBes: Echo', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel,Punkierte Halbe, Ganze', 'Untere Mittelstufe 1'),
(66, 68, '-', 'a-moll', '4/4', 'Allegro', '120', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Übung: Intervall, RhytmBes: Auftakt, Punktierte Viertel', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(67, 69, '-', 'e-moll', '3/4', 'Largo', '120', '3', '1', 'XXX', 'nein', 'Bezifferter Bass, Übung: Bogeneinteilung, RhytmBes: Punktierte Viertel', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel,Punkierte Halbe, Ganze', 'Untere Mittelstufe 1'),
(68, 70, '-', 'B-Dur', '3/4', '(keine)', '240', '3', '1', 'Abgesetzte Stricharten, Angesetzte Bindungen,Legato', 'nein', 'Bezifferter Bass, Übung: diverse, RhytmBes: Punktierte Achtel mit Sechzehntel,Triolen', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Sechzehntel, Punktierte Achtel, Achteltriolen', 'Untere Mittelstufe 1'),
(69, 71, '-', 'g-moll', '4/4', 'Allegro', '180', '2', '1', 'Détaché, Abgesetzte Stricharten, Bindungen', 'nein', 'Übung: Bogen zurückholen, RhytmBes: Viele Viertelpausen', 1, 'Viertel, Achtel', 'Untere Mittelstufe 1'),
(70, 72, 'Symphonie', 'g-moll', '4/4', 'Adagio', '180', '3', '1', 'Détaché, Legato, Betonungen', 'nein', 'Übung: Legato-Spiel, Betonungen, MelodBes: Vergrößerung, RhytmBes: Punktierte Viertel, Viertelpausen', 1, 'Halbe, Punktierte Viertel, Viertel, Achtel,Punkierte Halbe, Ganze, Viertelpausen', 'Untere Mittelstufe 1'),
(71, 72, 'Minuett', 'g-moll', '3/4', '(keine)', '180', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Bezifferter Bass, RhytmBes: Punktierte Viertel,', 2, 'Punktierte Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(72, 72, 'Gavotte', 'g-moll', 'alla breve', '(keine)', '150', '2', '1', 'Legato, Abgesetzte Stricharten, Angesetzte Bindungen', 'nein', 'Übung: Doppelschlag, Triller, RhytmBes: Punktierte Viertel, ', 3, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(73, 72, 'Hornpipe', 'g-moll', '3/2', '(keine)', '150', '1', '1', 'Détaché, Abgesetzte Stricharten, Betonungen', 'nein', 'Übung: 3/2 - Takt mit Synkope, Pralltriller, Betonungen', 4, 'Halbe, Punktierte Viertel, Viertel, Achtel', 'Untere Mittelstufe 1'),
(74, 72, 'Jigg', 'g-moll', '6/8', '(keine)', '150', '3', '1', 'Détaché, Abgesetzte Stricharten, ', 'nein', 'Übung: Verschiedene Stricharten möglich, Triller, MelodBes: Sequenz, Triller, RhytmBes: Punkte Achtel mit Sechzehntel', 5, 'Viertel,Punkte Achtel, Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(75, 73, '-', 'G-Dur', '4/4', '(keine)', '150', '2', '1', 'Détaché, Abgesetzte Stricharten, Legato,', 'nein', 'Übung: Sechzehntel mit Punktierter Achtel gebunden, Pralltriller', 1, 'Halbe, Punktierte Viertel, Viertel, Punktierte Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(76, 74, '-', 'G-Dur', '3/4', '(Vivace)', '240', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen, Legato,', 'nein', 'Triller, Bezifferter Bass', 1, 'Punktierte Halbe, Halbe, Punktierte Viertel, Viertel, Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(77, 75, '-', 'A-Dur', '6/8', '', '240', '3', '1', 'Détaché, Legato,  Angesetzte Bindungen, Spiccato', 'nein', 'Bezifferter Bass, Haltebogen, Triller', 1, 'Punktierte Viertel, Viertel, Achtel, ', 'Untere Mittelstufe 1'),
(78, 76, '-', 'd-moll', '4/4', 'Allegro', '150', '2', '1', 'Abgesetzte Stricharten, Legato schwer-leicht, ', 'nein', 'Legato schwer-leicht, ', 1, 'Viertel, Achtel', 'Untere Mittelstufe 1'),
(79, 77, '-', 'A-Dur', '2/4', 'Vivace', '180', '3', '1', 'Détaché, Abgesetzte Stricharten, Legato', 'nein', 'Lange Vorschläge, Triller mit Nachschlag, Komplementärrhytmen', 1, 'Punktierte Viertel, Viertel, Achtel, Sechzehntel', 'Untere Mittelstufe 1'),
(80, 78, '-', 'a-moll', '3/4', 'Allegro', '180', '3', '1', 'Détaché, Abgesetzte Stricharten, Angesetzte Bindungen, ', 'nein', 'Triller, Sechzehntel Auftakt', 1, 'Halbe, Punktierte Viertel, Sechzehntel,Achtel, Sechzehntel Auftakt', 'Untere Mittelstufe 1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `TEST`
--

CREATE TABLE `TEST` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(50) NOT NULL,
  `test_date` datetime NOT NULL,
  `test_desc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `TEST`
--

INSERT INTO `TEST` (`test_id`, `test_name`, `test_date`, `test_desc`) VALUES
(1, 'Test1', '2024-01-19 20:11:46', 'Erster Test '),
(2, 'Test 2', '2024-01-19 20:23:39', 'Test 2'),
(3, 'asdf', '0000-00-00 00:00:00', 'asdfasdff'),
(4, 'vier', '0000-00-00 00:00:00', 'vier vier'),
(5, 'sdfsdf', '0000-00-00 00:00:00', 'asdfsadfsadfdsaf'),
(6, 'sdfsdf', '0000-00-00 00:00:00', 'asdfsadfsadfdsaf'),
(7, 'sdlf', '0000-00-00 00:00:00', 'asdfsadf'),
(8, 'test8', '0000-00-00 00:00:00', ''),
(9, 'ASDF', '0000-00-00 00:00:00', ''),
(10, 'sldkfj', '0000-00-00 00:00:00', ''),
(11, 'slkjflsfkj', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Verlag`
--

CREATE TABLE `Verlag` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(27) DEFAULT NULL,
  `Bemerkung` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Verlag`
--

INSERT INTO `Verlag` (`ID`, `Name`, `Bemerkung`) VALUES
(1, 'Musikverlag Wilhelm Halter', 'Karlsruhe West'),
(7, 'Schott Verlag', ''),
(8, 'Bärenreiter', ''),
(9, 'Boosey & Hawkes', ''),
(10, 'Möseler Verlag Wolfenbüttel', ''),
(11, 'Bosworth Edition', ''),
(12, '', ''),
(13, 'Edition Peters', ''),
(14, 'Eulenburg', ''),
(15, 'Testverlag', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Komponist`
--
ALTER TABLE `Komponist`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Musikstueck`
--
ALTER TABLE `Musikstueck`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Sammlung`
--
ALTER TABLE `Sammlung`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Satz`
--
ALTER TABLE `Satz`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `TEST`
--
ALTER TABLE `TEST`
  ADD PRIMARY KEY (`test_id`);

--
-- Indizes für die Tabelle `Verlag`
--
ALTER TABLE `Verlag`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Komponist`
--
ALTER TABLE `Komponist`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `Musikstueck`
--
ALTER TABLE `Musikstueck`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT für Tabelle `Sammlung`
--
ALTER TABLE `Sammlung`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `Satz`
--
ALTER TABLE `Satz`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT für Tabelle `TEST`
--
ALTER TABLE `TEST`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `Verlag`
--
ALTER TABLE `Verlag`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

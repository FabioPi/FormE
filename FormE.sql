-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 62.149.150.60
-- Generato il: Set 27, 2017 alle 08:08
-- Versione del server: 5.0.92
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Sql111380_5`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Anagrafica`
--

CREATE TABLE IF NOT EXISTS `Anagrafica` (
  `ANAId` int(11) unsigned NOT NULL auto_increment,
  `ANANome` varchar(50) default NULL,
  `ANACogno` varchar(50) default NULL,
  `ANADtNasc` date default NULL,
  `ANAPhone` varchar(20) default NULL,
  `ANAMobile` varchar(20) default NULL,
  `ANAEMail` varchar(30) default NULL,
  `COId` int(10) unsigned default NULL,
  `STId` int(11) unsigned default NULL,
  `CTId` int(11) unsigned default NULL,
  `DUGId` int(11) unsigned default NULL,
  `ANAVia` varchar(50) default NULL,
  `ANAIp` varchar(30) default NULL,
  `ANATipo` char(2) default NULL,
  `ANAlpENG` tinyint(1) unsigned default NULL,
  `ANAlpESP` tinyint(1) unsigned default NULL,
  `ANAAvatar` longblob,
  `ANAAvatar2` longtext,
  `ANANote` mediumtext,
  `ANAmuRock` varchar(5) default NULL,
  `ANAmuDisco` varchar(5) default NULL,
  `ANAmuClas` varchar(5) default NULL,
  `ANADtIscr` date default NULL,
  `ANAInteressi` varchar(50) default NULL,
  `ANAMap` varchar(50) default NULL,
  `ANASearch` varchar(50) default NULL,
  `linkFile1` varchar(100) default NULL,
  `linkFile2` varchar(100) default NULL,
  PRIMARY KEY  (`ANAId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `Anagrafica`
--

INSERT INTO `Anagrafica` (`ANAId`, `ANANome`, `ANACogno`, `ANADtNasc`, `ANAPhone`, `ANAMobile`, `ANAEMail`, `COId`, `STId`, `CTId`, `DUGId`, `ANAVia`, `ANAIp`, `ANATipo`, `ANAlpENG`, `ANAlpESP`, `ANAAvatar`, `ANAAvatar2`, `ANANote`, `ANAmuRock`, `ANAmuDisco`, `ANAmuClas`, `ANADtIscr`, `ANAInteressi`, `ANAMap`, `ANASearch`, `linkFile1`, `linkFile2`) VALUES
(1, 'Mario', 'Rossetti1', '1987-06-01', '(+39) 06 9999999', '(+39) 321 7778777', 'aaaaaa@aaa.co', 1, 110, 3, 18, 'vicente espinel, 1', '10.0.0.15-10.0.1.12', 'AM', 1, 0, NULL, 'data:image/jpeg;base64,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', 'Hello !!\r\n\r\na: aà   e: eèé    i:  iì  o: oò  u: uù\r\n\r\n{["....''-----''...."]}\r\n\r\nend\r\n333\r\n', 'Rock', 'Disco', 'ccc', '2017-06-22', '2;6', '43.7823715209961;11.2549896240234', 'Macedonia', 'Upload/tucano.bmp', 'upload2/EtaBeta.jpg                         '),
(3, 'Carlo', 'Verdi', '1998-12-01', NULL, NULL, NULL, 1, 83, 0, 0, '', '192.168.178.1-192.168.178.11', 'AM', 0, 1, NULL, '', '', '', 'Disco', 'Class', '2017-09-12', '2;1', '51.202465057373;10.3822031021118', '', 'Upload/Devices-scanner-icon.png ', '  '),
(2, 'Giacomo', 'Gundam', '1980-05-12', '(+)  45566666', '(+44) 555 5', 'g.bbbb@email.it', 2, 41, 0, 0, '', '10.10.10.1-10.10.10.45', 'AS', 1, 0, NULL, '', 'Nello !!!', '', '', 'Class', '2017-09-09', '2;6', '38.0315551757813;-78.5051651000977', NULL, ' ', ' ');

-- --------------------------------------------------------

--
-- Struttura della tabella `Citta`
--

CREATE TABLE IF NOT EXISTS `Citta` (
  `CTId` int(10) unsigned NOT NULL auto_increment,
  `STId` int(10) unsigned NOT NULL,
  `CTDescr` varchar(50) NOT NULL,
  PRIMARY KEY  (`CTId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dump dei dati per la tabella `Citta`
--

INSERT INTO `Citta` (`CTId`, `STId`, `CTDescr`) VALUES
(1, 110, 'Roma'),
(2, 110, 'Caserta'),
(3, 110, 'Firenze'),
(4, 110, 'Lecce'),
(5, 110, 'Agrigento'),
(6, 56, 'Havana'),
(7, 56, 'Cienfuegos'),
(8, 56, 'Santa Clara'),
(9, 56, 'Holguin'),
(10, 56, 'Trinidad'),
(11, 56, 'Barracoa'),
(12, 56, 'Sancti Spiritu'),
(13, 56, 'Santiago di Cuba'),
(14, 209, 'Madrid'),
(15, 209, 'Toledo'),
(16, 209, 'Malaga'),
(17, 178, 'Lisbona'),
(18, 178, 'Porto'),
(19, 236, 'New York'),
(20, 236, 'Los Angeles'),
(21, 236, 'San Francisco'),
(22, 10, 'Buenos Aires'),
(23, 10, 'Cordoba'),
(24, 10, 'San Luis'),
(25, 27, 'La Paz'),
(26, 27, 'Sucre');

-- --------------------------------------------------------

--
-- Struttura della tabella `Continenti`
--

CREATE TABLE IF NOT EXISTS `Continenti` (
  `COId` int(10) NOT NULL auto_increment,
  `CODescr` varchar(30) NOT NULL default '0',
  PRIMARY KEY  (`COId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `Continenti`
--

INSERT INTO `Continenti` (`COId`, `CODescr`) VALUES
(1, 'Europa'),
(2, 'America'),
(3, 'Africa'),
(4, 'Asia'),
(5, 'Oceania');

-- --------------------------------------------------------

--
-- Struttura della tabella `Dug`
--

CREATE TABLE IF NOT EXISTS `Dug` (
  `DUGId` int(10) unsigned NOT NULL auto_increment,
  `DUGDescr` varchar(30) default NULL,
  PRIMARY KEY  (`DUGId`),
  UNIQUE KEY `DUGDescr` (`DUGDescr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dump dei dati per la tabella `Dug`
--

INSERT INTO `Dug` (`DUGId`, `DUGDescr`) VALUES
(17, 'Calle'),
(4, 'Circonvallazione... '),
(5, 'Clivio'),
(6, 'Complanare'),
(7, 'Discesa'),
(8, 'Frazione'),
(11, 'Isola'),
(3, 'Largo'),
(9, 'Lido'),
(10, 'Litoranea'),
(12, 'Lungomare'),
(13, 'Molo'),
(15, 'Parallalela'),
(14, 'Passeggiata'),
(2, 'Piazza'),
(18, 'Piazzale'),
(1, 'Via'),
(16, 'Viale');

-- --------------------------------------------------------

--
-- Struttura della tabella `Interessi`
--

CREATE TABLE IF NOT EXISTS `Interessi` (
  `INTId` int(10) unsigned NOT NULL auto_increment,
  `INTDescr` varchar(30) NOT NULL default '0',
  PRIMARY KEY  (`INTId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `Interessi`
--

INSERT INTO `Interessi` (`INTId`, `INTDescr`) VALUES
(1, 'Sport'),
(2, 'Cinema'),
(3, 'Teatro'),
(4, 'Ballo'),
(5, 'Viaggi'),
(6, 'Leggere');

-- --------------------------------------------------------

--
-- Struttura della tabella `levela`
--

CREATE TABLE IF NOT EXISTS `levela` (
  `AId` int(11) NOT NULL auto_increment,
  `ADescr` varchar(20) default NULL,
  PRIMARY KEY  (`AId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `levela`
--

INSERT INTO `levela` (`AId`, `ADescr`) VALUES
(1, 'Level A1'),
(2, 'Level A2'),
(3, 'Level A3');

-- --------------------------------------------------------

--
-- Struttura della tabella `levelb`
--

CREATE TABLE IF NOT EXISTS `levelb` (
  `BId` int(11) NOT NULL auto_increment,
  `AId` int(11) default NULL,
  `BDescr` varchar(20) default NULL,
  PRIMARY KEY  (`BId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `levelb`
--

INSERT INTO `levelb` (`BId`, `AId`, `BDescr`) VALUES
(1, 1, 'Level B1'),
(2, 1, 'Level B2'),
(3, 2, 'Level B3'),
(4, 2, 'Level B4');

-- --------------------------------------------------------

--
-- Struttura della tabella `levelc`
--

CREATE TABLE IF NOT EXISTS `levelc` (
  `CId` int(11) NOT NULL auto_increment,
  `BId` int(11) default NULL,
  `CDescr` varchar(20) default NULL,
  PRIMARY KEY  (`CId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `levelc`
--

INSERT INTO `levelc` (`CId`, `BId`, `CDescr`) VALUES
(1, 1, 'Level C1'),
(2, 1, 'Level C2'),
(3, 2, 'Level C3'),
(4, 2, 'Level C4');

-- --------------------------------------------------------

--
-- Struttura della tabella `leveld`
--

CREATE TABLE IF NOT EXISTS `leveld` (
  `DId` int(11) NOT NULL auto_increment,
  `CId` int(11) default NULL,
  `DDescr` varchar(20) default NULL,
  PRIMARY KEY  (`DId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `leveld`
--

INSERT INTO `leveld` (`DId`, `CId`, `DDescr`) VALUES
(1, 1, 'Level D1'),
(2, 1, 'Level D2'),
(3, 2, 'Level D3'),
(4, 2, 'Level D4');

-- --------------------------------------------------------

--
-- Struttura della tabella `levele`
--

CREATE TABLE IF NOT EXISTS `levele` (
  `EId` int(11) NOT NULL auto_increment,
  `DId` int(11) default NULL,
  `EDescr` varchar(20) default NULL,
  PRIMARY KEY  (`EId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `levele`
--

INSERT INTO `levele` (`EId`, `DId`, `EDescr`) VALUES
(1, 1, 'Level E1'),
(2, 1, 'Level E2'),
(3, 2, 'Level E3'),
(4, 2, 'Level E4');

-- --------------------------------------------------------

--
-- Struttura della tabella `Stato`
--

CREATE TABLE IF NOT EXISTS `Stato` (
  `STId` int(10) unsigned NOT NULL auto_increment,
  `COId` int(10) unsigned NOT NULL,
  `STDescr` varchar(50) default NULL,
  `STFlag` varchar(50) default NULL,
  PRIMARY KEY  (`STId`),
  KEY `STDescr` (`STDescr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;

--
-- Dump dei dati per la tabella `Stato`
--

INSERT INTO `Stato` (`STId`, `COId`, `STDescr`, `STFlag`) VALUES
(1, 4, 'Afghanistan\r', 'flag_afghanistan.png'),
(3, 1, 'Albania\r', 'flag_albania.png'),
(4, 9999, 'Algeria\r', 'flag_algeria.png'),
(5, 9999, 'American_Samoa\r', 'flag_american_samoa.png'),
(6, 1, 'Andorra\r', 'flag_andorra.png'),
(7, 9999, 'Angola\r', 'flag_angola.png'),
(8, 9999, 'Anguilla\r', 'flag_anguilla.png'),
(9, 9999, 'Antigua_And_Barbuda\r', 'flag_antigua_and_barbuda.png'),
(10, 2, 'Argentina\r', 'flag_argentina.png'),
(11, 4, 'Armenia\r', 'flag_armenia.png'),
(12, 9999, 'Aruba\r', 'flag_aruba.png'),
(13, 5, 'Australia\r', 'flag_australia.png'),
(14, 1, 'Austria\r', 'flag_austria.png'),
(15, 9999, 'Azerbaijan\r', 'flag_azerbaijan.png'),
(16, 9999, 'Bahamas\r', 'flag_bahamas.png'),
(17, 9999, 'Bahrain\r', 'flag_bahrain.png'),
(18, 4, 'Bangladesh\r', 'flag_bangladesh.png'),
(19, 9999, 'Barbados\r', 'flag_barbados.png'),
(20, 9999, 'Belarus\r', 'flag_belarus.png'),
(21, 1, 'Belgium\r', 'flag_belgium.png'),
(22, 9999, 'Belize\r', 'flag_belize.png'),
(23, 9999, 'Benin\r', 'flag_benin.png'),
(24, 9999, 'Bermuda\r', 'flag_bermuda.png'),
(25, 9999, 'Bhutan\r', 'flag_bhutan.png'),
(27, 2, 'Bolivia\r', 'flag_bolivia.png'),
(28, 9999, 'Bosnia\r', 'flag_bosnia.png'),
(29, 3, 'Botswana\r', 'flag_botswana.png'),
(31, 9999, 'Brazil\r', 'flag_brazil.png'),
(32, 9999, 'British_Indian_Ocean\r', 'flag_british_indian_ocean.png'),
(33, 9999, 'British_Virgin_Islands\r', 'flag_british_virgin_islands.png'),
(34, 4, 'Brunei\r', 'flag_brunei.png'),
(35, 9999, 'Bulgaria\r', 'flag_bulgaria.png'),
(36, 9999, 'Burkina_Faso\r', 'flag_burkina_faso.png'),
(37, 9999, 'Burma\r', 'flag_burma.png'),
(38, 9999, 'Burundi\r', 'flag_burundi.png'),
(39, 9999, 'Cambodia\r', 'flag_cambodia.png'),
(40, 9999, 'Cameroon\r', 'flag_cameroon.png'),
(41, 2, 'Canada\n', 'flag_canada.png'),
(42, 9999, 'Cayman_Islands\r', 'flag_cayman_islands.png'),
(43, 3, 'Central_African_Republic\r', 'flag_central_african_republic.png'),
(44, 9999, 'Chad\r', 'flag_chad.png'),
(45, 2, 'Chile\r', 'flag_chile.png'),
(46, 4, 'China\r', 'flag_china.png'),
(47, 2, 'Colombia\r', 'flag_colombia.png'),
(48, 9999, 'Comoros\r', 'flag_comoros.png'),
(49, 3, 'Congo_Democratic_Republic\r', 'flag_congo_democratic_republic.png'),
(50, 3, 'Congo_Republic\r', 'flag_congo_republic.png'),
(51, 9999, 'Cook_Islands\r', 'flag_cook_islands.png'),
(52, 9999, 'Cope_Verde\r', 'flag_cope_verde.png'),
(53, 2, 'Costa_Rica\r', 'flag_costa_rica.png'),
(54, 9999, 'Cote_Divoire\r', 'flag_cote_divoire.png'),
(55, 1, 'Croatia\r', 'flag_croatia.png'),
(56, 2, 'Cuba\r', 'flag_cuba.png'),
(57, 1, 'Cyprus\r', 'flag_cyprus.png'),
(58, 1, 'Czech_Republic\r', 'flag_czech_republic.png'),
(59, 1, 'Denmark\r', 'flag_denmark.png'),
(60, 9999, 'Djibouti\r', 'flag_djibouti.png'),
(61, 9999, 'Dominica\r', 'flag_dominica.png'),
(62, 9999, 'Dominican_Republic\r', 'flag_dominican_republic.png'),
(63, 9999, 'East_Timor\r', 'flag_east_timor.png'),
(64, 3, 'Egypt\r', 'flag_egypt.png'),
(65, 9999, 'El_Salvador\r', 'flag_el_salvador.png'),
(66, 9999, 'England\r', 'flag_england.png'),
(67, 9999, 'Equador\r', 'flag_equador.png'),
(68, 9999, 'Equatorial_Guinea\r', 'flag_equatorial_guinea.png'),
(69, 3, 'Eritrea\r', 'flag_eritrea.png'),
(70, 9999, 'Estonia\r', 'flag_estonia.png'),
(71, 3, 'Ethiopia\r', 'flag_ethiopia.png'),
(72, 9999, 'European_Union\r', 'flag_european_union.png'),
(73, 9999, 'Falkland_Islands\r', 'flag_falkland_islands.png'),
(74, 9999, 'Faroe_Islands\r', 'flag_faroe_islands.png'),
(75, 9999, 'Fiji\r', 'flag_fiji.png'),
(76, 9999, 'Finish\r', 'flag_finish.png'),
(77, 9999, 'Finland\r', 'flag_finland.png'),
(78, 9999, 'France\r', 'flag_france.png'),
(79, 9999, 'French_Polynesia\r', 'flag_french_polynesia.png'),
(80, 3, 'Gabon\r', 'flag_gabon.png'),
(81, 3, 'Gambia\r', 'flag_gambia.png'),
(82, 9999, 'Georgia\r', 'flag_georgia.png'),
(83, 1, 'Germany\r', 'flag_germany.png'),
(84, 3, 'Ghana\r', 'flag_ghana.png'),
(85, 1, 'Gibraltar\r', 'flag_gibraltar.png'),
(86, 1, 'Great_Britain\r', 'flag_great_britain.png'),
(87, 1, 'Greece\r', 'flag_greece.png'),
(89, 9999, 'Greenland\r', 'flag_greenland.png'),
(90, 9999, 'Grenada\r', 'flag_grenada.png'),
(91, 9999, 'Guam\r', 'flag_guam.png'),
(92, 9999, 'Guatemala\r', 'flag_guatemala.png'),
(93, 9999, 'Guernsey\r', 'flag_guernsey.png'),
(94, 9999, 'Guinea\r', 'flag_guinea.png'),
(95, 9999, 'Guinea_Bissau\r', 'flag_guinea_bissau.png'),
(96, 9999, 'Guyana\r', 'flag_guyana.png'),
(97, 9999, 'Haiti\r', 'flag_haiti.png'),
(98, 9999, 'Honduras\r', 'flag_honduras.png'),
(99, 9999, 'Hong_Kong\r', 'flag_hong_kong.png'),
(100, 9999, 'Hot\r', 'flag_hot.png'),
(101, 9999, 'Hungary\r', 'flag_hungary.png'),
(102, 9999, 'Iceland\r', 'flag_iceland.png'),
(103, 4, 'India\r', 'flag_india.png'),
(104, 9999, 'Indonesia\r', 'flag_indonesia.png'),
(105, 4, 'Iran\r', 'flag_iran.png'),
(106, 4, 'Iraq\r', 'flag_iraq.png'),
(107, 9999, 'Ireland\r', 'flag_ireland.png'),
(108, 9999, 'Isle_Of_Man\r', 'flag_isle_of_man.png'),
(109, 4, 'Israel\r', 'flag_israel.png'),
(110, 1, 'Italy\r', 'flag_italy.png'),
(111, 9999, 'Jamaica\r', 'flag_jamaica.png'),
(112, 9999, 'Japan\r', 'flag_japan.png'),
(113, 9999, 'Jersey\r', 'flag_jersey.png'),
(114, 9999, 'Jordan\r', 'flag_jordan.png'),
(115, 9999, 'Kazakhstan\r', 'flag_kazakhstan.png'),
(116, 9999, 'Kenya\r', 'flag_kenya.png'),
(117, 9999, 'Kiribati\r', 'flag_kiribati.png'),
(118, 9999, 'Kuwait\r', 'flag_kuwait.png'),
(119, 9999, 'Kyrgyzstan\r', 'flag_kyrgyzstan.png'),
(120, 9999, 'Laos\r', 'flag_laos.png'),
(121, 9999, 'Latvia\r', 'flag_latvia.png'),
(122, 9999, 'Lebanon\r', 'flag_lebanon.png'),
(123, 9999, 'Lesotho\r', 'flag_lesotho.png'),
(124, 9999, 'Liberia\r', 'flag_liberia.png'),
(125, 9999, 'Libya\r', 'flag_libya.png'),
(126, 9999, 'Liechtenstein\r', 'flag_liechtenstein.png'),
(127, 9999, 'Lithuania\r', 'flag_lithuania.png'),
(128, 9999, 'Luxembourg\r', 'flag_luxembourg.png'),
(129, 9999, 'Macau\r', 'flag_macau.png'),
(130, 9999, 'Macedonia\r', 'flag_macedonia.png'),
(131, 9999, 'Madagascar\r', 'flag_madagascar.png'),
(132, 9999, 'Malawi\r', 'flag_malawi.png'),
(133, 9999, 'Malaysia\r', 'flag_malaysia.png'),
(134, 9999, 'Maledives\r', 'flag_maledives.png'),
(135, 9999, 'Mali\r', 'flag_mali.png'),
(136, 9999, 'Malta\r', 'flag_malta.png'),
(137, 9999, 'Marshall_Islands\r', 'flag_marshall_islands.png'),
(138, 9999, 'Martinique\r', 'flag_martinique.png'),
(139, 9999, 'Mauretania\r', 'flag_mauretania.png'),
(140, 9999, 'Mauritius\r', 'flag_mauritius.png'),
(141, 9999, 'Mexico\r', 'flag_mexico.png'),
(142, 9999, 'Micronesia\r', 'flag_micronesia.png'),
(143, 9999, 'Moldova\r', 'flag_moldova.png'),
(144, 9999, 'Monaco\r', 'flag_monaco.png'),
(145, 9999, 'Mongolia\r', 'flag_mongolia.png'),
(146, 9999, 'Montserrat\r', 'flag_montserrat.png'),
(147, 9999, 'Morocco\r', 'flag_morocco.png'),
(148, 9999, 'Mozambique\r', 'flag_mozambique.png'),
(149, 9999, 'Namibia\r', 'flag_namibia.png'),
(150, 9999, 'Nato\r', 'flag_nato.png'),
(151, 9999, 'Nauru\r', 'flag_nauru.png'),
(152, 9999, 'Nepal\r', 'flag_nepal.png'),
(153, 9999, 'Netherlands\r', 'flag_netherlands.png'),
(154, 9999, 'Netherlands_Antilles\r', 'flag_netherlands_antilles.png'),
(155, 9999, 'New\r', 'flag_new.png'),
(156, 9999, 'New_Zealand\r', 'flag_new_zealand.png'),
(157, 9999, 'Nicaragua\r', 'flag_nicaragua.png'),
(158, 9999, 'Niger\r', 'flag_niger.png'),
(159, 9999, 'Nigeria\r', 'flag_nigeria.png'),
(160, 9999, 'Niue\r', 'flag_niue.png'),
(161, 9999, 'Norfolk_Islands\r', 'flag_norfolk_islands.png'),
(162, 9999, 'Northern_Mariana_Islands\r', 'flag_northern_mariana_islands.png'),
(163, 9999, 'North_Korea\r', 'flag_north_korea.png'),
(164, 9999, 'Norway\r', 'flag_norway.png'),
(165, 9999, 'Olympic\r', 'flag_olympic.png'),
(166, 9999, 'Oman\r', 'flag_oman.png'),
(167, 9999, 'Orange\r', 'flag_orange.png'),
(168, 9999, 'Pakistan\r', 'flag_pakistan.png'),
(169, 9999, 'Palau\r', 'flag_palau.png'),
(170, 9999, 'Panama\r', 'flag_panama.png'),
(171, 9999, 'Papua_New_Guinea\r', 'flag_papua_new_guinea.png'),
(172, 9999, 'Paraquay\r', 'flag_paraquay.png'),
(173, 9999, 'Peru\r', 'flag_peru.png'),
(174, 9999, 'Philippines\r', 'flag_philippines.png'),
(175, 9999, 'Pink\r', 'flag_pink.png'),
(176, 9999, 'Pitcairn_Islands\r', 'flag_pitcairn_islands.png'),
(177, 9999, 'Poland\r', 'flag_poland.png'),
(178, 1, 'Portugal\r', 'flag_portugal.png'),
(179, 9999, 'Puerto_Rico\r', 'flag_puerto_rico.png'),
(180, 9999, 'Purple\r', 'flag_purple.png'),
(181, 9999, 'Qatar\r', 'flag_qatar.png'),
(182, 9999, 'Red\r', 'flag_red.png'),
(183, 9999, 'Red_Cross\r', 'flag_red_cross.png'),
(184, 9999, 'Romania\r', 'flag_romania.png'),
(185, 9999, 'Russia\r', 'flag_russia.png'),
(186, 9999, 'Rwanda\r', 'flag_rwanda.png'),
(187, 9999, 'Saint_Helena\r', 'flag_saint_helena.png'),
(188, 9999, 'Saint_Kitts_And_Nevis\r', 'flag_saint_kitts_and_nevis.png'),
(189, 9999, 'Saint_Lucia\r', 'flag_saint_lucia.png'),
(190, 9999, 'Saint_Pierre_And_Miquelon\r', 'flag_saint_pierre_and_miquelon.png'),
(191, 9999, 'Saint_Vincent_And_Grenadines\r', 'flag_saint_vincent_and_grenadines.png'),
(192, 9999, 'Samoa\r', 'flag_samoa.png'),
(193, 9999, 'San_Marino\r', 'flag_san_marino.png'),
(194, 9999, 'Sao_Tome_And_Principe\r', 'flag_sao_tome_and_principe.png'),
(195, 9999, 'Saudi_Arabia\r', 'flag_saudi_arabia.png'),
(196, 9999, 'Scotland\r', 'flag_scotland.png'),
(197, 9999, 'Senegal\r', 'flag_senegal.png'),
(198, 9999, 'Serbia_Montenegro\r', 'flag_serbia_montenegro.png'),
(199, 9999, 'Seychelles\r', 'flag_seychelles.png'),
(200, 9999, 'Sierra_Leone\r', 'flag_sierra_leone.png'),
(201, 9999, 'Singapore\r', 'flag_singapore.png'),
(202, 9999, 'Slovakia\r', 'flag_slovakia.png'),
(203, 9999, 'Slovenia\r', 'flag_slovenia.png'),
(204, 9999, 'Solomon_Islands\r', 'flag_solomon_islands.png'),
(205, 9999, 'Somalia\r', 'flag_somalia.png'),
(206, 9999, 'South_Africa\r', 'flag_south_africa.png'),
(207, 9999, 'South_Georgia\r', 'flag_south_georgia.png'),
(208, 9999, 'South_Korea\r', 'flag_south_korea.png'),
(209, 1, 'Spain\r', 'flag_spain.png'),
(210, 9999, 'Sri_Lanka\r', 'flag_sri_lanka.png'),
(211, 9999, 'Sudan\r', 'flag_sudan.png'),
(212, 9999, 'Suriname\r', 'flag_suriname.png'),
(213, 9999, 'Swaziland\r', 'flag_swaziland.png'),
(214, 9999, 'Sweden\r', 'flag_sweden.png'),
(215, 9999, 'Switzerland\r', 'flag_switzerland.png'),
(216, 9999, 'Syria\r', 'flag_syria.png'),
(217, 9999, 'Taiwan\r', 'flag_taiwan.png'),
(218, 9999, 'Tajikistan\r', 'flag_tajikistan.png'),
(219, 9999, 'Tanzania\r', 'flag_tanzania.png'),
(220, 9999, 'Thailand\r', 'flag_thailand.png'),
(221, 9999, 'Tibet\r', 'flag_tibet.png'),
(222, 9999, 'Togo\r', 'flag_togo.png'),
(223, 9999, 'Tonga\r', 'flag_tonga.png'),
(224, 9999, 'Trinidad_And_Tobago\r', 'flag_trinidad_and_tobago.png'),
(225, 9999, 'Tunisia\r', 'flag_tunisia.png'),
(226, 9999, 'Turkey\r', 'flag_turkey.png'),
(227, 9999, 'Turkmenistan\r', 'flag_turkmenistan.png'),
(228, 9999, 'Turks_And_Caicos_Islands\r', 'flag_turks_and_caicos_islands.png'),
(229, 9999, 'Tuvalu\r', 'flag_tuvalu.png'),
(230, 9999, 'Uganda\r', 'flag_uganda.png'),
(231, 9999, 'Ukraine\r', 'flag_ukraine.png'),
(232, 9999, 'Unesco\r', 'flag_unesco.png'),
(233, 9999, 'United_Arab_Emirates\r', 'flag_united_arab_emirates.png'),
(234, 9999, 'United_Nations\r', 'flag_united_nations.png'),
(235, 9999, 'Uruquay\r', 'flag_uruquay.png'),
(236, 2, 'Usa\r', 'flag_usa.png'),
(237, 9999, 'Uzbekistan\r', 'flag_uzbekistan.png'),
(238, 9999, 'Vanuatu\r', 'flag_vanuatu.png'),
(239, 9999, 'Vatican_City\r', 'flag_vatican_city.png'),
(240, 9999, 'Venezuela\r', 'flag_venezuela.png'),
(241, 9999, 'Vietnam\r', 'flag_vietnam.png'),
(242, 9999, 'Virgin_Islands\r', 'flag_virgin_islands.png'),
(243, 9999, 'Wales\r', 'flag_wales.png'),
(244, 9999, 'Wallis_And_Futuna\r', 'flag_wallis_and_futuna.png'),
(245, 9999, 'Wto\r', 'flag_wto.png'),
(246, 9999, 'Wwf\r', 'flag_wwf.png'),
(247, 9999, 'Yellow\r', 'flag_yellow.png'),
(248, 9999, 'Yemen\r', 'flag_yemen.png'),
(249, 9999, 'Zambia\r', 'flag_zambia.png'),
(250, 9999, 'Zimbabwe\r', 'flag_zimbabwe.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `testlevels`
--

CREATE TABLE IF NOT EXISTS `testlevels` (
  `TLId` int(10) unsigned NOT NULL auto_increment,
  `LivAId` int(10) unsigned default NULL,
  `LivBId` int(10) unsigned default NULL,
  `LivCId` int(10) unsigned default NULL,
  `LivDId` int(10) unsigned default NULL,
  `LivEId` int(10) unsigned default NULL,
  `ContId` int(10) unsigned default NULL,
  `StatoId` int(10) unsigned default NULL,
  `CittaId` int(10) unsigned default NULL,
  PRIMARY KEY  (`TLId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `testlevels`
--

INSERT INTO `testlevels` (`TLId`, `LivAId`, `LivBId`, `LivCId`, `LivDId`, `LivEId`, `ContId`, `StatoId`, `CittaId`) VALUES
(1, 2, 0, 0, 0, 0, 5, 13, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

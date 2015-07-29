/*
MySQL Data Transfer
Source Host: 127.0.0.1
Source Database: eservistest
Target Host: 127.0.0.1
Target Database: eservistest
Date: 28.04.2015. 14:01:19
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for artikl
-- ----------------------------
DROP TABLE IF EXISTS `artikl`;
CREATE TABLE `artikl` (
  `ar_id` int(11) NOT NULL AUTO_INCREMENT,
  `ar_sifra` char(6) DEFAULT NULL,
  `ar_naziv` char(100) NOT NULL,
  `ar_opis` text,
  `JedinicaMjere_jm_sifra` char(3) NOT NULL,
  `ar_aktivan` tinyint(1) NOT NULL DEFAULT '1',
  `ar_usluga` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- roba\n1- usluga',
  `ar_serijskibroj` varchar(45) DEFAULT NULL,
  `ar_malopcijena` decimal(16,2) DEFAULT NULL COMMENT 'maloprodajna cijena s porezim',
  `porez_pz_id` int(11) NOT NULL,
  `firma_fi_id` int(11) NOT NULL,
  PRIMARY KEY (`ar_id`,`JedinicaMjere_jm_sifra`,`porez_pz_id`,`firma_fi_id`),
  UNIQUE KEY `ar_id_UNIQUE` (`ar_id`),
  KEY `fk_Artikl_JedinicaMjere1` (`JedinicaMjere_jm_sifra`),
  KEY `fk_Artikl_firma1` (`firma_fi_id`),
  KEY `fk_porez` (`porez_pz_id`),
  CONSTRAINT `fk_Artikl_JedinicaMjere1` FOREIGN KEY (`JedinicaMjere_jm_sifra`) REFERENCES `jedinicamjere` (`jm_sifra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Artikl_firma1` FOREIGN KEY (`firma_fi_id`) REFERENCES `firma` (`fi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_porez` FOREIGN KEY (`porez_pz_id`) REFERENCES `porez` (`pz_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dokument
-- ----------------------------
DROP TABLE IF EXISTS `dokument`;
CREATE TABLE `dokument` (
  `do_id` int(11) NOT NULL AUTO_INCREMENT,
  `firma_fi_id` int(11) NOT NULL,
  `operater_op_id` int(11) NOT NULL COMMENT 'operater koji je izradio dokument',
  `do_broj` int(11) NOT NULL COMMENT 'broj iz serija',
  `do_datum` date NOT NULL,
  `do_vrijeme` time NOT NULL,
  `do_iznos` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'suma stavki bez PDV.a',
  `do_iznosPDV` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'suma poreza stavki',
  `do_valuta` date DEFAULT NULL COMMENT 'dospijeće',
  `do_dvo` date DEFAULT NULL COMMENT 'isporuka',
  `sredstvoplacanja_sp_id` int(11) NOT NULL,
  `vrstadokumenta_vd_id` int(11) NOT NULL,
  `naplatniuredjaj_nu_id` int(11) DEFAULT NULL,
  `prodajnoMjesto_pm_id` int(11) DEFAULT NULL,
  `Partner_pa_id` int(11) DEFAULT NULL,
  `pa_naziv` char(50) NOT NULL,
  `pa_adresa` char(50) NOT NULL,
  `pa_mjesto` char(30) NOT NULL,
  `pa_posta` char(5) NOT NULL,
  `pa_oib` char(20) NOT NULL,
  `do_uuid` char(36) DEFAULT NULL COMMENT 'UUID je  Universally Unique IDentifier\n',
  `do_zki` char(32) DEFAULT NULL COMMENT 'ZKI je zaštitni kod izdavatelja',
  `do_jir` char(36) DEFAULT NULL COMMENT 'Jedinstveni Indetifikator Računa- odgovor od porezne',
  `do_placeno` tinyint(1) DEFAULT '0' COMMENT 'plaćeno=1\nnije plaćeno=0',
  `do_napomena` char(255) DEFAULT NULL,
  `do_osoba` char(50) DEFAULT NULL COMMENT 'samo u tvrtki ako se šalje N/R',
  `do_status` char(1) DEFAULT NULL COMMENT 'Z - zavrsen, S- storniran, I - u izradi',
  `pg_godina` year(4) DEFAULT NULL,
  `do_datumizmjene` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `do_mjestoizdavanja` char(50) DEFAULT NULL,
  `do_sifragreske` text COMMENT 'sifra greske fiskalizacije',
  `do_id_vezanog` int(11) DEFAULT NULL COMMENT 'popunjava se ID.em storniranog dokumenta',
  PRIMARY KEY (`do_id`,`firma_fi_id`,`operater_op_id`,`sredstvoplacanja_sp_id`,`vrstadokumenta_vd_id`),
  KEY `fk_ponuda_firma1` (`firma_fi_id`),
  KEY `fk_ponuda_operater1` (`operater_op_id`),
  KEY `fk_ponuda_Partner1` (`Partner_pa_id`),
  KEY `fk_dokument_sredstvoplacanja1` (`sredstvoplacanja_sp_id`),
  KEY `fk_dokument_vrstadokumenta1` (`vrstadokumenta_vd_id`),
  KEY `fk_dokument_naplatniuredjaj1` (`naplatniuredjaj_nu_id`),
  KEY `Partner_pa_id` (`Partner_pa_id`,`pa_adresa`,`pa_mjesto`,`pa_posta`,`pa_oib`),
  CONSTRAINT `dokument_ibfk_4` FOREIGN KEY (`Partner_pa_id`) REFERENCES `partner` (`pa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dokument_sredstvoplacanja1` FOREIGN KEY (`sredstvoplacanja_sp_id`) REFERENCES `sredstvoplacanja` (`sp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dokument_vrstadokumenta1` FOREIGN KEY (`vrstadokumenta_vd_id`) REFERENCES `vrstadokumenta` (`vd_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ponuda_firma1` FOREIGN KEY (`firma_fi_id`) REFERENCES `firma` (`fi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ponuda_operater1` FOREIGN KEY (`operater_op_id`) REFERENCES `operater` (`op_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for firma
-- ----------------------------
DROP TABLE IF EXISTS `firma`;
CREATE TABLE `firma` (
  `fi_id` int(11) NOT NULL AUTO_INCREMENT,
  `fi_oib` char(11) NOT NULL COMMENT 'OIB firme',
  `fi_naziv` char(70) NOT NULL COMMENT 'NAZIV FIRME',
  `fi_adresa` char(50) NOT NULL,
  `fi_posta` char(5) NOT NULL,
  `fi_mjesto` char(50) NOT NULL,
  `fi_telefon` char(30) DEFAULT NULL,
  `fi_iban` text NOT NULL,
  `fi_logo` varchar(255) DEFAULT NULL,
  `fi_datumregistracije` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fi_fax` char(15) DEFAULT NULL,
  `fi_mail` char(40) NOT NULL,
  `fi_mobitel` varchar(15) DEFAULT NULL,
  `fi_registracijado` date NOT NULL,
  `fi_aktivna` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-aktivna\n0-nije aktivna',
  `fi_usustavuPDV` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1- u sustavu pdv , 0-nije u sustavu',
  `fi_opis` text,
  `fi_certifikat` varchar(255) DEFAULT NULL,
  `fi_pass` char(40) DEFAULT NULL,
  PRIMARY KEY (`fi_id`),
  UNIQUE KEY `fi_id_UNIQUE` (`fi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='korisnik programa,nekoliko prodajnih mjesta';

-- ----------------------------
-- Table structure for jedinicamjere
-- ----------------------------
DROP TABLE IF EXISTS `jedinicamjere`;
CREATE TABLE `jedinicamjere` (
  `jm_sifra` char(3) NOT NULL,
  `jm_opis` varchar(45) NOT NULL,
  `jm_rednibroj` int(11) DEFAULT NULL,
  PRIMARY KEY (`jm_sifra`),
  UNIQUE KEY `jm_sifra_UNIQUE` (`jm_sifra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for maticnifortuno
-- ----------------------------
DROP TABLE IF EXISTS `maticnifortuno`;
CREATE TABLE `maticnifortuno` (
  `mf_id` int(11) NOT NULL AUTO_INCREMENT,
  `mf_oib` char(11) NOT NULL COMMENT 'OIB firme',
  `mf_naziv` char(50) NOT NULL COMMENT 'NAZIV FIRME',
  `mf_adresa` char(50) NOT NULL,
  `mf_posta` char(5) NOT NULL,
  `mf_mjesto` char(50) NOT NULL,
  `mf_telefon` char(30) DEFAULT NULL,
  `mf_logo` blob,
  `mf_mail` char(40) NOT NULL,
  PRIMARY KEY (`mf_id`),
  UNIQUE KEY `mf_id_UNIQUE` (`mf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='korisnik programa,nekoliko prodajnih mjesta';

-- ----------------------------
-- Table structure for naplatniuredjaj
-- ----------------------------
DROP TABLE IF EXISTS `naplatniuredjaj`;
CREATE TABLE `naplatniuredjaj` (
  `nu_id` int(11) NOT NULL AUTO_INCREMENT,
  `nu_broj` int(11) NOT NULL DEFAULT '1' COMMENT 'Broj se čita iz serije',
  `prodajnoMjesto_pm_id` int(11) NOT NULL,
  PRIMARY KEY (`nu_id`),
  UNIQUE KEY `oznaka` (`nu_broj`,`prodajnoMjesto_pm_id`),
  KEY `prodajnoMjesto_pm_id` (`prodajnoMjesto_pm_id`),
  CONSTRAINT `naplatniuredjaj_ibfk_1` FOREIGN KEY (`prodajnoMjesto_pm_id`) REFERENCES `prodajnomjesto` (`pm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for operater
-- ----------------------------
DROP TABLE IF EXISTS `operater`;
CREATE TABLE `operater` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_lozinka` char(40) DEFAULT NULL,
  `op_ime` char(40) NOT NULL,
  `op_prezime` char(50) DEFAULT NULL,
  `op_telefon` char(15) DEFAULT NULL,
  `op_mail` char(40) DEFAULT NULL,
  `op_aktivan` tinyint(1) NOT NULL DEFAULT '1',
  `op_oib` char(11) NOT NULL,
  `op_avatar` varchar(255) DEFAULT NULL,
  `firma_fi_id` int(11) DEFAULT NULL,
  `op_nivo` smallint(6) DEFAULT '1' COMMENT '1 - admin, 2 - korisnik',
  `op_code` varchar(255) DEFAULT NULL COMMENT 'random broj koji se generira prilikom prve prijave korisnika',
  PRIMARY KEY (`op_id`),
  UNIQUE KEY `fk_mail` (`op_mail`),
  KEY `fk_operater_firma1` (`firma_fi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Svaki operater ima sva prava.';

-- ----------------------------
-- Table structure for partner
-- ----------------------------
DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner` (
  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
  `pa_naziv` char(50) NOT NULL,
  `pa_mjesto` char(30) DEFAULT NULL,
  `pa_adresa` char(50) DEFAULT NULL,
  `pa_posta` char(5) DEFAULT NULL COMMENT 'poštanski broj',
  `pa_telefon` char(30) DEFAULT NULL,
  `pa_web` char(60) DEFAULT NULL,
  `pa_mail` char(100) DEFAULT NULL,
  `pa_fax` char(20) DEFAULT NULL,
  `pa_oib` char(20) DEFAULT NULL,
  `pa_ziroracun` char(50) DEFAULT NULL,
  `pa_maticnibr` char(20) DEFAULT NULL,
  `pa_usustavupdv` tinyint(4) DEFAULT '1',
  `firma_fi_id` int(11) NOT NULL,
  `pa_opaska` text,
  `pa_aktivan` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pa_id`,`firma_fi_id`),
  KEY `fk_Partner_firma1` (`firma_fi_id`),
  KEY `pa_id` (`pa_id`,`pa_mjesto`,`pa_adresa`,`pa_posta`,`pa_oib`),
  CONSTRAINT `fk_Partner_firma1` FOREIGN KEY (`firma_fi_id`) REFERENCES `firma` (`fi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for porez
-- ----------------------------
DROP TABLE IF EXISTS `porez`;
CREATE TABLE `porez` (
  `pz_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PZ_POSTO` decimal(5,2) NOT NULL DEFAULT '0.00',
  `PZ_DATUMOD` date DEFAULT NULL,
  `PZ_DATUMDO` date DEFAULT NULL,
  `PZ_DATPROMJENE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poreznaStopa_pzs_ID` int(11) NOT NULL,
  PRIMARY KEY (`pz_ID`),
  UNIQUE KEY `pz_ID_UNIQUE` (`pz_ID`),
  KEY `fk_porez_poreznaStopa1` (`poreznaStopa_pzs_ID`),
  CONSTRAINT `fk_porez_poreznaStopa1` FOREIGN KEY (`poreznaStopa_pzs_ID`) REFERENCES `poreznastopa` (`pzs_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for poreznastopa
-- ----------------------------
DROP TABLE IF EXISTS `poreznastopa`;
CREATE TABLE `poreznastopa` (
  `pzs_ID` int(11) NOT NULL AUTO_INCREMENT,
  `pzs_sifra` char(2) COLLATE latin2_croatian_ci NOT NULL,
  `pzs_naziv` char(25) COLLATE latin2_croatian_ci NOT NULL,
  PRIMARY KEY (`pzs_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

-- ----------------------------
-- Table structure for prodajnomjesto
-- ----------------------------
DROP TABLE IF EXISTS `prodajnomjesto`;
CREATE TABLE `prodajnomjesto` (
  `pm_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_oznaka` varchar(20) NOT NULL,
  `pm_ulica` varchar(100) DEFAULT NULL,
  `pm_kucniBroj` varchar(4) DEFAULT NULL,
  `pm_kucniBrojDodatak` varchar(4) DEFAULT NULL,
  `pm_posta` varchar(12) DEFAULT NULL,
  `pm_opcina` varchar(35) DEFAULT NULL,
  `pm_mjesto` varchar(45) DEFAULT NULL,
  `pm_ostaliTipovi` varchar(100) DEFAULT NULL COMMENT 'pokretna trgovina, internet trgovina..',
  `pm_oib` char(11) DEFAULT NULL,
  `pm_radnoVrijeme` varchar(100) DEFAULT NULL,
  `pm_datumPocetkaPrimjene` date DEFAULT NULL,
  `pm_oznakaZatvaranja` char(1) DEFAULT NULL COMMENT 'Z ili prazno',
  `pm_oibProizvodjacaSoftvera` char(11) DEFAULT NULL,
  `pm_datumRegistracije` date DEFAULT NULL,
  `pm_zatvoreno` int(1) DEFAULT '0' COMMENT '1 - da , 0 - ne ,  ako je poslana prijava PP sa oznakom "Z" onda je to 1 ',
  `firma_fi_id` int(11) NOT NULL,
  `pm_datumOtvaranja` date DEFAULT NULL,
  `pm_datumZatvaranja` date DEFAULT NULL,
  PRIMARY KEY (`pm_id`,`firma_fi_id`),
  KEY `fk_prodajnoMjesto_firma1` (`firma_fi_id`),
  CONSTRAINT `fk_prodajnoMjesto_firma1` FOREIGN KEY (`firma_fi_id`) REFERENCES `firma` (`fi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Prodajno mjesto neke firme';

-- ----------------------------
-- Table structure for serije
-- ----------------------------
DROP TABLE IF EXISTS `serije`;
CREATE TABLE `serije` (
  `se_ID` int(11) NOT NULL AUTO_INCREMENT,
  `se_broj` int(11) NOT NULL DEFAULT '0',
  `se_datumzadnji` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pg_godina` year(4) NOT NULL DEFAULT '2015',
  `naplatniUredjaj_na_id` int(11) DEFAULT NULL,
  `prodajnoMjesto_pm_id` int(11) DEFAULT NULL,
  `vrstadokumenta_vd_id` int(11) NOT NULL,
  `firma_fi_id` int(11) NOT NULL,
  PRIMARY KEY (`se_ID`,`vrstadokumenta_vd_id`,`firma_fi_id`),
  KEY `fk_serije_vrstadokumenta1` (`vrstadokumenta_vd_id`),
  KEY `fk_serije_prodajnomjesto` (`prodajnoMjesto_pm_id`),
  KEY `fk_firmaID` (`firma_fi_id`),
  KEY `fk_serije_naplatniuredjaj` (`naplatniUredjaj_na_id`),
  CONSTRAINT `fk_serije_vrstadokumenta1` FOREIGN KEY (`vrstadokumenta_vd_id`) REFERENCES `vrstadokumenta` (`vd_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `serije_ibfk_1` FOREIGN KEY (`firma_fi_id`) REFERENCES `firma` (`fi_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `serije_ibfk_2` FOREIGN KEY (`naplatniUredjaj_na_id`) REFERENCES `naplatniuredjaj` (`nu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `serije_ibfk_3` FOREIGN KEY (`prodajnoMjesto_pm_id`) REFERENCES `prodajnomjesto` (`pm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='za svaku fi i vr.dok., i prod.mjesto brojčanik  ide od 1.';

-- ----------------------------
-- Table structure for sredstvoplacanja
-- ----------------------------
DROP TABLE IF EXISTS `sredstvoplacanja`;
CREATE TABLE `sredstvoplacanja` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_opis` varchar(60) NOT NULL,
  `sp_fiskalizirati` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1- ide fiskalizacija, 0 - ne ide fiskalizacija',
  `sp_oznaka` char(1) DEFAULT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for stavkedokumenta
-- ----------------------------
DROP TABLE IF EXISTS `stavkedokumenta`;
CREATE TABLE `stavkedokumenta` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `dokument_do_id` int(11) NOT NULL,
  `ar_naziv` char(100) DEFAULT NULL COMMENT 'Ovo se popunjava ako nije iz postojećeg šif. artikala',
  `Artikl_ar_id` int(11) DEFAULT NULL COMMENT 'popunjava se ako je izabrano iz postojećeg šifarnika',
  `porez_pz_posto` decimal(5,2) NOT NULL,
  `poreznastopa_pz_sifra` char(3) NOT NULL,
  `JedinicaMjere_jm_sifra` char(3) NOT NULL,
  `sd_kolicina` decimal(16,3) NOT NULL DEFAULT '0.000',
  `sd_cijenabruto` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'Cijena veleprodajna - bez PDV.a (šifarnik)',
  `sd_popust` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT '% popusta',
  `sd_iznospopusta` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'sd_cijena * (sd_popust/100)',
  `sd_cijenaneto` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'cijena sa uračunatim popustom',
  `sd_iznosneto` decimal(16,2) NOT NULL DEFAULT '0.00' COMMENT 'iz sd_maloprodajnacijena izvijen porez i dobiva se osnovica',
  `sd_poreziznos` decimal(16,3) NOT NULL DEFAULT '0.000',
  `ar_dodatniopis` text COMMENT 'ovo se ispisuje ispod stavke art',
  `sd_datumizmjene` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `operater_op_id` int(11) NOT NULL COMMENT 'operater koji je dodao/mijenjao stavku',
  PRIMARY KEY (`sd_id`,`JedinicaMjere_jm_sifra`,`operater_op_id`),
  KEY `fk_stavkedokumenta_Artikl1` (`Artikl_ar_id`),
  KEY `fk_stavkedokumenta_JedinicaMjere1` (`JedinicaMjere_jm_sifra`),
  KEY `fk_stavkedokumenta_dokument1` (`dokument_do_id`),
  KEY `operater_op_id` (`operater_op_id`),
  CONSTRAINT `fk_stavkedokumenta_Artikl1` FOREIGN KEY (`Artikl_ar_id`) REFERENCES `artikl` (`ar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stavkedokumenta_JedinicaMjere1` FOREIGN KEY (`JedinicaMjere_jm_sifra`) REFERENCES `jedinicamjere` (`jm_sifra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `operater_op_id` FOREIGN KEY (`operater_op_id`) REFERENCES `operater` (`op_id`),
  CONSTRAINT `stavkedokumenta_ibfk_2` FOREIGN KEY (`dokument_do_id`) REFERENCES `dokument` (`do_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for vrstadokumenta
-- ----------------------------
DROP TABLE IF EXISTS `vrstadokumenta`;
CREATE TABLE `vrstadokumenta` (
  `vd_id` int(11) NOT NULL AUTO_INCREMENT,
  `vd_oznaka` char(15) NOT NULL DEFAULT '' COMMENT 'Mora biti jedna riječ bez ČŽŠĆĐ, razmaka i posebnih znakova ',
  `vd_opis` char(15) NOT NULL COMMENT 'opis koji će se ispisati u meniju aplikacije / obavezan',
  `vd_racun_iz_ponude` tinyint(4) DEFAULT NULL COMMENT 'Zbog prikaza Buttona za generiranje računa direktno iz ponude, ukoliko je 1 vidjet će se taj button',
  PRIMARY KEY (`vd_id`),
  UNIQUE KEY `oznaka` (`vd_oznaka`,`vd_opis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Function structure for aktivnastopaporeza
-- ----------------------------
DROP FUNCTION IF EXISTS `aktivnastopaporeza`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `aktivnastopaporeza`(porezid INT, datum date) RETURNS double
    DETERMINISTIC
begin
	declare vposto double;
	select pz_posto from porez where porez.poreznaStopa_pzs_ID=porezID and porez.PZ_DATUMOD<=datum  and porez.PZ_DATUMDO>=datum into vposto;
	RETURN vposto;
end;;
DELIMITER ;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `artikl` VALUES ('1', '123', 'Neki artikl', 'as dasd asd asd ad sad asd', 'KOM', '1', '0', '', '1000.00', '9', '1');
INSERT INTO `artikl` VALUES ('2', '424', 'sdfsdf', '', 'KOM', '1', '0', '', '125.00', '2', '1');
INSERT INTO `artikl` VALUES ('3', '12312', 'Oslobođen', '', 'KOM', '1', '0', '', '123.00', '11', '1');
INSERT INTO `artikl` VALUES ('4', '313', 'asdasd', '', 'KOM', '1', '0', '', '44.00', '10', '1');
INSERT INTO `artikl` VALUES ('5', '131', 'Ne podliježe', '', 'KOM', '1', '0', '', '100.00', '9', '1');
INSERT INTO `artikl` VALUES ('6', '123', '1111', '', 'KOM', '1', '0', '', '0.00', '9', '60');
INSERT INTO `ci_sessions` VALUES ('156ad46904d770c1d64edf78ed13bc12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36', '1428131432', 'a:12:{s:9:\"user_data\";s:0:\"\";s:12:\"is_logged_in\";i:1;s:8:\"id_osoba\";s:1:\"1\";s:5:\"email\";b:0;s:3:\"ime\";s:4:\"Ivan\";s:7:\"prezime\";s:9:\"Sokcević\";s:5:\"firma\";s:26:\"INFORMATIKA FORTUNO D.O.O.\";s:7:\"firmaID\";s:1:\"1\";s:12:\"firma_mjesto\";s:7:\"Vukovar\";s:11:\"UsustavuPDV\";s:1:\"1\";s:4:\"nivo\";s:1:\"1\";s:5:\"slika\";s:1:\"0\";}');
INSERT INTO `ci_sessions` VALUES ('dc771a25276e062e30cb74394f7c76da', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36', '1428131461', '');
INSERT INTO `dokument` VALUES ('1', '1', '1', '1', '2015-03-17', '07:58:00', '223.00', '25.00', '2015-03-17', '2015-03-17', '3', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, '84345b7d64f958bf49df295af842eb04', '9bf37b20-1801-4170-a407-b41e7397af18', '1', '', '', 'Z', '2015', '2015-03-17 07:58:36', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('2', '1', '1', '2', '2015-03-17', '07:59:00', '1248.00', '266.25', '2015-03-17', '2015-03-17', '4', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'e62ef85f3d895fdaf3a5f525b651e797', 'b9195609-a8ab-43d0-a3f4-62222470ecad', '1', '', '', 'Z', '2015', '2015-03-17 08:00:06', 'Vukovar', null, '4');
INSERT INTO `dokument` VALUES ('3', '1', '1', '3', '2015-03-17', '08:00:00', '100.00', '25.00', '2015-03-17', '2015-03-17', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'c1ac6e9a41d41380cf077becf842488d', '8c2416d0-54c8-446b-b35c-675ab8f3eeb1', '1', '', '', 'Z', '2015', '2015-03-25 08:47:33', 'Vukovar', 'CODECURL: Failed to connect to cistest.apis-it.hr port 8449: Host unreachable || ', '14');
INSERT INTO `dokument` VALUES ('4', '1', '1', '4', '2015-03-17', '08:00:00', '-1248.00', '-266.25', '2015-03-17', '2015-03-17', '4', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'e88758c06475a741dc1535aa435b3469', '73e4464e-a60b-48b4-9f1b-2eba2c90dd03', '1', '', '', 'S', '2015', '2015-03-17 08:02:03', 'Vukovar', 'CODECURL: Failed to connect to cistest.apis-it.hr port 8449: Host unreachable || ', null);
INSERT INTO `dokument` VALUES ('5', '1', '1', '5', '2015-03-17', '08:01:00', '125.00', '16.25', '2015-03-17', '2015-03-17', '1', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-03-17 08:01:38', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('6', '1', '1', '6', '2015-03-17', '12:16:00', '125.00', '16.25', '2015-03-17', '2015-03-17', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, '4d3614361dc713161cfaf3b2e66ad874', '15119de1-55e2-47e3-8bd4-f62f94fcd1a2', '1', '', '', 'Z', '2015', '2015-03-17 12:16:17', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('7', '1', '1', '7', '2015-03-21', '08:10:00', '167.00', '2.20', '2015-03-21', '2015-03-21', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'e659e4f3dd7825668dbc7ae3da599a00', 'e38e410d-e603-492f-b807-af162eedbf22', '1', '', '', 'Z', '2015', '2015-03-21 10:54:29', 'Vukovar', 'CODECURL: Could not resolve host: cistest.apis-it.hr || ', null);
INSERT INTO `dokument` VALUES ('8', '1', '1', '1', '2015-04-10', '09:10:00', '1292.00', '268.45', '2015-03-23', '1970-01-01', '2', '1', null, null, '1', 'pero d.o.o', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-04-10 09:10:16', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('9', '1', '1', '11', '2015-03-27', '08:14:00', '1000.00', '250.00', '2015-03-23', '2015-03-23', '1', '2', '1', '1', null, 'sdasd', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-03-27 08:14:47', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('12', '1', '1', '8', '2015-03-25', '08:28:00', '1000.00', '250.00', '2015-03-25', '2015-03-25', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, '40f46b4ebec8a5f5267f1825118d5dd6', '0adb9f19-634d-4f90-adc0-989706ef4b86', '1', '', '', 'Z', '2015', '2015-03-25 08:28:48', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('14', '1', '1', '9', '2015-03-25', '08:47:00', '-100.00', '-25.00', '2015-03-17', '2015-03-17', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, '9582b3c7acf890908edcb177c4a902d0', 'c9acd13d-8c84-4e40-9f21-fcee1834d0c9', '1', '', '', 'S', '2015', '2015-03-25 08:47:33', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('15', '1', '1', '10', '2015-03-26', '12:29:00', '1000.00', '250.00', '2015-03-26', '2015-03-26', '1', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-03-26 12:29:35', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('18', '1', '1', '12', '2015-03-31', '10:38:00', '1125.00', '266.25', '2015-03-31', '2015-03-31', '1', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-03-31 10:38:18', 'Vukovar', null, null);
INSERT INTO `dokument` VALUES ('19', '1', '1', '13', '2015-03-31', '10:38:00', '223.00', '25.00', '2015-03-31', '2015-03-31', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'e65b9f4cbde5aa8c7ad4adb3bd9ad259', '3652ebc4-0e2c-451c-855b-38dcc80ef6bd', '1', '', '', 'Z', '2015', '2015-04-02 10:36:37', 'Vukovar', 'CODE2: Certifikat nije izdan od strane FINA-e.', '20');
INSERT INTO `dokument` VALUES ('20', '1', '1', '14', '2015-03-31', '10:41:00', '-223.00', '-25.00', '2015-03-31', '2015-03-31', '2', '2', '1', '1', '1', 'pero d.o.o', '', '', '', '', null, 'eb536acc3217f20429002bccf910025e', '77854e91-42fc-4472-8f2b-f6be60ea2a0b', '1', '', '', 'S', '2015', '2015-04-02 10:36:37', 'Vukovar', 'CODE2: Certifikat nije izdan od strane FINA-e.', null);
INSERT INTO `dokument` VALUES ('21', '82', '2', '1', '2015-04-09', '10:18:00', '0.00', '0.00', '2015-04-09', '1970-01-01', '1', '1', null, null, null, 'asdasd', '', '', '', '', null, null, null, '0', '', '', 'Z', '2015', '2015-04-09 10:18:32', '', null, null);
INSERT INTO `firma` VALUES ('1', '99837487573', 'INFORMATIKA FORTUNO D.O.O.', 'SAJMIŠTE 2', '32000', 'Vukovar', '', 'PBZ HR4023400091110643980\r\nSplitska HR0923300031100376659', '0', '2014-12-04 14:37:20', '', 'ivan.sokcevic@gmail.com', '', '0000-00-00', '1', '1', 'Registrirano na Trgovačkom sudu u Osijeku MBS: 030091440,OIB : 99837487573 Temeljni kapital: 100.000,00 kn uplaćen u cijelosti.', 'files/certifikati/1/fiskal.pfx', 'SW5mRm9ydERlbW8=');
INSERT INTO `firma` VALUES ('60', '11111111111', 'prkovic', '123', '123', '123', null, '1', null, '2015-03-22 18:36:12', null, 'ivan@gmail.com', null, '0000-00-00', '1', '1', '', null, null);
INSERT INTO `firma` VALUES ('81', '12312312311', 'proba d.o.o.', 'adresa', '123', 'asd', '', '123', '0', '2015-04-07 10:43:12', '', 'ivan.sokcevic@gmail.com', '', '2015-04-08', '1', '1', '', null, null);
INSERT INTO `firma` VALUES ('82', '12312312311', 'asdasda', '', '', '', null, '', null, '2015-04-08 09:22:54', null, 'ivan.sokcevic@gmail.com', null, '2015-12-31', '1', '1', '', null, null);
INSERT INTO `jedinicamjere` VALUES ('G', 'grami', '4');
INSERT INTO `jedinicamjere` VALUES ('KG', 'Kilogram', '2');
INSERT INTO `jedinicamjere` VALUES ('KOM', 'Komad', '1');
INSERT INTO `jedinicamjere` VALUES ('L', 'Litra', '3');
INSERT INTO `jedinicamjere` VALUES ('M', 'metar', '5');
INSERT INTO `jedinicamjere` VALUES ('ML', 'mililitri', '6');
INSERT INTO `jedinicamjere` VALUES ('PAK', 'paket', '7');
INSERT INTO `jedinicamjere` VALUES ('PAR', 'PAR', '8');
INSERT INTO `jedinicamjere` VALUES ('SET', 'set', '9');
INSERT INTO `maticnifortuno` VALUES ('1', '55446699111', 'Informatika FORTUNO d.o.o.', 'Sajmište 2', '32000', 'Vukovar', '123-456', null, 'fortuno@gmail.com');
INSERT INTO `naplatniuredjaj` VALUES ('1', '111', '1');
INSERT INTO `operater` VALUES ('1', '4606aec58cba917397ff2e4738f995e4758694f8', 'Ivan', 'Sokcević', '', 'ivan.sokcevic@fortuno.hr', '1', '12311111112', '0', '1', '1', null);
INSERT INTO `operater` VALUES ('2', '821a7450fd6f1cca82f7ecf20f8d50b177ff26eb', 'ivan', 'sokcevic', '', 'ivan.sokcevic@gmail.com', '1', '12345678999', 'assets/img/82/operater/2/Koala.jpg', '82', '1', null);
INSERT INTO `partner` VALUES ('1', 'pero d.o.o', '', '', '', '', '', 'pero@gmail.com', '', '', '', '', '0', '1', '', '1');
INSERT INTO `porez` VALUES ('1', '23.00', '2001-01-20', '2012-05-29', '2011-03-03 14:28:16', '1');
INSERT INTO `porez` VALUES ('2', '13.00', '2010-01-01', '2025-01-28', '2011-03-03 14:29:19', '2');
INSERT INTO `porez` VALUES ('3', '0.00', '2010-01-01', '2012-12-31', '2011-03-03 14:29:32', '3');
INSERT INTO `porez` VALUES ('4', '22.00', '2001-05-30', '2011-06-29', '2011-05-04 09:54:03', '1');
INSERT INTO `porez` VALUES ('8', '23.00', '2011-06-30', '2012-02-29', '2011-09-20 10:55:04', '1');
INSERT INTO `porez` VALUES ('9', '25.00', '2012-03-01', '2025-07-01', '2012-04-02 08:21:23', '1');
INSERT INTO `porez` VALUES ('10', '5.00', '2013-01-01', '2025-01-28', '2012-12-14 08:15:47', '3');
INSERT INTO `porez` VALUES ('11', '0.00', '2014-01-01', '2025-12-31', '2014-11-21 11:57:31', '4');
INSERT INTO `poreznastopa` VALUES ('1', '22', 'PDV 25%');
INSERT INTO `poreznastopa` VALUES ('2', '55', 'PDV 13%');
INSERT INTO `poreznastopa` VALUES ('3', '99', 'PDV 5%');
INSERT INTO `poreznastopa` VALUES ('4', '00', 'Oslobođeno od PDV.a');
INSERT INTO `prodajnomjesto` VALUES ('1', 'POS1', 'Kupina', '5', '', '12345', 'Kupina', 'Kupina', '', '99837487573', '12-24', '2015-03-13', '', '55446699111', '2015-03-27', '0', '1', '2015-03-13', null);
INSERT INTO `serije` VALUES ('1', '14', '2015-03-31 10:41:45', '2015', '1', '1', '2', '1');
INSERT INTO `serije` VALUES ('2', '6', '2015-03-27 10:55:34', '2015', null, null, '1', '1');
INSERT INTO `serije` VALUES ('6', '0', '2015-04-07 11:48:54', '2015', null, null, '1', '81');
INSERT INTO `serije` VALUES ('7', '1', '2015-04-09 10:18:32', '2015', null, null, '1', '82');
INSERT INTO `sredstvoplacanja` VALUES ('1', 'Transakcijski račun', '0', 'T');
INSERT INTO `sredstvoplacanja` VALUES ('2', 'Novčanice', '1', 'G');
INSERT INTO `sredstvoplacanja` VALUES ('3', 'Kartice', '1', 'K');
INSERT INTO `sredstvoplacanja` VALUES ('4', 'Ostalo', '1', 'O');
INSERT INTO `stavkedokumenta` VALUES ('1', '1', 'Oslobođen', '3', '0.00', '00', 'KOM', '1.000', '123.00', '0.00', '0.00', '123.00', '123.00', '0.000', null, '2015-03-17 07:58:30', '1');
INSERT INTO `stavkedokumenta` VALUES ('2', '1', 'Ne podliježe', '5', '25.00', '22', 'KOM', '1.000', '100.00', '0.00', '0.00', '100.00', '100.00', '25.000', null, '2015-03-17 07:58:33', '1');
INSERT INTO `stavkedokumenta` VALUES ('3', '2', 'Oslobođen', '3', '0.00', '00', 'KOM', '1.000', '123.00', '0.00', '0.00', '123.00', '123.00', '0.000', null, '2015-03-17 07:59:10', '1');
INSERT INTO `stavkedokumenta` VALUES ('4', '2', 'Laptop', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-03-17 07:59:12', '1');
INSERT INTO `stavkedokumenta` VALUES ('5', '2', 'sdfsdf', '2', '13.00', '55', 'KOM', '1.000', '125.00', '0.00', '0.00', '125.00', '125.00', '16.250', null, '2015-03-17 07:59:14', '1');
INSERT INTO `stavkedokumenta` VALUES ('6', '3', 'Ne podliježe', '5', '25.00', '22', 'KOM', '1.000', '100.00', '0.00', '0.00', '100.00', '100.00', '25.000', null, '2015-03-17 07:59:58', '1');
INSERT INTO `stavkedokumenta` VALUES ('7', '4', 'Oslobođen', '3', '0.00', '00', 'KOM', '-1.000', '123.00', '0.00', '0.00', '123.00', '-123.00', '0.000', null, '2015-03-17 08:00:06', '1');
INSERT INTO `stavkedokumenta` VALUES ('8', '4', 'Laptop', '1', '25.00', '22', 'KOM', '-1.000', '1000.00', '0.00', '0.00', '1000.00', '-1000.00', '-250.000', null, '2015-03-17 08:00:06', '1');
INSERT INTO `stavkedokumenta` VALUES ('9', '4', 'sdfsdf', '2', '13.00', '55', 'KOM', '-1.000', '125.00', '0.00', '0.00', '125.00', '-125.00', '-16.250', null, '2015-03-17 08:00:06', '1');
INSERT INTO `stavkedokumenta` VALUES ('10', '5', 'sdfsdf', '2', '13.00', '55', 'KOM', '1.000', '125.00', '0.00', '0.00', '125.00', '125.00', '16.250', null, '2015-03-17 08:01:37', '1');
INSERT INTO `stavkedokumenta` VALUES ('11', '6', 'sdfsdf', '2', '13.00', '55', 'KOM', '1.000', '125.00', '0.00', '0.00', '125.00', '125.00', '16.250', null, '2015-03-17 12:16:13', '1');
INSERT INTO `stavkedokumenta` VALUES ('12', '7', 'Oslobođen', '3', '0.00', '00', 'KOM', '1.000', '123.00', '0.00', '0.00', '123.00', '123.00', '0.000', null, '2015-03-21 08:10:51', '1');
INSERT INTO `stavkedokumenta` VALUES ('13', '7', 'asdasd', '4', '5.00', '99', 'KOM', '1.000', '44.00', '0.00', '0.00', '44.00', '44.00', '2.200', null, '2015-03-21 08:10:54', '1');
INSERT INTO `stavkedokumenta` VALUES ('14', '9', 'Neki artikl', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-03-23 09:26:40', '1');
INSERT INTO `stavkedokumenta` VALUES ('17', '12', 'Neki artikl', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-03-25 08:28:42', '1');
INSERT INTO `stavkedokumenta` VALUES ('23', '14', 'Ne podliježe', '5', '25.00', '22', 'KOM', '-1.000', '100.00', '0.00', '0.00', '100.00', '-100.00', '-25.000', null, '2015-03-25 08:47:33', '1');
INSERT INTO `stavkedokumenta` VALUES ('24', '15', 'Neki artikl', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-03-26 12:29:34', '1');
INSERT INTO `stavkedokumenta` VALUES ('39', '18', 'sdfsdf', '2', '13.00', '55', 'KOM', '1.000', '125.00', '0.00', '0.00', '125.00', '125.00', '16.250', null, '2015-03-31 10:38:11', '1');
INSERT INTO `stavkedokumenta` VALUES ('40', '18', 'Neki artikl', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-03-31 10:38:13', '1');
INSERT INTO `stavkedokumenta` VALUES ('41', '19', 'Oslobođen', '3', '0.00', '00', 'KOM', '1.000', '123.00', '0.00', '0.00', '123.00', '123.00', '0.000', null, '2015-03-31 10:38:29', '1');
INSERT INTO `stavkedokumenta` VALUES ('42', '19', 'Ne podliježe', '5', '25.00', '22', 'KOM', '1.000', '100.00', '0.00', '0.00', '100.00', '100.00', '25.000', null, '2015-03-31 10:38:32', '1');
INSERT INTO `stavkedokumenta` VALUES ('43', '20', 'Oslobođen', '3', '0.00', '00', 'KOM', '-1.000', '123.00', '0.00', '0.00', '123.00', '-123.00', '0.000', null, '2015-03-31 10:41:45', '1');
INSERT INTO `stavkedokumenta` VALUES ('44', '20', 'Ne podliježe', '5', '25.00', '22', 'KOM', '-1.000', '100.00', '0.00', '0.00', '100.00', '-100.00', '-25.000', null, '2015-03-31 10:41:45', '1');
INSERT INTO `stavkedokumenta` VALUES ('45', '21', 'asdasdasd', null, '25.00', '22', 'KOM', '1.000', '0.00', '0.00', '0.00', '0.00', '0.00', '0.000', '', '2015-04-09 10:18:51', '2');
INSERT INTO `stavkedokumenta` VALUES ('46', '21', 'asdasdasd', null, '25.00', '22', 'KOM', '1.000', '0.00', '0.00', '0.00', '0.00', '0.00', '0.000', '', '2015-04-09 10:18:55', '2');
INSERT INTO `stavkedokumenta` VALUES ('47', '21', 'ddddddd', null, '25.00', '22', 'KOM', '1.000', '0.00', '0.00', '0.00', '0.00', '0.00', '0.000', '', '2015-04-09 10:18:59', '2');
INSERT INTO `stavkedokumenta` VALUES ('48', '8', 'sdfsdf', '2', '13.00', '55', 'KOM', '1.000', '125.00', '0.00', '0.00', '125.00', '125.00', '16.250', null, '2015-04-10 09:10:06', '1');
INSERT INTO `stavkedokumenta` VALUES ('49', '8', 'Neki artikl', '1', '25.00', '22', 'KOM', '1.000', '1000.00', '0.00', '0.00', '1000.00', '1000.00', '250.000', null, '2015-04-10 09:10:09', '1');
INSERT INTO `stavkedokumenta` VALUES ('50', '8', 'asdasd', '4', '5.00', '99', 'KOM', '1.000', '44.00', '0.00', '0.00', '44.00', '44.00', '2.200', null, '2015-04-10 09:10:11', '1');
INSERT INTO `stavkedokumenta` VALUES ('51', '8', 'Oslobođen', '3', '0.00', '00', 'KOM', '1.000', '123.00', '0.00', '0.00', '123.00', '123.00', '0.000', null, '2015-04-10 09:10:14', '1');
INSERT INTO `vrstadokumenta` VALUES ('1', 'ponuda', 'Ponuda', '1');
INSERT INTO `vrstadokumenta` VALUES ('2', 'racun', 'Račun', '0');

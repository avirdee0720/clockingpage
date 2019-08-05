DROP DATABASE `mve0test`;

CREATE DATABASE `mve0test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

CREATE TABLE `mve0test`.`Attendance` (
`autonumber` int( 11 ) default NULL ,
`Month` int( 11 ) default NULL ,
`Expected` int( 11 ) default NULL ,
`Absent` int( 11 ) default NULL
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`Attendance`
SELECT *
FROM `mve0`.`Attendance` ;

CREATE TABLE `mve0test`.`DeliveryAddressesTbl` (
`DeliveryAddressID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Name` varchar( 50 ) default NULL ,
`Address1` varchar( 50 ) default NULL ,
`Address2` varchar( 50 ) default NULL ,
`Address3` varchar( 50 ) default NULL ,
`CityRegion` varchar( 50 ) default NULL ,
`PostalCode` varchar( 50 ) default NULL ,
PRIMARY KEY ( `DeliveryAddressID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`DeliveryAddressesTbl`
SELECT *
FROM `mve0`.`DeliveryAddressesTbl` ;

CREATE TABLE `mve0test`.`emplcat` (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`catozn` varchar( 5 ) NOT NULL default '',
`catname` varchar( 20 ) NOT NULL default '',
PRIMARY KEY ( `ID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`emplcat`
SELECT *
FROM `mve0`.`emplcat` ;

CREATE TABLE `mve0test`.`hd_dostawcy` (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`DSKOD` double default NULL ,
`DSNAZWA` varchar( 255 ) default NULL ,
`DSMIASTO` varchar( 255 ) default NULL ,
`DSULICA` varchar( 255 ) default NULL ,
`DSNRDOMU` varchar( 255 ) default NULL ,
`DSKODPOCZT` varchar( 255 ) default NULL ,
`DSTEL` varchar( 255 ) default NULL ,
`DSFAX` varchar( 255 ) default NULL ,
`DSTELEX` varchar( 255 ) default NULL ,
`DSSALDO` double default NULL ,
`DSDLUG` double default NULL ,
`DSBANK` varchar( 255 ) default NULL ,
`DSKONTO` varchar( 255 ) default NULL ,
`DSRABAT` double default NULL ,
`DSNRIDENT` varchar( 255 ) default NULL ,
`DSUWAGI` varchar( 255 ) default NULL ,
`DSPRACOW` tinyint( 1 ) default NULL ,
`DSNAZSKR` varchar( 255 ) default NULL ,
`DSKONTOFK` varchar( 255 ) default NULL ,
`user_id` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `ID` ) ,
KEY `DSKOD` ( `DSKOD` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_dostawcy`
SELECT *
FROM `mve0`.`hd_dostawcy` ;

CREATE TABLE `mve0test`.`hd_drukarka` (
`id_dr` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Nr_seryjny` varchar( 50 ) default NULL ,
`MOdel` varchar( 50 ) default NULL ,
`Nr_ewidencyjny` varchar( 50 ) default NULL ,
`Producent` varchar( 50 ) default NULL ,
`Rok_prod` varchar( 5 ) default NULL ,
`id_zest` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `id_dr` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_drukarka`
SELECT *
FROM `mve0`.`hd_drukarka` ;

CREATE TABLE `mve0test`.`hd_images` (
`photo_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`artykul_id` int( 11 ) NOT NULL default '0',
`photo_alttext` text NOT NULL ,
`photo_src` longblob NOT NULL ,
`photo_desc` mediumtext NOT NULL ,
`photo_filename` varchar( 50 ) NOT NULL default '',
`photo_filesize` varchar( 50 ) NOT NULL default '',
`photo_filetype` varchar( 50 ) NOT NULL default '',
`photo_link` varchar( 100 ) NOT NULL default '',
`id_zest` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `photo_id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_images`
SELECT *
FROM `mve0`.`hd_images` ;

CREATE TABLE `mve0test`.`hd_imgcad` (
`photo_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`photo_alttext` text NOT NULL ,
`zeichnungsnr` double default NULL ,
`photo_src` longblob NOT NULL ,
`photo_desc` mediumtext NOT NULL ,
`photo_endesc` mediumtext NOT NULL ,
`photo_filename` varchar( 50 ) NOT NULL default '',
`photo_filesize` varchar( 50 ) NOT NULL default '',
`photo_filetype` varchar( 50 ) NOT NULL default '',
`photo_path` varchar( 250 ) NOT NULL default '',
`photo_format` varchar( 5 ) NOT NULL default '',
`photo_link` varchar( 100 ) NOT NULL default '',
`id_zest` int( 11 ) NOT NULL default '0',
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
PRIMARY KEY ( `photo_id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_imgcad`
SELECT *
FROM `mve0`.`hd_imgcad` ;

CREATE TABLE `mve0test`.`hd_kasowal` (
`lp` tinyint( 5 ) NOT NULL AUTO_INCREMENT ,
`tabela` varchar( 15 ) default NULL ,
`temat` text,
`kiedy` datetime default NULL ,
`user_id` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 COMMENT = 'Kto co skasowal';

INSERT INTO `mve0test`.`hd_kasowal`
SELECT *
FROM `mve0`.`hd_kasowal` ;

CREATE TABLE `mve0test`.`hd_komp` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Klawiatura` tinyint( 1 ) default NULL ,
`Mysz` tinyint( 1 ) default NULL ,
`Dzial` int( 11 ) default NULL ,
`Lokalizacja` varchar( 70 ) default NULL ,
`Uzytkownik` int( 11 ) default NULL ,
`Nr_ewid` varchar( 50 ) default NULL ,
`Nr_seryjny` varchar( 50 ) default NULL ,
`Rok_prod` varchar( 5 ) default NULL ,
`Data_gw_do` date default NULL ,
`Dostawca` varchar( 50 ) default NULL ,
`Model` varchar( 50 ) default NULL ,
`TCP_IP_DHCP` tinyint( 1 ) default NULL ,
`TCP_IP_Reczne` varchar( 20 ) default NULL ,
`Nazwa_sieciowa` varchar( 50 ) default NULL ,
`Procesor` varchar( 50 ) default NULL ,
`MB_RAM` varchar( 50 ) default NULL ,
`muzyka` tinyint( 1 ) default NULL ,
`HDD0` varchar( 50 ) default NULL ,
`HDD1` varchar( 50 ) default NULL ,
`HDD2` varchar( 50 ) default NULL ,
`HDD3` varchar( 50 ) default NULL ,
`id_zest` int( 11 ) default NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_komp`
SELECT *
FROM `mve0`.`hd_komp` ;

CREATE TABLE `mve0test`.`hd_log` (
`lp` tinyint( 5 ) NOT NULL AUTO_INCREMENT ,
`tabela` varchar( 15 ) default NULL ,
`temat` text,
`kiedy` datetime default NULL ,
`user_id` int( 11 ) NOT NULL default '0',
`infodod` text NOT NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Kto co skasowal';

INSERT INTO `mve0test`.`hd_log`
SELECT *
FROM `mve0`.`hd_log` ;

CREATE TABLE `mve0test`.`hd_log_old` (
`lp` tinyint( 5 ) NOT NULL AUTO_INCREMENT ,
`tabela` varchar( 15 ) default NULL ,
`temat` text,
`kiedy` datetime default NULL ,
`user_id` int( 11 ) NOT NULL default '0',
`infodod` text NOT NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Kto co skasowal';

INSERT INTO `mve0test`.`hd_log_old`
SELECT *
FROM `mve0`.`hd_log_old` ;

CREATE TABLE `mve0test`.`hd_menu1` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`mnu_nazwa` varchar( 30 ) NOT NULL default '',
`mnu_nr` int( 2 ) NOT NULL default '0',
`mnu_plik` varchar( 50 ) NOT NULL default '',
`kol` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_menu1`
SELECT *
FROM `mve0`.`hd_menu1` ;

CREATE TABLE `mve0test`.`hd_monitor` (
`id_mon` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Nr_seryjny` varchar( 50 ) default NULL ,
`MOdel` varchar( 50 ) default NULL ,
`Nr_ewidencyjny` varchar( 50 ) default NULL ,
`Producent` varchar( 50 ) default NULL ,
`Rok_prod` varchar( 5 ) default NULL ,
`id_zest` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `id_mon` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_monitor`
SELECT *
FROM `mve0`.`hd_monitor` ;

CREATE TABLE `mve0test`.`hd_notatki` (
`not_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`not_data` date NOT NULL default '0000-00-00',
`not_opis` text NOT NULL ,
`not_firma_cena` varchar( 70 ) NOT NULL default '',
`id_zest` int( 11 ) NOT NULL default '0',
`firma_id` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `not_id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_notatki`
SELECT *
FROM `mve0`.`hd_notatki` ;

CREATE TABLE `mve0test`.`hd_program` (
`id_prog` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Nr_seryjny` varchar( 50 ) default NULL ,
`id_nazwa` int( 11 ) default NULL ,
`Wersja` varchar( 50 ) default NULL ,
`Typ` int( 11 ) default NULL ,
`id_zest` int( 11 ) default NULL ,
PRIMARY KEY ( `id_prog` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_program`
SELECT *
FROM `mve0`.`hd_program` ;

CREATE TABLE `mve0test`.`hd_programyall` (
`id_prg` int( 11 ) NOT NULL AUTO_INCREMENT ,
`prg_nazwa` varchar( 70 ) NOT NULL default '',
`prg_ver` varchar( 50 ) NOT NULL default '',
PRIMARY KEY ( `id_prg` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_programyall`
SELECT *
FROM `mve0`.`hd_programyall` ;

CREATE TABLE `mve0test`.`hd_status` (
`lp` double NOT NULL AUTO_INCREMENT ,
`stopis` varchar( 20 ) default NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_status`
SELECT *
FROM `mve0`.`hd_status` ;

CREATE TABLE `mve0test`.`hd_upr` (
`lp` tinyint( 5 ) NOT NULL AUTO_INCREMENT ,
`tabela` varchar( 15 ) default NULL ,
`sel` int( 11 ) NOT NULL default '0',
`ins` int( 11 ) NOT NULL default '0',
`upt` int( 11 ) NOT NULL default '0',
`opis` varchar( 100 ) NOT NULL default '',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 COMMENT = 'Kto co skasowal';

INSERT INTO `mve0test`.`hd_upr`
SELECT *
FROM `mve0`.`hd_upr` ;

CREATE TABLE `mve0test`.`hd_users` (
`lp` tinyint( 3 ) unsigned NOT NULL AUTO_INCREMENT ,
`login` varchar( 30 ) default NULL ,
`nazwa` varchar( 50 ) default NULL ,
`wydzial` tinyint( 3 ) unsigned default NULL ,
`adm` tinyint( 1 ) unsigned NOT NULL default '0',
`passwd` varchar( 40 ) default NULL ,
`email` varchar( 100 ) NOT NULL default '',
`miasto` varchar( 50 ) NOT NULL default '',
`woj` varchar( 50 ) NOT NULL default '',
`kraj` varchar( 40 ) NOT NULL default '',
`tel1` varchar( 30 ) NOT NULL default '',
`tel2` varchar( 30 ) NOT NULL default '',
`security_level_id` int( 11 ) NOT NULL default '0',
`PU` int( 11 ) NOT NULL default '0',
`stanowisko` varchar( 70 ) NOT NULL default '',
`UWAGA` text,
`menu` int( 11 ) default NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_users`
SELECT *
FROM `mve0`.`hd_users` ;

CREATE TABLE `mve0test`.`hd_users_logins` (
`ID_SES` int( 11 ) NOT NULL AUTO_INCREMENT ,
`lp` int( 11 ) NOT NULL default '0',
`DATA_IN` datetime NOT NULL default '0000-00-00 00:00:00',
`DATA_OUT` datetime default NULL ,
`SES_ID` text,
`host` varchar( 255 ) default NULL ,
PRIMARY KEY ( `ID_SES` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_users_logins`
SELECT *
FROM `mve0`.`hd_users_logins` ;

CREATE TABLE `mve0test`.`hd_users_old` (
`lp` tinyint( 3 ) unsigned NOT NULL AUTO_INCREMENT ,
`login` varchar( 30 ) default NULL ,
`nazwa` varchar( 50 ) default NULL ,
`wydzial` tinyint( 3 ) unsigned default NULL ,
`adm` tinyint( 1 ) unsigned NOT NULL default '0',
`passwd` varchar( 40 ) default NULL ,
`email` varchar( 100 ) NOT NULL default '',
`miasto` varchar( 50 ) NOT NULL default '',
`woj` varchar( 50 ) NOT NULL default '',
`kraj` varchar( 40 ) NOT NULL default '',
`tel1` varchar( 30 ) NOT NULL default '',
`tel2` varchar( 30 ) NOT NULL default '',
`security_level_id` int( 11 ) NOT NULL default '0',
`PU` int( 11 ) NOT NULL default '0',
`stanowisko` varchar( 70 ) NOT NULL default '',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`hd_users_old`
SELECT *
FROM `mve0`.`hd_users_old` ;

CREATE TABLE `mve0test`.`hd_wydzial` (
`lp` tinyint( 3 ) unsigned NOT NULL AUTO_INCREMENT ,
`dzial` varchar( 50 ) default NULL ,
`lokalizacja` varchar( 50 ) default NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`hd_wydzial`
SELECT *
FROM `mve0`.`hd_wydzial` ;

CREATE TABLE `mve0test`.`hd_zestaw` (
`Identyfikator` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_komp` int( 11 ) default NULL ,
`id_dr` int( 11 ) default NULL ,
`id_mon` int( 11 ) default NULL ,
`datspr` date default NULL ,
PRIMARY KEY ( `Identyfikator` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'HD SET computers';

INSERT INTO `mve0test`.`hd_zestaw`
SELECT *
FROM `mve0`.`hd_zestaw` ;

CREATE TABLE `mve0test`.`hd_zgloszenie` (
`lp` double NOT NULL AUTO_INCREMENT ,
`kto` varchar( 50 ) default NULL ,
`kategoria` varchar( 15 ) NOT NULL default '',
`data` date default NULL ,
`czas` time default NULL ,
`waga` char( 1 ) default NULL ,
`stan` double default NULL ,
`opis` text,
`lokalizacja` text,
`ID_ODDZIAL` int( 11 ) NOT NULL default '0',
`ID_JEDNOSTKI` int( 11 ) NOT NULL default '0',
`anulowal` int( 11 ) default '0',
`dataanul` varchar( 20 ) default NULL ,
`obsluzyl` int( 11 ) default '0',
`dataobsl` varchar( 20 ) default NULL ,
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'zg?oszenia awarii';

INSERT INTO `mve0test`.`hd_zgloszenie`
SELECT *
FROM `mve0`.`hd_zgloszenie` ;

CREATE TABLE `mve0test`.`holidays` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`no` int( 10 ) NOT NULL default '0',
`date1` date NOT NULL default '0000-00-00',
`sortof` enum( 'UPL', 'PL' ) NOT NULL default 'UPL',
`hourgiven` double( 5, 2 ) NOT NULL default '0.00',
`imp` char( 1 ) NOT NULL default '',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`holidays`
SELECT *
FROM `mve0`.`holidays` ;

CREATE TABLE `mve0test`.`holidays11` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`no` int( 10 ) NOT NULL default '0',
`date1` date NOT NULL default '0000-00-00',
`sortof` enum( 'UPL', 'PL' ) NOT NULL default 'UPL',
`hourgiven` double( 5, 2 ) NOT NULL default '0.00',
`imp` char( 1 ) NOT NULL default '',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`holidays11`
SELECT *
FROM `mve0`.`holidays11` ;

CREATE TABLE `mve0test`.`IndividualOrdersTbl` (
`IndividualOrderID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`OrderID` int( 11 ) default NULL ,
`ProductSupplierID` int( 11 ) default NULL ,
`CatalogueNo` varchar( 50 ) default NULL ,
`QuantityPerUnit` int( 11 ) default NULL ,
`Measure` varchar( 50 ) default NULL ,
`UnitsPerPack` int( 11 ) default NULL ,
`PackPrice` double default NULL ,
`PacksOrdered` int( 11 ) default NULL ,
`PacksDelivered` int( 11 ) default NULL ,
`Building` tinyint( 1 ) default NULL ,
PRIMARY KEY ( `IndividualOrderID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`IndividualOrdersTbl`
SELECT *
FROM `mve0`.`IndividualOrdersTbl` ;

CREATE TABLE `mve0test`.`inout` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`ino` enum( 'IN', 'OUT' ) NOT NULL default 'IN',
`date1` date default NULL ,
`intime` time default '00:00:00',
`outtime` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`descin` varchar( 150 ) NOT NULL default '',
`descout` varchar( 150 ) NOT NULL default '',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `intime` ( `intime` ) ,
KEY `outtime` ( `outtime` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`inout`
SELECT *
FROM `mve0`.`inout` ;

CREATE TABLE `mve0test`.`inoutbak` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`ino` enum( 'IN', 'OUT' ) NOT NULL default 'IN',
`date1` date default NULL ,
`intime` time default '00:00:00',
`outtime` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`descin` varchar( 150 ) NOT NULL default '',
`descout` varchar( 150 ) NOT NULL default '',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `intime` ( `intime` ) ,
KEY `outtime` ( `outtime` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`inoutbak`
SELECT *
FROM `mve0`.`inoutbak` ;

CREATE TABLE `mve0test`.`inoutmsg` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`idinout` int( 11 ) NOT NULL default '0',
`date1` date default NULL ,
`tm` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`message` varchar( 250 ) NOT NULL default '',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `idinout` ( `idinout` ) ,
KEY `tm` ( `tm` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`inoutmsg`
SELECT *
FROM `mve0`.`inoutmsg` ;

CREATE TABLE `mve0test`.`inoutmsgbak` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`idinout` int( 11 ) NOT NULL default '0',
`date1` date default NULL ,
`tm` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`message` varchar( 250 ) NOT NULL default '',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `idinout` ( `idinout` ) ,
KEY `tm` ( `tm` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`inoutmsgbak`
SELECT *
FROM `mve0`.`inoutmsgbak` ;

CREATE TABLE `mve0test`.`ipaddress` (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`name` varchar( 15 ) NOT NULL default '',
`IP` varchar( 15 ) NOT NULL default '',
`namefb` varchar( 20 ) NOT NULL default '',
`mac` varchar( 50 ) NOT NULL default '',
PRIMARY KEY ( `ID` ) ,
KEY `IP` ( `IP` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`ipaddress`
SELECT *
FROM `mve0`.`ipaddress` ;

CREATE TABLE `mve0test`.`newatwork` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`date1` date default NULL ,
`intime` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `intime` ( `intime` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`newatwork`
SELECT *
FROM `mve0`.`newatwork` ;

CREATE TABLE `mve0test`.`nombers` (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`pno` int( 10 ) NOT NULL default '0',
`surname` varchar( 255 ) default NULL ,
`firstname` varchar( 255 ) default NULL ,
`knownas` varchar( 255 ) default NULL ,
`paystru` varchar( 255 ) default NULL ,
`newpayslip` tinyint( 1 ) default NULL ,
`daylyrate` double default NULL ,
`currentratefrom` varchar( 255 ) default NULL ,
`status` varchar( 255 ) default NULL ,
`started` date default NULL ,
`left1` date default NULL ,
`dateforbonus` date default NULL ,
`bonusmonth` int( 11 ) default NULL ,
`offsetmonth` int( 11 ) default NULL ,
`monthforav` int( 11 ) default NULL ,
`withholdbonuses` varchar( 5 ) default NULL ,
`cat` varchar( 5 ) default NULL ,
`bonustype` varchar( 10 ) default NULL ,
`vouchertype` varchar( 10 ) default NULL ,
`previous12m` varchar( 255 ) default NULL ,
`wendbonus` tinyint( 1 ) default NULL ,
`puncbonus` tinyint( 1 ) default NULL ,
`bonus5` tinyint( 1 ) default NULL ,
`bonus7` tinyint( 1 ) default NULL ,
`bhmbonus` tinyint( 1 ) default NULL ,
`secutitybonus` double default NULL ,
`travelcard` tinyint( 1 ) default NULL ,
`travelctotal` double default NULL ,
`xmasbonus` tinyint( 1 ) default NULL ,
`from1` int( 11 ) default NULL ,
`to1` int( 11 ) default NULL ,
`dueend` varchar( 5 ) default NULL ,
`regdays` double NOT NULL default '0',
PRIMARY KEY ( `ID` ) ,
KEY `pno` ( `pno` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`nombers`
SELECT *
FROM `mve0`.`nombers` ;

CREATE TABLE `mve0test`.`old_cad` (
`Zeichnungsnr` double default NULL ,
`Name` varchar( 255 ) default NULL ,
`enName` varchar( 255 ) default NULL ,
`Adresse` varchar( 255 ) default NULL ,
`Unteradresse` varchar( 255 ) default NULL ,
`Format` varchar( 255 ) default NULL ,
`Pole7` varchar( 255 ) default NULL ,
`Pole8` varchar( 255 ) default NULL ,
`Pole9` varchar( 255 ) default NULL ,
`Pole10` varchar( 255 ) default NULL ,
`Pole11` varchar( 255 ) default NULL ,
`Pole12` varchar( 255 ) default NULL
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`old_cad`
SELECT *
FROM `mve0`.`old_cad` ;

CREATE TABLE `mve0test`.`OrdersTbl` (
`OrderID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`SupplierID` int( 11 ) default NULL ,
`DateStarted` datetime default NULL ,
`DatePlaced` datetime default NULL ,
`PlacedBy` varchar( 40 ) default NULL ,
`DeliveryAddress` smallint( 6 ) default NULL ,
`InvoiceNo` varchar( 50 ) default NULL ,
`DeliveryNotes` varchar( 255 ) default NULL ,
`StatusID` int( 11 ) default NULL ,
PRIMARY KEY ( `OrderID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`OrdersTbl`
SELECT *
FROM `mve0`.`OrdersTbl` ;

CREATE TABLE `mve0test`.`ProductCategoryTbl` (
`ProductCategory` int( 11 ) NOT NULL AUTO_INCREMENT ,
`CategoryType` varchar( 50 ) default NULL ,
PRIMARY KEY ( `ProductCategory` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`ProductCategoryTbl`
SELECT *
FROM `mve0`.`ProductCategoryTbl` ;

CREATE TABLE `mve0test`.`ProductsTbl` (
`ProductID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`ProductName` varchar( 60 ) default NULL ,
`Colour` varchar( 50 ) default NULL ,
`Description` varchar( 40 ) default NULL ,
`Notes` mediumtext,
`ToFit` varchar( 50 ) default NULL ,
PRIMARY KEY ( `ProductID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`ProductsTbl`
SELECT *
FROM `mve0`.`ProductsTbl` ;

CREATE TABLE `mve0test`.`ProductSuppliersTbl` (
`ProductSupplierID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`ProductID` int( 11 ) default NULL ,
`SupplierID` int( 11 ) default NULL ,
`CatalogueNo` varchar( 20 ) default NULL ,
`PageNo` int( 11 ) default NULL ,
`QuantityPerUnit` int( 11 ) default NULL ,
`Measure` varchar( 50 ) default NULL ,
`UnitsPerPack` int( 11 ) default NULL ,
`PackPrice` double default NULL ,
`Notes` mediumtext,
PRIMARY KEY ( `ProductSupplierID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`ProductSuppliersTbl`
SELECT *
FROM `mve0`.`ProductSuppliersTbl` ;

CREATE TABLE `mve0test`.`StatusTbl` (
`StatusID` int( 11 ) default NULL ,
`Status` varchar( 50 ) default NULL
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`StatusTbl`
SELECT *
FROM `mve0`.`StatusTbl` ;

CREATE TABLE `mve0test`.`sumofweek` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`week` int( 11 ) NOT NULL default '0',
`days` int( 11 ) NOT NULL default '0',
`sumhour` double( 5, 2 ) NOT NULL default '0.00',
`Wkd` int( 11 ) NOT NULL default '0',
`PL` int( 11 ) NOT NULL default '0',
`no` int( 11 ) NOT NULL default '0',
`year` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`sumofweek`
SELECT *
FROM `mve0`.`sumofweek` ;

CREATE TABLE `mve0test`.`SupplierCategoryTbl` (
`SupplierCategory` int( 11 ) default NULL ,
`CategoryType` varchar( 50 ) default NULL
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`SupplierCategoryTbl`
SELECT *
FROM `mve0`.`SupplierCategoryTbl` ;

CREATE TABLE `mve0test`.`SupplierListTbl` (
`SupplierID` int( 11 ) default NULL ,
`Company Name` varchar( 50 ) default NULL
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`SupplierListTbl`
SELECT *
FROM `mve0`.`SupplierListTbl` ;

CREATE TABLE `mve0test`.`SuppliersTbl` (
`SupplierID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`Company` varchar( 255 ) default NULL ,
`CompanyName` varchar( 50 ) default NULL ,
`SupplierCategory` int( 11 ) default NULL ,
`SupplierCategory2` int( 11 ) default NULL ,
`Address1` varchar( 255 ) default NULL ,
`Address2` varchar( 255 ) default NULL ,
`Address3` varchar( 50 ) default NULL ,
`CityRegion` varchar( 255 ) default NULL ,
`PostalCode` varchar( 255 ) default NULL ,
`VATNo` varchar( 50 ) default NULL ,
`ContactName` varchar( 50 ) default NULL ,
`Phone1` varchar( 50 ) default NULL ,
`Phone2` varchar( 50 ) default NULL ,
`Fax` varchar( 50 ) default NULL ,
`email` varchar( 100 ) default NULL ,
`www` mediumtext,
`MethodOfPayment` varchar( 50 ) default NULL ,
`AccountNo` varchar( 50 ) default NULL ,
`DeliverySpeed` int( 11 ) default NULL ,
`WhoAreTheyAndWhatDoTheyDo` varchar( 250 ) default NULL ,
PRIMARY KEY ( `SupplierID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`SuppliersTbl`
SELECT *
FROM `mve0`.`SuppliersTbl` ;

CREATE TABLE `mve0test`.`th_cfg` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`lastkurs` double( 5, 2 ) NOT NULL default '0.00',
`stawka_g` double( 9, 2 ) NOT NULL default '0.00',
`procko` decimal( 5, 4 ) NOT NULL default '0.0000',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`th_cfg`
SELECT *
FROM `mve0`.`th_cfg` ;

CREATE TABLE `mve0test`.`th_exchange` (
`ID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`date1` date NOT NULL default '0000-00-00',
`time1` time NOT NULL default '00:00:00',
`commit` enum( 'n', 'b', 'c', 'i', 'e' ) NOT NULL default 'n',
`no` int( 10 ) NOT NULL default '0',
PRIMARY KEY ( `ID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`th_exchange`
SELECT *
FROM `mve0`.`th_exchange` ;

CREATE TABLE `mve0test`.`timeslog` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`date1` date default NULL ,
`intime` time default '00:00:00',
`outtime` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`msg` varchar( 150 ) NOT NULL default '',
`ipadr` varchar( 15 ) NOT NULL default '',
`checked` enum( 'n', 'c' ) NOT NULL default 'n',
`oldid` int( 11 ) NOT NULL default '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =1 CHECKSUM =1 DELAY_KEY_WRITE =1;

INSERT INTO `mve0test`.`timeslog`
SELECT *
FROM `mve0`.`timeslog` ;

CREATE TABLE `mve0test`.`totals` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`date1` date default NULL ,
`intime` time default '00:00:00',
`outtime` time default '00:00:00',
`no` int( 10 ) NOT NULL default '0',
`ipadr` varchar( 15 ) NOT NULL default '',
`a1030` int( 1 ) NOT NULL default '0',
`workedtime` double( 5, 2 ) NOT NULL default '0.00',
`saturday` double( 5, 2 ) NOT NULL default '0.00',
`sunday` double( 5, 2 ) NOT NULL default '0.00',
`closed` enum( 'n', 'y' ) NOT NULL default 'n',
`workedmin` varchar( 10 ) NOT NULL default '',
`workedmin2` varchar( 10 ) NOT NULL default '',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` ) ,
KEY `intime` ( `intime` ) ,
KEY `outtime` ( `outtime` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`totals`
SELECT *
FROM `mve0`.`totals` ;

CREATE TABLE `mve0test`.`totholid` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`date1` date default NULL ,
`no` int( 10 ) NOT NULL default '0',
`workedtime` double( 5, 2 ) NOT NULL default '0.00',
`PLdate` date NOT NULL default '0000-00-00',
PRIMARY KEY ( `id` ) ,
KEY `no` ( `no` ) ,
KEY `date1` ( `date1` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`totholid`
SELECT *
FROM `mve0`.`totholid` ;

CREATE TABLE `mve0test`.`weeksno` (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`dataod` date NOT NULL default '0000-00-00',
`datado` date NOT NULL default '0000-00-00',
`weekno` int( 11 ) NOT NULL default '0',
UNIQUE KEY `id` ( `id` ) ,
KEY `weekno` ( `weekno` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`weeksno`
SELECT *
FROM `mve0`.`weeksno` ;

CREATE TABLE `mve0test`.`year` (
`date1` datetime default NULL ,
`nr` smallint( 6 ) default NULL ,
`nr_week` smallint( 6 ) default NULL ,
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `nr` ( `nr` ) ,
KEY `nr_week` ( `nr_week` ) ,
KEY `date1` ( `date1` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

INSERT INTO `mve0test`.`year`
SELECT *
FROM `mve0`.`year` ;

CREATE TABLE `mve0test`.`zl_file` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`file_name` varchar( 50 ) NOT NULL default '',
`file_path` varchar( 250 ) NOT NULL default '',
`name` varchar( 250 ) NOT NULL default '',
`enname` varchar( 250 ) NOT NULL default '',
`format` varchar( 9 ) NOT NULL default '',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
`lastuse` datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 COMMENT = 'Cad drawings';

INSERT INTO `mve0test`.`zl_file`
SELECT *
FROM `mve0`.`zl_file` ;

CREATE TABLE `mve0test`.`zl_koop` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`kooperant` varchar( 100 ) NOT NULL default '',
`opis_op` text NOT NULL ,
`obr_mech` double( 9, 2 ) NOT NULL default '0.00',
`cynkowanie` double( 9, 2 ) NOT NULL default '0.00',
`arbosol` double( 9, 2 ) NOT NULL default '0.00',
`gumowanie` double( 9, 2 ) NOT NULL default '0.00',
`innepow` double( 9, 2 ) NOT NULL default '0.00',
`trawienie` double( 9, 2 ) NOT NULL default '0.00',
`konstrukcja` double( 9, 2 ) NOT NULL default '0.00',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`datas` date NOT NULL default '0000-00-00',
`datak` date NOT NULL default '0000-00-00',
`czygb` double( 9, 2 ) NOT NULL default '0.00',
`grpbud` varchar( 50 ) NOT NULL default '',
`lastuse` datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Zlecenia Technologia';

INSERT INTO `mve0test`.`zl_koop`
SELECT *
FROM `mve0`.`zl_koop` ;

CREATE TABLE `mve0test`.`zl_object` (
`ID_OBJEKT` int( 11 ) NOT NULL AUTO_INCREMENT ,
`nr_zam_o` double NOT NULL default '0',
`obj` varchar( 70 ) NOT NULL default '',
`OPIS` text,
PRIMARY KEY ( `ID_OBJEKT` ) ,
UNIQUE KEY `nr_zam_o_2` ( `nr_zam_o` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0;

INSERT INTO `mve0test`.`zl_object`
SELECT *
FROM `mve0`.`zl_object` ;

CREATE TABLE `mve0test`.`zl_tech` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`g_zad` double( 9, 2 ) NOT NULL default '0.00',
`g_przyg` double( 9, 2 ) NOT NULL default '0.00',
`g_mont` double( 9, 2 ) NOT NULL default '0.00',
`g_kons` double( 9, 2 ) NOT NULL default '0.00',
`obr_mech` double( 9, 2 ) NOT NULL default '0.00',
`powloki` double( 9, 2 ) NOT NULL default '0.00',
`matKO` double( 9, 2 ) NOT NULL default '0.00',
`T_HARDOX` double( 9, 2 ) NOT NULL default '0.00',
`tn_wys` double( 9, 2 ) NOT NULL default '0.00',
`t_m_j` double( 9, 2 ) NOT NULL default '0.00',
`t_c_j` double( 9, 2 ) NOT NULL default '0.00',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
`czygb` double( 9, 2 ) NOT NULL default '0.00',
`grpbud` varchar( 50 ) NOT NULL default '',
`lastuse` datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Zlecenia Technologia';

INSERT INTO `mve0test`.`zl_tech`
SELECT *
FROM `mve0`.`zl_tech` ;

CREATE TABLE `mve0test`.`zl_zaop` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`MB_mat_c` double( 9, 2 ) NOT NULL default '0.00',
`MB_mat_KO` double( 9, 2 ) NOT NULL default '0.00',
`MB_HARDOX` double( 9, 2 ) NOT NULL default '0.00',
`mat_pom` double( 9, 2 ) NOT NULL default '0.00',
`farby` double( 9, 2 ) NOT NULL default '0.00',
`matzl` double( 9, 2 ) NOT NULL default '0.00',
`inne` double( 9, 2 ) NOT NULL default '0.00',
`tn_zam_z` double( 9, 2 ) NOT NULL default '0.00',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
`lastuse` datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Zlecenia-zaopatrzenie-materialy bezposrednie to MB';

INSERT INTO `mve0test`.`zl_zaop`
SELECT *
FROM `mve0`.`zl_zaop` ;

CREATE TABLE `mve0test`.`zl_zbyt` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`id_zlec` int( 11 ) NOT NULL default '0',
`transport` double( 9, 2 ) NOT NULL default '0.00',
`wart_sprz` double( 9, 2 ) NOT NULL default '0.00',
`godziny` double( 9, 2 ) NOT NULL default '0.00',
`r_m_j` double( 9, 2 ) NOT NULL default '0.00',
`r_c_j` double( 9, 2 ) NOT NULL default '0.00',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
`lastuse` datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Zlecenia ZBYT';

INSERT INTO `mve0test`.`zl_zbyt`
SELECT *
FROM `mve0`.`zl_zbyt` ;

CREATE TABLE `mve0test`.`zl_zlec` (
`lp` int( 11 ) NOT NULL AUTO_INCREMENT ,
`nr_zam_pl` int( 11 ) NOT NULL default '0',
`nr_zam_o` double NOT NULL default '0',
`nr_poz` varchar( 11 ) NOT NULL default '0',
`nr_kom` varchar( 50 ) NOT NULL default '',
`obj` varchar( 70 ) NOT NULL default '',
`nazwa` varchar( 70 ) NOT NULL default '',
`w_z_e` double( 9, 2 ) NOT NULL default '0.00',
`kurs` double( 9, 2 ) NOT NULL default '0.00',
`w_z_p` double( 9, 2 ) NOT NULL default '0.00',
`tn_zam` double( 9, 2 ) NOT NULL default '0.00',
`uwagi` text NOT NULL ,
`data_wp` datetime NOT NULL default '0000-00-00 00:00:00',
`id_wpr` int( 11 ) NOT NULL default '0',
`data_popr` datetime NOT NULL default '0000-00-00 00:00:00',
`id_popr` int( 11 ) NOT NULL default '0',
`data` date NOT NULL default '0000-00-00',
`zak` enum( 't', 'n' ) NOT NULL default 't',
`pspelem` varchar( 24 ) NOT NULL default '',
`teileno` int( 8 ) NOT NULL default '0',
`id_zam` int( 11 ) NOT NULL default '0',
`data_zam` datetime NOT NULL default '0000-00-00 00:00:00',
`id_otw` int( 11 ) NOT NULL default '0',
`data_otw` datetime NOT NULL default '0000-00-00 00:00:00',
`zakt` enum( 't', 'n' ) NOT NULL default 't',
`dostMD` varchar( 50 ) NOT NULL default '',
`konserwacja` varchar( 50 ) NOT NULL default '',
`TP` varchar( 40 ) NOT NULL default '',
`ktermin` date NOT NULL default '0000-00-00',
`kpartner` varchar( 50 ) NOT NULL default '',
`kdata` date NOT NULL default '0000-00-00',
PRIMARY KEY ( `lp` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 PACK_KEYS =0 COMMENT = 'Zlecenia-glowna tabela zlecen';

INSERT INTO `mve0test`.`zl_zlec`
SELECT *
FROM `mve0`.`zl_zlec` ;



#bbb in Engilsh… main database 


CREATE TABLE `ssgl` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`shop` INT NOT NULL ,
`shopimp` VARCHAR( 20 ) NOT NULL ,
`eod` DOUBLE( 10, 2 ) NOT NULL ,
`banking` DOUBLE( 10, 2 ) NOT NULL ,
`cc` DOUBLE( 10, 2 ) NOT NULL ,
`floatcf` DOUBLE( 10, 2 ) NOT NULL ,
`ondiff` DOUBLE( 10, 2 ) NOT NULL ,
`morncount` DOUBLE( 10, 2 ) NOT NULL ,
`trfsrin` DOUBLE( 10, 2 ) NOT NULL ,
`trfsrout` DOUBLE( 10, 2 ) NOT NULL ,
`ccc` DOUBLE( 10, 2 ) NOT NULL ,
`voucher` DOUBLE( 10, 2 ) NOT NULL ,
`checktotal` DOUBLE( 10, 2 ) NOT NULL ,
`sales1` DOUBLE( 10, 2 ) NOT NULL ,
`sales4` DOUBLE( 10, 2 ) NOT NULL ,
`sales7` DOUBLE( 10, 2 ) NOT NULL ,
`deposits` DOUBLE( 10, 2 ) NOT NULL ,
`staffpurch` DOUBLE( 10, 2 ) NOT NULL ,
`pchs2` DOUBLE( 10, 2 ) NOT NULL ,
`pchs5` DOUBLE( 10, 2 ) NOT NULL ,
`refunds3` DOUBLE( 10, 2 ) NOT NULL ,
`deporefunds` DOUBLE( 10, 2 ) NOT NULL ,
`staffrefunds` DOUBLE( 10, 2 ) NOT NULL ,
`shopexps` DOUBLE( 10, 2 ) NOT NULL ,
`smallchng` DOUBLE( 10, 2 ) NOT NULL ,
`otherpmnts` DOUBLE( 10, 2 ) NOT NULL ,
`statsctrl` DOUBLE( 10, 2 ) NOT NULL ,
`pchcasch` DOUBLE( 10, 2 ) NOT NULL ,
`pchscheck` DOUBLE( 10, 2 ) NOT NULL ,
`shopcheck` DOUBLE( 10, 2 ) NOT NULL ,
`oncheck` DOUBLE( 10, 2 ) NOT NULL 
) ENGINE = innodb;

#tablica BANKING
CREATE TABLE `ssbanking` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`shop` INT NOT NULL ,
`shopimp` VARCHAR( 20 ) NOT NULL ,
`bankingtotal` DOUBLE( 10, 2 ) NOT NULL ,
`cheques` DOUBLE( 10, 2 ) NOT NULL ,
`50` DOUBLE( 10, 2 ) NOT NULL ,
`20` DOUBLE( 10, 2 ) NOT NULL ,
`10` DOUBLE( 10, 2 ) NOT NULL ,
`5` DOUBLE( 10, 2 ) NOT NULL ,
`1` DOUBLE( 10, 2 ) NOT NULL ,
`echeq` DOUBLE( 10, 2 ) NOT NULL ,
`cash` DOUBLE( 10, 2 ) NOT NULL 
) ENGINE = innodb;



#tablica database - TOTAL to import from MDB



#tablica banking
CREATE TABLE `ssbankingday` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`date1` DATE NOT NULL ,
`shop` INT NOT NULL ,
`banking` ENUM( 'n', 'y' ) NOT NULL DEFAULT 'n'
) ENGINE = innodb;




#do poprawki:
ALTER TABLE `hd_log` CHANGE `lp` `lp` INT NOT NULL AUTO_INCREMENT
ALTER TABLE `hd_log` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `lp` ) ;





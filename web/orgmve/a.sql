# mve0 database structure changes

CREATE TABLE `paypunctuality` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `punctprc` int(11) NOT NULL default '0',
  `hours` double(10,2) NOT NULL default '0.00',
  `days` int(11) NOT NULL default '0',
  `daysintime` int(11) NOT NULL default '0',
  `type` enum('deduction','addition') NOT NULL default 'deduction',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Punctuality all deduction and addition' AUTO_INCREMENT=1 ;

CREATE TABLE `paybasicgross` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `hours` double(10,2) NOT NULL default '0.00',
  `hourspl` double(10,2) NOT NULL default '0.00',
  `hourlyrate` double(10,2) NOT NULL default '0.00',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Pay Basic Gross ' AUTO_INCREMENT=1 ;

CREATE TABLE `paybasic` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `hours` double(10,2) NOT NULL default '0.00',
  `hourlyrate` double(10,2) NOT NULL default '0.00',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Basic PAY' AUTO_INCREMENT=1 ;

CREATE TABLE `payholidays` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `sumhoursgiven` double(10,2) NOT NULL default '0.00',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Only to workout gross pay' AUTO_INCREMENT=1 ;

CREATE TABLE `paybonuses` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `hours` double(10,2) NOT NULL default '0.00',
  `prevbasicpay` double(10,2) NOT NULL default '0.00',
  `daysintime` int(11) NOT NULL default '0',
  `type` enum('5','7','BHM') NOT NULL default '5',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Punctuality all deduction and addition' AUTO_INCREMENT=1 ;

CREATE TABLE `paywendbonus` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `saturdaysalltodate` int(11) NOT NULL default '0',
  `sundaysalltodate` int(11) NOT NULL default '0',
  `holidaydaystodate` int(11) NOT NULL default '0',
  `weekenddaystodate` int(11) NOT NULL default '0',
  `stucture` enum('OLD','NEW') NOT NULL default 'OLD',
  `bonusyearstarted` date NOT NULL default '0000-00-00',
  `toadd` double(10,2) NOT NULL default '0.00',
  `wendbonus` double(10,2) NOT NULL default '0.00',
  `wrate` double(10,2) NOT NULL default '0.00',
  `weekendhours` double(10,2) NOT NULL default '0.00',
  `wdaysthismonth` double(10,2) NOT NULL default '0.00',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Punctuality all deduction and addition' AUTO_INCREMENT=3 ;

ALTER TABLE `pay` ADD `mygross` DOUBLE( 10, 2 ) NOT NULL ;

# updated 28-01-2007


CREATE TABLE `paywendlumpsum` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `weekendhours` double(10,2) NOT NULL default '0.00',
  `startdwls` date NOT NULL default '0000-00-00',
  `enddwls` date NOT NULL default '0000-00-00',
  `sageno` int(11) NOT NULL default '0',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Punctuality all deduction and addition' AUTO_INCREMENT=1 ;

# updated 29-01-2007

CREATE TABLE `paygross` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `monetarytotal` double(10,2) NOT NULL default '0.00',
  `idbasic` int(11) NOT NULL ,
  `idpunctuality` int(11) NOT NULL ,
  `idbonuses` int(11) NOT NULL ,
  `idholidays` int(11) NOT NULL ,
  `idwendbonus` int(11) NOT NULL ,
  `idwendlumpsum` int(11) NOT NULL ,
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Pay Gross ' AUTO_INCREMENT=1 ;

# updated 30-01-2007

ALTER TABLE `nombers` ADD `VCond3` ENUM( '1', '0' ) NOT NULL DEFAULT '0' AFTER `tocheck` ,
ADD `VCond375` ENUM( '1', '0' ) NOT NULL AFTER `VCond3` ,
ADD `VCond70` ENUM( '1', '0' ) NOT NULL AFTER `VCond375` ,
ADD `VE` DOUBLE(6,4) NOT NULL DEFAULT '0.00' AFTER `VCond70` ;

ALTER TABLE `nombers` ADD `VFV` DOUBLE(10,2) NOT NULL DEFAULT '0.00';

# updated 31-01-2007

CREATE TABLE `payvoucher` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `vouchersdue` double(10,2) NOT NULL default '0.00',
  `taxablevouchers` double(10,2) NOT NULL default '0.00',
  `voucherpayment` double(10,2) NOT NULL default '0.00',
  `basicgros` double(10,2) NOT NULL default '0.00',
  `gross` double(10,2) NOT NULL default '0.00',
  `tvsageded` int(11) NOT NULL default '0',
  `tvsagepay` int(11) NOT NULL default '0',
  `vpsageded` int(11) NOT NULL default '0',
  `withold` enum('y','n') NOT NULL default 'n',
  `date1` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `no` (`no`,`date1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Punctuality all deduction and addition' AUTO_INCREMENT=1 ;

$VoucherDueWH 
$VoucherPaymentWH
$TaxebleVouchersWH
$VoucherDueWH

$VoucherPayment
$TaxebleVouchers 
$VoucherDue
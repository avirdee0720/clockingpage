

# inserts
INSERT INTO `paybasic` (`id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1`)
INSERT INTO `paybasicgross` (`id`, `no`, `monetarytotal`, `hours`, `hourspl`, `hourlyrate`, `sageno`, `date1`) 
INSERT INTO `paybonuses` (`id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1`)
INSERT INTO `payholidays` (`id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1`)
INSERT INTO `paypunctuality` (`id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1`)
INSERT INTO `paywendbonus` (`id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, 
			`bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1`)
INSERT INTO `paywendlumpsum` (`id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1`) 

# selects
SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0
#SELECT `id`, `no`, `monetarytotal`, `hours`, `hourspl`, `hourlyrate`, `sageno`, `date1` FROM `paybasicgross`  WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0
SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0
SELECT `id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1` FROM `payholidays` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0
SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0
SELECT `id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, 
			`bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1` FROM `paywendbonus` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `wendbonus`<>0
SELECT `id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1` FROM `paywendlumpsum` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0

#delete
DELETE FROM `paybasic` 
DELETE FROM `paybasicgross`  
DELETE FROM `paybonuses` 
DELETE FROM `payholidays` 
DELETE FROM `paypunctuality` 
DELETE FROM `paywendbonus` 
DELETE FROM `paywendlumpsum` 
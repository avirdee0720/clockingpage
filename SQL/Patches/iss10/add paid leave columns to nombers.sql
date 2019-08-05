ALTER TABLE `nombers`
	ADD COLUMN `paid_leave_agreed_to` INT(1) NOT NULL DEFAULT 0 AFTER `assessment`,
	ADD COLUMN `paid_leave_estimate` DECIMAL(10,0) NULL DEFAULT NULL AFTER `paid_leave_agreed_to`;
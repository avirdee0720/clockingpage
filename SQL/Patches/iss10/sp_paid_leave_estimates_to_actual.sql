drop procedure if exists paid_leave_estimates_to_actual;

delimiter $$

create procedure paid_leave_estimates_to_actual()
BEGIN
	DECLARE finished INT DEFAULT 0;
	DECLARE vs_id INT;
	DECLARE days DOUBLE(5,2);
	
	DECLARE cur CURSOR FOR
	select vs.id,
		   round(round(n.paid_leave_estimate * 0.1207, 2) / round(total_hours_worked(n.pno, '2017-12-01', '2018-11-30') / total_days_worked(n.pno, '2017-12-01', '2018-11-30'), 2), 2) AS paid_leave_days_actual	
	from nombers n join voucherslips vs
		on n.pno = vs.`no` and vs.`id` = (SELECT MAX(vs1.`id`) FROM voucherslips vs1 WHERE vs1.`no` = n.pno)
	where n.paid_leave_estimate is not null;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
	
	OPEN cur;	
	WHILE finished = 0 DO
		FETCH cur INTO vs_id, days;
		
		UPDATE voucherslips
		SET EinDays = days
		WHERE id = vs_id;		
	END WHILE;
	CLOSE cur;	
END$$

delimiter ;
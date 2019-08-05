
DROP FUNCTION IF EXISTS total_hours_worked;

DELIMITER $$

-- Returns employee''s total hours worked over the indicated period.
CREATE FUNCTION total_hours_worked(emp_no INT, start_date DATE, end_date DATE)
RETURNS DECIMAL(10, 2)
BEGIN
	RETURN
		(SELECT IFNULL(SUM(TIME_TO_SEC(TIMEDIFF(iot.outtime, iot.intime))) / 3600, 0)
		   FROM `inout` iot
		  WHERE iot.`no` = emp_no
            AND iot.outtime <> '00:00:00'
		    AND iot.date1 BETWEEN start_date AND end_date);
END$$

DELIMITER ;
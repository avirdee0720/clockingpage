
DROP FUNCTION IF EXISTS total_days_worked;

DELIMITER $$

-- Returns employee's total days he or she came to work over the indicated period.
CREATE FUNCTION total_days_worked(emp_no INT, start_date DATE, end_date DATE)
RETURNS INT
BEGIN
	RETURN
		(SELECT COUNT(DISTINCT date1)
	       FROM `inout` iot
	      WHERE iot.no = emp_no
		    AND iot.date1 BETWEEN start_date AND end_date);
END$$

DELIMITER ;
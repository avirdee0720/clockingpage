
DROP FUNCTION IF EXISTS date_month_end;

DELIMITER $$

-- Returns end date of the month going back 'months' months ago from 'from_date'.
-- Months = 0 means current month, 'from_date' = NULL means today.
CREATE FUNCTION date_month_end(months INT, from_date DATE)
RETURNS DATE
BEGIN
	IF from_date IS NULL THEN
		SET from_date := (SELECT CURDATE());
	END IF;
	RETURN
		(SELECT LAST_DAY(DATE_ADD(from_date, INTERVAL months MONTH)));
END$$

DELIMITER ;
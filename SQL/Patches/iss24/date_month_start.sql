
DROP FUNCTION IF EXISTS date_month_start;

DELIMITER $$

-- Returns start date of the month going back 'months' months from 'from_date'.
-- Months = 0 means current month, 'from_date' = NULL means today.
-- For example date_month_start(-1, NULL) is 1st of the last month, date_month_start(-2, '2018-02-06') is start of Dec 2017.
CREATE FUNCTION date_month_start(months INT, from_date DATE)
RETURNS DATE
BEGIN
	IF from_date IS NULL THEN
		SET from_date := (SELECT CURDATE());
	END IF;
    SET from_date := DATE_ADD(from_date, INTERVAL months MONTH);
	RETURN
		(SELECT STR_TO_DATE(CONCAT(YEAR(from_date), '-', MONTH(from_date),'-', '1'), '%Y-%m-%d'));
END$$

DELIMITER ;

DROP FUNCTION IF EXISTS date_week_start;

DELIMITER $$

-- Returns start date of the week (of Monday) adding or subtracting 'weeks' weeks from 'from_date'.
-- Weeks = 0 means current week in regards to from_date, 'from_date' = NULL means today.
-- For example date_week_start(-1, NULL) is last Monday.
CREATE FUNCTION date_week_start(weeks INT, from_date DATE)
RETURNS DATE
BEGIN
	IF from_date IS NULL THEN
		SET from_date := (SELECT CURDATE());
	END IF;
	RETURN
		(SELECT DATE_ADD(DATE_SUB(from_date, INTERVAL WEEKDAY(from_date) DAY), INTERVAL weeks WEEK));
END$$

DELIMITER ;
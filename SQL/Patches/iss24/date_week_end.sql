
DROP FUNCTION IF EXISTS date_week_end;

DELIMITER $$

-- Returns end date of the week (of Sunday) going back 'weeks' weeks from 'from_date'.
-- Weeks = 0 means current week in regards to from_date, 'from_date' = NULL means today.
-- For example date_week_end(-1, NULL) is last Sunday.
CREATE FUNCTION date_week_end(weeks INT, from_date DATE)
RETURNS DATE
BEGIN
	IF from_date IS NULL THEN
		SET from_date := (SELECT CURDATE());
	END IF;
	RETURN
		(SELECT DATE_ADD(DATE_ADD(from_date, INTERVAL 6 - WEEKDAY(from_date) DAY), INTERVAL weeks WEEK));
END$$

DELIMITER ;
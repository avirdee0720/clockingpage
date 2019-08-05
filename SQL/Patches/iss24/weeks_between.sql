
DROP FUNCTION IF EXISTS weeks_between;

DELIMITER $$

-- Returns the number of full weeks between the two input dates (no rounding, returns only full weeks).
CREATE FUNCTION weeks_between(from_date DATE, to_date DATE)
RETURNS INT
BEGIN
	RETURN
		(FLOOR(DATEDIFF(to_date, from_date) + 1) / 7);
END$$

DELIMITER ;

DROP FUNCTION IF EXISTS get_next_in_number_series;

/*
Returns the next value in number series. After change of month, the value will reset to 1.
*/

DELIMITER $$

CREATE FUNCTION get_next_in_number_series ()
RETURNS VARCHAR(12)
BEGIN
	DECLARE series_month, current_month VARCHAR(4);
    DECLARE next_num SMALLINT;
    
	SET series_month := (SELECT `value` FROM defaultvalues WHERE `code` = 'numseriesmonth');
	SET current_month := (SELECT DATE_FORMAT(CURDATE(), '%m%y'));
    
    IF series_month = current_month THEN
		UPDATE defaultvalues
		SET `value` = `value` + 1
		WHERE `code` = 'numseries';
        
        SET next_num := (SELECT `value` FROM defaultvalues WHERE `code` = 'numseries');
	ELSE -- a new month has started, need to reset numbering
		UPDATE defaultvalues
		SET `value` = current_month
		WHERE `code` = 'numseriesmonth';
        
        UPDATE defaultvalues
		SET `value` = 1
		WHERE `code` = 'numseries';
        
        SET series_month := current_month;
        SET next_num := 1;
    END IF;
    
	RETURN CONCAT('MGE', series_month, '_' , LPAD(next_num, 4, '0'));
END$$

DELIMITER ;

DROP FUNCTION IF EXISTS date_range_emp_full_weeks;

DELIMITER $$

/*
Finds a date by subtracting 'weeks' weeks from 'from_date'. If the start of the employment of the employee designated by emp_no is
bigger than this date meaning the employee has worked less than the number of weeks then returns the Monday of the week the employee
started the employment as period start and the last Sunday before the week of the from_date as period end.

If the start of employment is smaller then returns Monday of the week of the found date as period start and last Sunday before
the week of the from_date as period end.

Lastly, returns the number of full weeks between the calculated period start and end dates. It is the same number as inputed weeks if
the employee has worked more than the number of weeks, less otherwise.

If from_date is NULL today is assumed.
*/

CREATE FUNCTION date_range_emp_full_weeks(emp_no INT, weeks INT, from_date DATE)
RETURNS VARCHAR(250)
BEGIN
	DECLARE from_date_weeks_ago DATE;
    DECLARE employment_start DATE;
    DECLARE employment_start_monday DATE;
    DECLARE period_start DATE;
    DECLARE period_end DATE;
    DECLARE period_weeks INT;
	
    IF from_date IS NULL THEN
		SET from_date := (SELECT CURDATE());
	END IF;
    
    SET from_date_weeks_ago := (SELECT DATE_SUB(from_date, INTERVAL weeks WEEK));
    SET employment_start := (SELECT started FROM nombers WHERE pno = emp_no);
    SET employment_start_monday := (DATE_SUB(employment_start, INTERVAL WEEKDAY(employment_start) DAY));
    
    SET period_start := (
		SELECT CASE WHEN employment_start > from_date_weeks_ago
					THEN employment_start_monday
                    ELSE date_week_start(-weeks, from_date)
               END);    
	
    SET period_end := (date_week_end(-1, from_date));
	
	SET period_weeks := (
		SELECT CASE WHEN employment_start > from_date_weeks_ago
			        THEN weeks_between(employment_start_monday, period_end)
			   ELSE weeks
		       END);
	-- might happen if employment_start_monday is in the future because employment_start is in the future
	IF (period_weeks < 0) THEN SET period_weeks := 0; END IF;
    
    RETURN CONCAT(IFNULL(period_start, ''), ';', IFNULL(period_end, ''), ';', IFNULL(period_weeks, ''));
END$$

DELIMITER ;
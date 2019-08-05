
DROP FUNCTION IF EXISTS current_paid_leave_entitlement_explanation;

/*
Returns employee's total paid leave entitlement with calculation details. The calculation is done in regards to the cur_date value, if
it's NULL the calculation will be in regards to today.

Formula:
1. Average daily hours in the previous paid leave year * number of weeks remaining in current paid leave year +
   total hours worked so far in current paid leave year = estimated total hours for the whole of current paid leave year
2. Result from (1) * 12.07 / 100 = paid leave entitlement in hours
3. Result from (2) / average daily hours in previous paid leave year = current paid leave entitlement in days
*/

DELIMITER $$

CREATE FUNCTION current_paid_leave_entitlement_explanation(emp_no INT, cur_date DATE)
RETURNS VARCHAR(250)
BEGIN
	-- all DECLARE's have to be first statements after BEGIN
	DECLARE employment_start_date DATE;
	DECLARE employed_more_than_a_year TINYINT;
	DECLARE prev_paid_leave_year_start DATE;
	DECLARE prev_paid_leave_year_end DATE;
	DECLARE total_hours_prev_paid_leave_year DECIMAL(10, 2);
	DECLARE total_days_prev_paid_leave_year INT;
	DECLARE weekly_avg_hours_prev_paid_leave_year DECIMAL(10, 2);
	DECLARE daily_avg_hours_prev_paid_leave_year DECIMAL(10, 2);    
	DECLARE cur_paid_leave_year INT;
	DECLARE cur_paid_leave_year_start DATE;
	DECLARE cur_paid_leave_year_end DATE;
	DECLARE cur_week_start DATE;
	DECLARE last_full_week_end_in_paid_leave_year DATE;
	DECLARE weeks_to_go INT; -- full weeks left in current paid leave year
	DECLARE last_sunday DATE;
	DECLARE total_hours_cur_leave_year DECIMAL(10, 2);
	DECLARE res DECIMAL(10, 2);
	
	SET res := 0;

	IF cur_date IS NULL THEN
		SET cur_date := (SELECT CURDATE());
	END IF;
	SET employment_start_date := (SELECT started FROM nombers WHERE pno = emp_no);
	SET employed_more_than_a_year := (SELECT IF(DATE_SUB(cur_date, INTERVAL 1 YEAR) < employment_start_date, 0, 1));
	
	IF employed_more_than_a_year THEN
		SET prev_paid_leave_year_start := (SELECT CASE WHEN MONTH(cur_date) = 12 THEN CONCAT(YEAR(cur_date) - 1, '-12-01') ELSE CONCAT(YEAR(cur_date) - 2, '-12-01') END);
		SET prev_paid_leave_year_end := (SELECT CASE WHEN MONTH(cur_date) = 12 THEN CONCAT(YEAR(cur_date), '-11-30') ELSE CONCAT(YEAR(cur_date) - 1, '-11-30') END);
		
		SET total_hours_prev_paid_leave_year := (SELECT total_hours_worked(emp_no, prev_paid_leave_year_start, prev_paid_leave_year_end));
		IF total_hours_prev_paid_leave_year > 0 THEN
			SET total_days_prev_paid_leave_year := (SELECT total_days_worked(emp_no, prev_paid_leave_year_start, prev_paid_leave_year_end));
			IF total_days_prev_paid_leave_year > 0 THEN
				SET weekly_avg_hours_prev_paid_leave_year := (SELECT ROUND(total_hours_prev_paid_leave_year / 52, 2));
				SET daily_avg_hours_prev_paid_leave_year := (SELECT ROUND(total_hours_prev_paid_leave_year / total_days_prev_paid_leave_year, 2));
					
				SET cur_paid_leave_year := (SELECT CASE WHEN MONTH(cur_date) = 12 THEN YEAR(cur_date) + 1 ELSE YEAR(cur_date) END);
				SET cur_paid_leave_year_start := (SELECT CONCAT(cur_paid_leave_year - 1, '-12-01'));
				SET cur_paid_leave_year_end := (SELECT CONCAT(cur_paid_leave_year, '-11-30'));
		        SET cur_week_start := (SELECT DATE_SUB(cur_date, INTERVAL WEEKDAY(cur_date) DAY));
		        SET last_full_week_end_in_paid_leave_year := (SELECT DATE_SUB(cur_paid_leave_year_end, INTERVAL WEEKDAY(cur_paid_leave_year_end) + 1 DAY));
		          -- last_full_week_end_in_paid_leave_year is Sunday, cur_week_start is Monday, adding 1 to last_full_week_end_in_paid_leave_year
		          -- makes it that the DATEDIFF / 7 returns whole number, FLOOR is just to get the integer part
				SET weeks_to_go := (SELECT FLOOR(DATEDIFF(cur_paid_leave_year_end, cur_date) / 7));
				SET last_sunday := (SELECT DATE_SUB(cur_date, INTERVAL 1 + WEEKDAY(cur_date) DAY));
				SET total_hours_cur_leave_year := (SELECT total_hours_worked(emp_no, cur_paid_leave_year_start, last_sunday));
				
				SET res := (SELECT ROUND((weekly_avg_hours_prev_paid_leave_year * weeks_to_go + total_hours_cur_leave_year) * 0.1207 / daily_avg_hours_prev_paid_leave_year, 2));
			END IF;
		END IF;
	END IF;
	
	RETURN CONCAT(IFNULL(cur_date, ''), ';', IFNULL(employment_start_date, ''), ';', IFNULL(employed_more_than_a_year, ''), ';',
		IFNULL(prev_paid_leave_year_start, ''), ';', IFNULL(prev_paid_leave_year_end, ''), ';', IFNULL(total_hours_prev_paid_leave_year, ''), ';',
		IFNULL(total_days_prev_paid_leave_year, ''), ';',
	    IFNULL(weekly_avg_hours_prev_paid_leave_year, ''), ';', IFNULL(daily_avg_hours_prev_paid_leave_year, ''), ';',
		IFNULL(cur_paid_leave_year, ''), ';',
	    IFNULL(cur_paid_leave_year_start, ''), ';', IFNULL(cur_paid_leave_year_end, ''), ';', IFNULL(cur_week_start, ''), ';',
	    IFNULL(last_full_week_end_in_paid_leave_year, ''), ';', IFNULL(weeks_to_go, ''), ';',
	    IFNULL(total_hours_cur_leave_year, ''), ';', IFNULL(res, ''));
END$$

DELIMITER ;
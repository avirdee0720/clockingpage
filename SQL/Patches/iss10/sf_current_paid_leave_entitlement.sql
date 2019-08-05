
DROP FUNCTION IF EXISTS current_paid_leave_entitlement;

/*
Returns employee's total paid leave entitlement for the current leave year.

Formula:
1. Average daily hours in the preceding 13 weeks * number of weeks remaining in paid leave year + total hours worked so far this paid leave year = estimated total hours for the whole of paid leave year
2. Result from (1) * 12.07 / 100 = paid leave entitlement in hours
3. Result from (2) / average daily hours in preceding 13 weeks = paid leave entitlement in days

Preceding 13 weeks means last full 13 weeks before today, ending with last Sunday. Paid leave year is from 1st of December till 30 of November. Average daily hours means the sum of all hours worked in the period
divided by number of days worked in the period.

The formula is valid only if the employee has been employed for more than 1 year. If employed less the entitlement is 0.
*/

DELIMITER $$

CREATE FUNCTION current_paid_leave_entitlement(emp_no INT)
RETURNS DECIMAL(10, 2)
BEGIN
	-- all DECLARE's have to be the first statements after BEGIN
    DECLARE cur_date DATE;
    DECLARE employment_start_date DATE;
    DECLARE employed_more_than_a_year TINYINT;
    DECLARE start_date_13w DATE;
    DECLARE end_date_13w DATE;
    DECLARE total_hours_13w DECIMAL(10, 2);
    DECLARE total_days_13w INT;
    DECLARE weekly_avg_hours_13w DECIMAL(10, 2);
    DECLARE daily_avg_hours_13w DECIMAL(10, 2);
    DECLARE cur_paid_leave_year INT;
    DECLARE cur_paid_leave_year_start DATE;
    DECLARE cur_paid_leave_year_end DATE;
    DECLARE cur_week_start DATE;
    DECLARE last_full_week_end_in_paid_leave_year DATE;
    DECLARE weeks_to_go INT; -- full weeks left in current paid leave year
    DECLARE total_hours_cur_leave_year DECIMAL(10, 2);
    DECLARE res DECIMAL(10, 2);
    
    SET res := 0;
    
    SET cur_date := (SELECT CURDATE());
    SET employment_start_date := (SELECT started FROM nombers WHERE pno = emp_no);
    SET employed_more_than_a_year := (SELECT IF(DATE_SUB(cur_date, INTERVAL 1 YEAR) < employment_start_date, 0, 1));
    
    IF employed_more_than_a_year THEN
		SET start_date_13w := (SELECT DATE_SUB(cur_date, INTERVAL 13 * 7 + WEEKDAY(cur_date) DAY));
		SET end_date_13w := (SELECT DATE_SUB(cur_date, INTERVAL 1 + WEEKDAY(cur_date) DAY));
		
		SET total_hours_13w := (SELECT total_hours_worked(emp_no, start_date_13w, end_date_13w));        
		IF total_hours_13w > 0 THEN
			SET total_days_13w := (SELECT total_days_worked(emp_no, start_date_13w, end_date_13w));
			IF total_days_13w > 0 THEN
				SET weekly_avg_hours_13w := (SELECT ROUND(total_hours_13w / 13, 2));
				SET daily_avg_hours_13w := (SELECT ROUND(total_hours_13w / total_days_13w, 2));
					
				SET cur_paid_leave_year := (SELECT CASE EXTRACT(MONTH FROM cur_date) WHEN 12 THEN EXTRACT(YEAR FROM cur_date) + 1
																					 ELSE EXTRACT(YEAR FROM cur_date) END);
				SET cur_paid_leave_year_start := (SELECT CONCAT(cur_paid_leave_year - 1, '-12-01'));
				SET cur_paid_leave_year_end := (SELECT CONCAT(cur_paid_leave_year, '-11-30'));
                SET cur_week_start := (SELECT DATE_SUB(cur_date, INTERVAL WEEKDAY(cur_date) DAY));
                SET last_full_week_end_in_paid_leave_year := (SELECT DATE_SUB(cur_paid_leave_year_end, INTERVAL WEEKDAY(cur_paid_leave_year_end) + 1 DAY));
                -- last_full_week_end_in_paid_leave_year is Sunday, cur_week_start is Monday, adding 1 to last_full_week_end_in_paid_leave_year
                -- makes it that the DATEDIFF / 7 returns whole number, FLOOR is just to get the integer part
				SET weeks_to_go := (SELECT FLOOR(DATEDIFF(cur_paid_leave_year_end, cur_date) / 7));
				SET total_hours_cur_leave_year := (SELECT total_hours_worked(emp_no, cur_paid_leave_year_start, cur_date));
				
				SET res := (SELECT ROUND((weekly_avg_hours_13w * weeks_to_go + total_hours_cur_leave_year) * 0.1207 / daily_avg_hours_13w, 2));
			END IF;
		END IF;
	END IF;
    
    RETURN res;
END$$

DELIMITER ;
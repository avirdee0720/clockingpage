
DROP FUNCTION IF EXISTS total_hours_worked_with_holiday;

/*
Returns employee's total hours worked and on holiday counting back from the cur_date value, if
it's NULL the calculation will be in regards to today.
*/

DELIMITER $$

CREATE FUNCTION total_hours_worked_with_holiday(emp_no INT, cur_date DATE)
RETURNS VARCHAR(250)
BEGIN
    DECLARE regular TINYINT;
    DECLARE start_date DATE;
    DECLARE end_date DATE;
    DECLARE weeks TINYINT;
    DECLARE week_no TINYINT;
    DECLARE casual_first_day_worked DATE;
    DECLARE hours_worked INT;
    DECLARE hours_on_holiday INT;
    DECLARE total_days INT;
    DECLARE total_hours DECIMAL(10, 2);
    DECLARE avg_hours DECIMAL(10, 2);

    IF cur_date IS NULL THEN
		SET cur_date = (SELECT CURDATE());
	END IF;
    SET regular = (SELECT IF((SELECT cat FROM nombers WHERE pno = emp_no) = 'c', 0, 1));

    IF regular THEN -- employee with regular days, i.e. regular
		-- regulars get hours from last full leave year and do not include holiday hours
        -- start_date = 1st of Dec of previous leave year
        SET start_date = (SELECT CASE WHEN MONTH(cur_date) = 12 THEN CONCAT(YEAR(cur_date) - 1, '-12-01') ELSE CONCAT(YEAR(cur_date) - 2, '-12-01') END);
        -- end_date = 30th of Nov of previous leave year
		SET end_date = (SELECT CASE WHEN MONTH(cur_date) = 12 THEN CONCAT(YEAR(cur_date), '-11-30') ELSE CONCAT(YEAR(cur_date) - 1, '-11-30') END);
        -- weeks = number of weeks between start_date and end_date
        -- add one day to end_date to get number of days from start to end, not between
        SET weeks = (SELECT FLOOR(DATEDIFF(DATE_ADD(end_date, INTERVAL 1 DAY), start_date) / 7));
		SET total_hours = (SELECT total_hours_worked(emp_no, start_date, end_date));
        SET total_days = (SELECT total_days_worked(emp_no, start_date, end_date));
        IF total_days > 0 THEN
			-- for regulars, average hours per day
			SET avg_hours = (SELECT ROUND(total_hours / total_days, 2));
		ELSE
            -- in case the employee started work in current leave year there are no hours from last leave year
            -- so hours from current leave year are taken instead
            
            -- start_date = 1st of Dec of current leave year
            SET start_date := (SELECT CASE WHEN MONTH(cur_date) = 12 THEN CONCAT(YEAR(cur_date), '-12-01') ELSE CONCAT(YEAR(cur_date) - 1, '-12-01') END);
            -- end_date = cur_date (= today in most cases)
            SET end_date = cur_date;
            SET weeks = (SELECT FLOOR(DATEDIFF(DATE_ADD(end_date, INTERVAL 1 DAY), start_date) / 7));
            SET total_hours = (SELECT total_hours_worked(emp_no, start_date, end_date));
            SET total_days = (SELECT total_days_worked(emp_no, start_date, end_date));
            IF total_days > 0 THEN                
			    SET avg_hours = (SELECT ROUND(total_hours / total_days, 2));
		    ELSE
			    SET avg_hours = 0;
            END IF;
		END IF;
	ELSE -- employee with no regular days, i.e. casual
		-- casuals get hours from last full 12 worked weeks and include holiday hours
        -- a week is considered 'worked' if casual has clocked in at least once in the week
        -- a week is also considered 'worked' if casual has taken a holiday during the week
        SET weeks = 12;        
        SET casual_first_day_worked = (SELECT MIN(date1) FROM `inout` WHERE `no` = emp_no);

        IF (casual_first_day_worked IS NULL) THEN
            -- hasn't started to work yet
            SET total_hours = 0;
            SET avg_hours = 0;
        ELSE
            -- initial end_date = Sunday of the last week counting back from cur_date
            SET end_date = (SELECT DATE_SUB(cur_date, INTERVAL 1 + WEEKDAY(cur_date) DAY));
            -- initial start_date = Monday of the last week counting back from cur_date
            SET start_date = (SELECT DATE_SUB(end_date, INTERVAL 6 DAY));

            SET week_no = 1;
            SET hours_worked = 0;
            SET hours_on_holiday = 0;
            SET total_hours = 0;
            WHILE (week_no <= weeks) && (end_date >= casual_first_day_worked) DO		      
                SET hours_worked = (SELECT total_hours_worked(emp_no, start_date, end_date));
                SET hours_on_holiday = (
                    SELECT SUM(hourgiven)
                    FROM holidays
                    WHERE `no` = emp_no
                      AND date1 BETWEEN start_date AND end_date
                );
                IF (hours_worked > 0) || (hours_on_holiday > 0) THEN
                    SET total_hours = total_hours + IFNULL(hours_worked, 0) + IFNULL(hours_on_holiday, 0);
                    SET week_no = week_no + 1;
                END IF;
                SET end_date := (SELECT DATE_SUB(start_date, INTERVAL 1 DAY));
                SET start_date := (SELECT DATE_SUB(end_date, INTERVAL 6 DAY));
            END WHILE;
            -- for casuals, average hours per week
            SET avg_hours = (SELECT ROUND(total_hours / weeks, 2));
        END IF;        
    END IF;

    RETURN CONCAT(IFNULL(cur_date, ''), ';', IFNULL(regular, ''), ';', IFNULL(start_date, ''), ';',
		IFNULL(end_date, ''), ';', IFNULL(weeks, ''), ';', IFNULL(total_hours, ''), ';', IFNULL(avg_hours, ''));
END$$

DELIMITER ;
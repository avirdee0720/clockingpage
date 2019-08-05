
DROP FUNCTION IF EXISTS toggle_empl_dot; 

DELIMITER $$

-- Toggles the dot in employees category name for display in clocking screen.
-- Employees with dot are counted as shop staff.
CREATE FUNCTION toggle_empl_dot(emp_no INT, has_dot BIT)
RETURNS INT
BEGIN
	IF has_dot THEN
		UPDATE nombers
		SET cattoname = IF (cattoname IS NOT NULL AND TRIM(cattoname) NOT LIKE '', 
		 				 		  CASE WHEN LOCATE(' ', cattoname) > 0 THEN INSERT(cattoname, LOCATE(' ', cattoname), 0, '.')
 	         						 ELSE CONCAT(cattoname, '.') END,
							     cattoname)
		WHERE pno = emp_no
		  AND cattoname NOT LIKE '%.%';
	ELSE
		UPDATE nombers
		SET cattoname = CASE WHEN LOCATE('. ', cattoname) THEN REPLACE(cattoname, '.', '')
								   ELSE REPLACE(cattoname, '.', ' ') END
		WHERE pno = emp_no
		  AND cattoname LIKE '%.%';
	END IF;
	RETURN 0;
END$$

DELIMITER ;
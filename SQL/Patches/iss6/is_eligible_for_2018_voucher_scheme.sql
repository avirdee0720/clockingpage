
DROP FUNCTION IF EXISTS is_eligible_for_2018_voucher_scheme;

/*
Returns 1 if employee no emp_no is eligible to receive vouchers as per 2018 voucher scheme, 0 otherwise.
*/

DELIMITER $$

CREATE FUNCTION is_eligible_for_2018_voucher_scheme(emp_no INT)
RETURNS BOOL
BEGIN
    RETURN
		(SELECT CASE WHEN ((VCond3 = 1) or (VCond375 = 1)) and (VCond70 = 1) and (VE > 0) THEN 1 ELSE 0 END
		 FROM nombers
		 WHERE pno = emp_no);
END$$

DELIMITER ;
DELIMITER $$
CREATE FUNCTION my_sum(num1 INT, num2 INT)
	RETURNS INT
BEGIN
	RETURN num1 + num2;
END $$
DELIMITER $$

SHOW FUNCTION STATUS;
;
SELECT my_sum(100, 2)
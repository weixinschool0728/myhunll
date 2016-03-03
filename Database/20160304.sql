SET GLOBAL event_scheduler =  "ON";

DROP PROCEDURE  `check_30_order_time_out` ;

CREATE DEFINER =  `root`@`localhost` PROCEDURE  `check_30_order_time_out` ( ) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN DECLARE createtime INT DEFAULT UNIX_TIMESTAMP( NOW( ) ) -60 *30;

DECLARE _order_id INT DEFAULT 0;

SELECT order_id
INTO _order_id
FROM m_order
WHERE created <= createtime
AND pay_status =0
AND  `status` =1
AND deleted =0
LIMIT 1 ;

UPDATE m_order SET  `status` =4 WHERE order_id = _order_id AND deleted =0;

END


DROP EVENT `order_per_30_check_event` ;

CREATE DEFINER =  `root`@`localhost` EVENT `order_per_30_check_event` ON SCHEDULE EVERY2 SECOND STARTS '2016-03-02 00:00:00'ENDS '2026-03-02 00:00:00' ON COMPLETION PRESERVE ENABLE DO call check_30_order_time_out(
);

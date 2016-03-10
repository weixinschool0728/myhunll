
ALTER TABLE `m_order` CHANGE `pay_status` `pay_status` TINYINT( 4 ) NOT NULL DEFAULT '0' COMMENT '支付状态 0：未支付; 1：已支付;2：申请退款3：退款成功';

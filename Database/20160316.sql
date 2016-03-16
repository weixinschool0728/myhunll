ALTER TABLE  `m_users` CHANGE  `daijinjuan`  `daijinjuan` MEDIUMINT( 5 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '代金卷';
ALTER TABLE `m_users` CHANGE `daijinjuan` `daijinjuan` DECIMAL( 10, 2 ) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '代金卷';
ALTER TABLE `m_order` ADD `daijinjuan` DECIMAL( 10, 2 ) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '抵扣代金券' AFTER `price` ;
ALTER TABLE `m_order` ADD `dues` DECIMAL( 10, 2 ) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '实际应付款' AFTER `daijinjuan` ;

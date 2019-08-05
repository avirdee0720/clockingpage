CREATE TABLE `memo0` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `memo_clno` int(10) NOT NULL DEFAULT '0',\n  `memo_type` int(5) NOT NULL DEFAULT '1',\n  `memo_date` date NOT NULL DEFAULT '9999-12-31',\n  `memo_time` time NOT NULL DEFAULT '00:00:00',\n  `memo_text` varchar(255) DEFAULT NULL,\n  `memo_state` int(5) NOT NULL DEFAULT '1',\n  `cur_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=655 DEFAULT CHARSET=latin1 COMMENT='Memo table'
CREATE TABLE `customer_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `meter_reading_date` date NOT NULL,
  `meter_reading` varchar(25) NOT NULL,
  `water_used` float NOT NULL,
  `amount` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
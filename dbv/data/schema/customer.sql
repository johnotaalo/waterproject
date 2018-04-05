CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `othernames` varchar(150) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `emailaddress` varchar(150) NOT NULL,
  `town` varchar(150) NOT NULL,
  `plotnumber` varchar(30) NOT NULL,
  `supply_location` varchar(100) NOT NULL,
  `meter_no` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
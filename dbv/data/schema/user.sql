CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `emailaddress` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(15) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`emailaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
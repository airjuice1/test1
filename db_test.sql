CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mother_id` int(11) DEFAULT NULL COMMENT 'id матери	',
  `spouse_id` int(11) DEFAULT NULL COMMENT 'id супруга(супруги)',
  `lastname` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `age` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `person` VALUES 
(1,NULL,4,'Иванов','Иван',40),
(2,4,NULL,'Иванов','Вася',4),
(3,4,NULL,'Иванова','Даша',6),
(4,NULL,1,'Иванова','Мария',32),
(5,NULL,NULL,'Петров','Петр',46),
(6,NULL,8,'Сидоров','Сандро',46),
(7,NULL,NULL,'Сидорова','Елена',40),
(8,NULL,6,'Волкова','Ксения',39),
(9,8,NULL,'Волкова','Настя',9);



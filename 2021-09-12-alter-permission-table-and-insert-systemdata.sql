ALTER TABLE `newschool`.`roles` AUTO_INCREMENT=50; 

INSERT INTO `newschool`.`roles` (`id`, `name`, `is_system`) VALUES ('8', 'Level Coordinator', '1');
INSERT INTO `newschool`.`roles` (`id`, `name`, `is_system`) VALUES ('9', 'School Director', '1');

ALTER TABLE `newschool`.`levels` ADD COLUMN `coordinator_id` INT(11) NULL AFTER `level`; 

CREATE TABLE `class_rooms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `room` VARCHAR(60) NOT NULL,
  `staff_id` INT(11) NOT NULL,
  `class_id` INT(11) NOT NULL,
  `section_id` INT(11) NOT NULL,
  `session_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

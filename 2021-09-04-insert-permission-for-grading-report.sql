INSERT INTO `permission_group` (`name`, `short_code`, `is_active`, `system`) VALUES ('Grading Report', 'grading_report', '1', '0'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('32', 'Grading Competences', 'grading_report_competences', '1'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('32', 'Grading Indicators', 'grading_report_indicators', '1'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('32', 'Grading Results', 'grading_report_results', '1'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('32', 'Value Scale', 'grading_report_valuescale', '1'); 

CREATE TABLE `grading_competences` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) DEFAULT NULL,
  `session_id` INT(11) NOT NULL,
  `class_id` INT(11) NOT NULL,
  `period_id` INT(11) NOT NULL,
  `is_active` VARCHAR(255) DEFAULT 'no',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `updated_at` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `grading_indicators` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) DEFAULT NULL,
  `competence_id` INT(11) NOT NULL,
  `is_active` VARCHAR(255) DEFAULT 'no',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `updated_at` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `grading_markers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_session_id` INT(11) NOT NULL,
  `indicators_id` INT(11) NOT NULL,
  `marks` INT(11) NOT NULL,
  `is_active` VARCHAR(255) DEFAULT 'no',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  `updated_at` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `start_month` varchar(24) DEFAULT NULL,
  `end_month` varchar(24) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;


CREATE TABLE `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(60) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

CREATE TABLE `value_scale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `marks` int(11) NOT NULL,
  `symbol` varchar(24) DEFAULT 'O',
  `class_id` int(11) NOT NULL DEFAULT 0,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

CREATE TABLE `level_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

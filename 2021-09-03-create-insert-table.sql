
INSERT INTO `permission_group` (`name`, `short_code`, `is_active`, `system`) VALUES ('Nurse Dept', 'nurse_dept', '1', '0'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('30', 'Nurse Dept', 'nurse_dept_search', '1'); 

CREATE TABLE `nurses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT 0,
  `description` text NOT NULL,
  `date` date DEFAULT NULL,
  `attach_file` varchar(255) DEFAULT '',
  `created_by` int(11) DEFAULT 0 COMMENT 'staff_id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  



INSERT INTO `permission_group` (`name`, `short_code`, `is_active`, `system`) VALUES ('Psychology', 'psychology', '1', '0'); 
INSERT INTO `permission_category` (`perm_group_id`, `name`, `short_code`, `enable_view`) VALUES ('31', 'Psychology', 'psychology_search', '1'); 

CREATE TABLE `psychologys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT 0,
  `description` text NOT NULL,
  `date` date DEFAULT NULL,
  `attach_file` varchar(255) DEFAULT '',
  `created_by` int(11) DEFAULT 0 COMMENT 'staff_id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  











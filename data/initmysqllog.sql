CREATE TABLE `logactivity` (
  `logactivityid` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NULL,
  `detail` TEXT NULL,
  `citizen_id` VARCHAR(128) NULL,
  `citizen_province` VARCHAR(128) NULL,
  `actor_name` VARCHAR(128) NULL,
  `actor_province` VARCHAR(128) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`logactivityid`));

CREATE TABLE `logactivityreport` (
  `logactivityid` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NULL,
  `detail` TEXT NULL,
  `actor_name` VARCHAR(128) NULL,
  `actor_province` VARCHAR(128) NULL,
  `created_at` DATETIME NULL,
`search_province` TEXT NULL,
  PRIMARY KEY (`logactivityid`));
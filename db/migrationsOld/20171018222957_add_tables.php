<?php


use Phinx\Migration\AbstractMigration;

class AddTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
		$this->query('use `OFTEAMCHAT`;

-- Create tables section -------------------------------------------------

-- Table Visitor

CREATE TABLE `Visitor`
(
  `visitor_id` Bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `visitor_name` Varchar(30) NOT NULL,
  `email` Varchar(30),
  PRIMARY KEY (`visitor_id`)
)
;

-- Table VisitorMessage

CREATE TABLE `VisitorMessage`
(
  `id` Bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` Datetime NOT NULL,
  `text` Text NOT NULL,
  `visitor_id` Bigint UNSIGNED NOT NULL,
  `user_id` Bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship11` ON `VisitorMessage` (`user_id`)
;

CREATE INDEX `IX_Relationship1` ON `VisitorMessage` (`visitor_id`)
;

-- Table User

CREATE TABLE `User`
(
  `id` Bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` Varchar(30) NOT NULL,
  `password` Varchar(30) NOT NULL,
  `last_name` Varchar(30) NOT NULL,
  `first_name` Varchar(30) NOT NULL,
  `is_blocked` Bool NOT NULL,
  `info` Varchar(255),
  `department_id` Int UNSIGNED NOT NULL,
  `role_id` Int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
)
;

CREATE INDEX `IX_Relationship2` ON `User` (`department_id`)
;

CREATE INDEX `IX_Relationship5` ON `User` (`role_id`)
;

-- Table Department

CREATE TABLE `Department`
(
  `department_id` Int UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_name` Varchar(30) NOT NULL,
  `description` Varchar(255),
  PRIMARY KEY (`department_id`)
)
;

-- Table UserRole

CREATE TABLE `UserRole`
(
  `role_id` Int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` Varchar(30) NOT NULL,
  `description` Varchar(255),
  PRIMARY KEY (`role_id`)
)
;

-- Table Site

CREATE TABLE `Site`
(
  `Id` Int UNSIGNED NOT NULL AUTO_INCREMENT,
  `site_name` Varchar(30) NOT NULL,
  `widget_settings` Json NOT NULL,
  `owner_id` Bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`Id`)
)
;

CREATE INDEX `IX_Relationship9` ON `Site` (`owner_id`)
;

-- Table UserTimetable

CREATE TABLE `UserTimetable`
(
  `id` Int UNSIGNED NOT NULL AUTO_INCREMENT,
  `week_day` Varchar(20) NOT NULL,
  `start_time` Time NOT NULL,
  `end_time` Time NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Create foreign keys (relationships) section ------------------------------------------------- 


ALTER TABLE `VisitorMessage` ADD CONSTRAINT `Relationship1` FOREIGN KEY (`visitor_id`) REFERENCES `Visitor` (`visitor_id`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `User` ADD CONSTRAINT `Relationship2` FOREIGN KEY (`department_id`) REFERENCES `Department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `User` ADD CONSTRAINT `Relationship5` FOREIGN KEY (`role_id`) REFERENCES `UserRole` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `Site` ADD CONSTRAINT `Relationship9` FOREIGN KEY (`owner_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
;


ALTER TABLE `VisitorMessage` ADD CONSTRAINT `Relationship11` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
;');
    }
}

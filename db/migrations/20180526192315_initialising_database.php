<?php


use Phinx\Migration\AbstractMigration;

class InitialisingDatabase extends AbstractMigration
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
        $this->query('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'TRADITIONAL,ALLOW_INVALID_DATES\';

-- -----------------------------------------------------
-- Schema virtualtour
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema virtualtour
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `virtualtour` DEFAULT CHARACTER SET utf8 ;
USE `virtualtour` ;

-- -----------------------------------------------------
-- Table `virtualtour`.`UserRole`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`UserRole` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `virtualtour`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`User` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(45) NULL,
  `first_name` VARCHAR(45) NULL,
  `info` VARCHAR(100) NULL,
  `role_id` INT UNSIGNED NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC),
  INDEX `role_id_idx` (`role_id` ASC),
  CONSTRAINT `role_id_foreign_key`
    FOREIGN KEY (`role_id`)
    REFERENCES `virtualtour`.`UserRole` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `virtualtour`.`UserCollection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `virtualtour`.`UserCollection` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `user_id` BIGINT(20) UNSIGNED NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL, 
  `image_count` INT UNSIGNED NULL,
  `isPublic` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `user_id_foreign_key_idx` (`user_id` ASC),
  CONSTRAINT `user_id_foreign_key`
    FOREIGN KEY (`user_id`)
    REFERENCES `virtualtour`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ');
    }
}

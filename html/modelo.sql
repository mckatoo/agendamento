-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema agendamento
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema agendamento
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `agendamento` DEFAULT CHARACTER SET utf8 ;
USE `agendamento` ;

-- -----------------------------------------------------
-- Table `agendamento`.`professores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`professores` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`professores` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '	',
  `professor` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `agendamento`.`cursos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`cursos` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`cursos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `curso` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `agendamento`.`turmas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`turmas` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`turmas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `turma` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  `cursos_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_turmas_cursos1_idx` (`cursos_id` ASC),
  CONSTRAINT `fk_turmas_cursos1`
    FOREIGN KEY (`cursos_id`)
    REFERENCES `agendamento`.`cursos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `agendamento`.`agendamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`agendamentos` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`agendamentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dia` DATE NOT NULL,
  `preaula` TINYINT(1) NOT NULL DEFAULT 0,
  `primeiroperiodo` TINYINT(1) NOT NULL DEFAULT 0,
  `segundoperiodo` TINYINT(1) NOT NULL DEFAULT 0,
  `datashow` TINYINT(1) NOT NULL DEFAULT 0,
  `amplificador` TINYINT(1) NOT NULL DEFAULT 0,
  `observacao` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  `professores_id` INT NOT NULL,
  `turmas_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_agendamentos_professores_idx` (`professores_id` ASC),
  INDEX `fk_agendamentos_turmas1_idx` (`turmas_id` ASC),
  CONSTRAINT `fk_agendamentos_professores`
    FOREIGN KEY (`professores_id`)
    REFERENCES `agendamento`.`professores` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agendamentos_turmas1`
    FOREIGN KEY (`turmas_id`)
    REFERENCES `agendamento`.`turmas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `agendamento`.`migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`migrations` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `agendamento`.`tipoUsuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`tipoUsuarios` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`tipoUsuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL DEFAULT 'convidado',
  `nivel` INT(11) NOT NULL DEFAULT 9 COMMENT 'quanto menor mais autoridade',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `agendamento`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agendamento`.`users` ;

CREATE TABLE IF NOT EXISTS `agendamento`.`users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `email` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `password` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL,
  `api_token` VARCHAR(60) CHARACTER SET 'utf8mb4' NOT NULL,
  `tipoUsuarios_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC),
  INDEX `fk_users_tipoUsuarios1_idx` (`tipoUsuarios_id` ASC),
  CONSTRAINT `fk_users_tipoUsuarios1`
    FOREIGN KEY (`tipoUsuarios_id`)
    REFERENCES `agendamento`.`tipoUsuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

USE espace_consultant;
-- -----------------------------------------------------
-- Table `espace_consultant`.`competences`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`competences` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`competences` (
  `id_competence` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_competence` VARCHAR(250) NULL DEFAULT NULL ,
  `categorie` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id_competence`) )
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table pour recenser les différentes compétences ';


-- -----------------------------------------------------
-- Table `espace_consultant`.`utilisateurs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`utilisateurs` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`utilisateurs` (
  `id_consultant` INT(11) NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) NULL DEFAULT NULL ,
  `nom` VARCHAR(50) NULL DEFAULT NULL ,
  `prenom` VARCHAR(50) NULL DEFAULT NULL ,
  `promotion` INT(5) NOT NULL ,
  `naissance` DATE NULL DEFAULT NULL ,
  `email` VARCHAR(45) NULL DEFAULT NULL ,
  `tel` VARCHAR(15) NULL DEFAULT NULL ,
  `role` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Pole de droit possible : isepien, consultant ou admin' ,
  `firstConnect` DATETIME NOT NULL ,
  `lastConnect` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id_consultant`) ,
  UNIQUE INDEX `login` (`login` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table pour recenser les utilisateurs (avec leurs rôles)';


-- -----------------------------------------------------
-- Table `espace_consultant`.`competences_eleves`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`competences_eleves` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`competences_eleves` (
  `id_competences_eleves` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_consultant` INT(11) NOT NULL ,
  `id_competence` INT(11) NOT NULL ,
  `niveau` INT(11) NOT NULL ,
  PRIMARY KEY (`id_competences_eleves`) ,
  INDEX `id_competence` (`id_competence` ASC) ,
  INDEX `id_consultant` (`id_consultant` ASC) ,
  CONSTRAINT `competences_eleves_ibfk_1`
    FOREIGN KEY (`id_consultant` )
    REFERENCES `espace_consultant`.`utilisateurs` (`id_consultant` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `competences_eleves_ibfk_2`
    FOREIGN KEY (`id_competence` )
    REFERENCES `espace_consultant`.`competences` (`id_competence` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table recensant les compétences de chaque consultant';


-- -----------------------------------------------------
-- Table `espace_consultant`.`formations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`formations` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`formations` (
  `id_formation` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_formation` VARCHAR(50) NULL DEFAULT NULL ,
  `lieu` VARCHAR(50) NULL DEFAULT NULL ,
  `date` DATETIME NULL DEFAULT NULL ,
  `intervenants` VARCHAR(255) NULL DEFAULT NULL ,
  `details_formation` TEXT NULL DEFAULT NULL ,
  `fichiers` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id_formation`) )
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table pour recenser les différentes formations dispensées';


-- -----------------------------------------------------
-- Table `espace_consultant`.`formations_eleves`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`formations_eleves` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`formations_eleves` (
  `id_formation_eleves` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_formation` INT(11) NOT NULL ,
  `id_consultant` INT(11) NOT NULL ,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`id_formation_eleves`) ,
  INDEX `id_consultant` (`id_consultant` ASC) ,
  INDEX `id_formation` (`id_formation` ASC) ,
  CONSTRAINT `formations_eleves_ibfk_1`
    FOREIGN KEY (`id_formation` )
    REFERENCES `espace_consultant`.`formations` (`id_formation` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `formations_eleves_ibfk_2`
    FOREIGN KEY (`id_consultant` )
    REFERENCES `espace_consultant`.`utilisateurs` (`id_consultant` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table recensant les différents élèves inscrits aux formation' /* comment truncated */;


-- -----------------------------------------------------
-- Table `espace_consultant`.`recherche_competences`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`recherche_competences` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`recherche_competences` (
  `id_recherche` INT(11) NOT NULL AUTO_INCREMENT ,
  `nom_mission` VARCHAR(45) NOT NULL ,
  `priorite` VARCHAR(45) NULL DEFAULT NULL ,
  `type` VARCHAR(255) NULL DEFAULT NULL ,
  `competences` VARCHAR(255) NULL DEFAULT NULL ,
  `difficulte` INT(2) NULL DEFAULT NULL ,
  `nbr_intervenants` INT(3) NULL DEFAULT NULL ,
  `details_recherche` TEXT NULL DEFAULT NULL ,
  `date` DATETIME NOT NULL ,
  `fichiers` VARCHAR(255) NOT NULL ,
  `dispo` VARCHAR(3) NOT NULL ,
  `id_cdp` INT(11) NOT NULL ,
  PRIMARY KEY (`id_recherche`) ,
  INDEX `id_cdp` (`id_cdp` ASC) ,
  CONSTRAINT `recherche_competences_ibfk_1`
    FOREIGN KEY (`id_cdp` )
    REFERENCES `espace_consultant`.`utilisateurs` (`id_consultant` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table pour recenser les différentes recherches de compétence';


-- -----------------------------------------------------
-- Table `espace_consultant`.`recherche_competences_eleves`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `espace_consultant`.`recherche_competences_eleves` ;

CREATE  TABLE IF NOT EXISTS `espace_consultant`.`recherche_competences_eleves` (
  `id_recherche_eleves` INT(11) NOT NULL AUTO_INCREMENT ,
  `id_recherche` INT(11) NOT NULL ,
  `id_consultant` INT(11) NOT NULL ,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`id_recherche_eleves`) ,
  INDEX `id_consultant` (`id_consultant` ASC) ,
  INDEX `id_recherche` (`id_recherche` ASC) ,
  CONSTRAINT `recherche_competences_eleves_ibfk_1`
    FOREIGN KEY (`id_recherche` )
    REFERENCES `espace_consultant`.`recherche_competences` (`id_recherche` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `recherche_competences_eleves_ibfk_2`
    FOREIGN KEY (`id_consultant` )
    REFERENCES `espace_consultant`.`utilisateurs` (`id_consultant` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = 'Table recensant les postulants aux missions';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

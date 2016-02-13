SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `climbdb` DEFAULT CHARACTER SET latin1 ;
USE `climbdb` ;

-- -----------------------------------------------------
-- Table `climbdb`.`User`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`User` (
  `UserId` INT(11) NOT NULL AUTO_INCREMENT ,
  `Pwd` VARCHAR(255) NOT NULL ,
  `Email` VARCHAR(64) NOT NULL ,
  `IsEmailPublic` TINYINT(1) NOT NULL DEFAULT '1' ,
  `NickName` VARCHAR(255) NULL DEFAULT NULL ,
  `FirstName` VARCHAR(45) NULL DEFAULT NULL ,
  `LastName` VARCHAR(45) NULL DEFAULT NULL ,
  `PhoneNumber` VARCHAR(15) NULL DEFAULT NULL ,
  `Address` VARCHAR(100) NULL DEFAULT NULL ,
  `Country` VARCHAR(45) NULL DEFAULT NULL ,
  `Sex` VARCHAR(10) NULL DEFAULT NULL ,
  `HomePage` VARCHAR(45) NULL DEFAULT NULL ,
  `ShoeBrand` VARCHAR(20) NULL DEFAULT NULL ,
  `ShoeModel` VARCHAR(20) NULL DEFAULT NULL ,
  `ShoeSize` DECIMAL(3,1) NULL DEFAULT NULL ,
  PRIMARY KEY (`UserId`) ,
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC) ,
  UNIQUE INDEX `NickName_UNIQUE` (`NickName` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 103
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`Comment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`Comment` (
  `CommentId` INT(11) NOT NULL AUTO_INCREMENT ,
  `CommenterId` INT(11) NOT NULL ,
  `Comment` VARCHAR(2400) NOT NULL ,
  `DateTime` DATETIME NOT NULL ,
  PRIMARY KEY (`CommentId`) ,
  INDEX `fk_Comment_User1_idx` (`CommenterId` ASC) ,
  CONSTRAINT `fk_Comment_User1`
    FOREIGN KEY (`CommenterId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 63
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`Crag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`Crag` (
  `CragId` INT(11) NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NOT NULL ,
  `Lat` VARCHAR(45) NOT NULL ,
  `Lon` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`CragId`) ,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 72
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`CragCommentTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`CragCommentTarget` (
  `CommentId` INT(11) NOT NULL ,
  `CragId` INT(11) NOT NULL ,
  PRIMARY KEY (`CommentId`) ,
  INDEX `fk_table1_Comment1_idx` (`CommentId` ASC) ,
  INDEX `fk_table1_Crag1_idx` (`CragId` ASC) ,
  CONSTRAINT `fk_table1_Comment1`
    FOREIGN KEY (`CommentId` )
    REFERENCES `climbdb`.`Comment` (`CommentId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_Crag1`
    FOREIGN KEY (`CragId` )
    REFERENCES `climbdb`.`Crag` (`CragId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`Image`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`Image` (
  `ImageId` INT(11) NOT NULL AUTO_INCREMENT ,
  `UploaderId` INT(11) NOT NULL ,
  `ServerLocation` VARCHAR(255) NOT NULL ,
  `FileName` VARCHAR(255) NOT NULL ,
  `Width` INT(11) NOT NULL ,
  `Height` INT(11) NOT NULL ,
  `Title` VARCHAR(255) NULL DEFAULT NULL ,
  `Description` VARCHAR(2400) NULL DEFAULT NULL ,
  PRIMARY KEY (`ImageId`) ,
  UNIQUE INDEX `Name_UNIQUE` (`FileName` ASC) ,
  INDEX `fk_Image_User1_idx` (`UploaderId` ASC) ,
  CONSTRAINT `fk_Image_User1`
    FOREIGN KEY (`UploaderId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 175
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`CragImageTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`CragImageTarget` (
  `ImageId` INT(11) NOT NULL ,
  `CragId` INT(11) NOT NULL ,
  PRIMARY KEY (`ImageId`) ,
  INDEX `fk_CragImageTarget_Image1_idx` (`ImageId` ASC) ,
  INDEX `fk_CragImageTarget_Crag1` (`CragId` ASC) ,
  CONSTRAINT `fk_CragImageTarget_Crag1`
    FOREIGN KEY (`CragId` )
    REFERENCES `climbdb`.`Crag` (`CragId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CragImageTarget_Image1`
    FOREIGN KEY (`ImageId` )
    REFERENCES `climbdb`.`Image` (`ImageId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`Practice`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`Practice` (
  `PracticeId` INT(11) NOT NULL AUTO_INCREMENT ,
  `UserId` INT(11) NOT NULL ,
  `StartTime` DATETIME NOT NULL ,
  `EndTime` DATETIME NOT NULL ,
  `IsOutside` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`PracticeId`) ,
  INDEX `fk_Practice_User1_idx` (`UserId` ASC) ,
  CONSTRAINT `fk_Practice_User1`
    FOREIGN KEY (`UserId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 206
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`Route`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`Route` (
  `RouteId` INT(11) NOT NULL AUTO_INCREMENT ,
  `CragId` INT(11) NOT NULL ,
  `Name` VARCHAR(45) NOT NULL ,
  `Grade` INT(11) NOT NULL ,
  `Description` VARCHAR(743) NULL DEFAULT NULL ,
  PRIMARY KEY (`RouteId`) ,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) ,
  INDEX `fk_Route_Crag1_idx` (`CragId` ASC) ,
  CONSTRAINT `fk_Route_Crag1`
    FOREIGN KEY (`CragId` )
    REFERENCES `climbdb`.`Crag` (`CragId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 114
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`RouteCommentTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`RouteCommentTarget` (
  `CommentId` INT(11) NOT NULL ,
  `RouteId` INT(11) NOT NULL ,
  PRIMARY KEY (`CommentId`) ,
  INDEX `fk_table2_Comment1_idx` (`CommentId` ASC) ,
  INDEX `fk_table2_Route1_idx` (`RouteId` ASC) ,
  CONSTRAINT `fk_table2_Comment1`
    FOREIGN KEY (`CommentId` )
    REFERENCES `climbdb`.`Comment` (`CommentId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table2_Route1`
    FOREIGN KEY (`RouteId` )
    REFERENCES `climbdb`.`Route` (`RouteId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`RouteImageTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`RouteImageTarget` (
  `ImageId` INT(11) NOT NULL ,
  `RouteId` INT(11) NOT NULL ,
  `StartX` INT(11) NULL DEFAULT NULL ,
  `StartY` INT(11) NULL DEFAULT NULL ,
  `EndX` INT(11) NULL DEFAULT NULL ,
  `EndY` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`ImageId`, `RouteId`) ,
  INDEX `fk_Image_has_Route_Route1_idx` (`RouteId` ASC) ,
  INDEX `fk_Image_has_Route_Image1_idx` (`ImageId` ASC) ,
  CONSTRAINT `fk_Image_has_Route_Image1`
    FOREIGN KEY (`ImageId` )
    REFERENCES `climbdb`.`Image` (`ImageId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Image_has_Route_Route1`
    FOREIGN KEY (`RouteId` )
    REFERENCES `climbdb`.`Route` (`RouteId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`UserCommentTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`UserCommentTarget` (
  `CommentId` INT(11) NOT NULL ,
  `UserId` INT(11) NOT NULL ,
  PRIMARY KEY (`CommentId`, `UserId`) ,
  INDEX `fk_Comment_has_User_User1_idx` (`UserId` ASC) ,
  INDEX `fk_Comment_has_User_Comment1_idx` (`CommentId` ASC) ,
  CONSTRAINT `fk_Comment_has_User_Comment1`
    FOREIGN KEY (`CommentId` )
    REFERENCES `climbdb`.`Comment` (`CommentId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comment_has_User_User1`
    FOREIGN KEY (`UserId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`UserImageTarget`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`UserImageTarget` (
  `UserId` INT(11) NOT NULL ,
  `ImageId` INT(11) NOT NULL ,
  PRIMARY KEY (`UserId`, `ImageId`) ,
  INDEX `fk_User_has_Image_Image2_idx` (`ImageId` ASC) ,
  INDEX `fk_User_has_Image_User2_idx` (`UserId` ASC) ,
  CONSTRAINT `fk_User_has_Image_Image2`
    FOREIGN KEY (`ImageId` )
    REFERENCES `climbdb`.`Image` (`ImageId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Image_User2`
    FOREIGN KEY (`UserId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`UserProfileImage`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climbdb`.`UserProfileImage` (
  `UserId` INT(11) NOT NULL ,
  `ImageId` INT(11) NOT NULL ,
  PRIMARY KEY (`UserId`, `ImageId`) ,
  UNIQUE INDEX `UserId` (`UserId` ASC) ,
  INDEX `fk_UserProfileImage_Image1_idx` (`ImageId` ASC) ,
  CONSTRAINT `fk_UserProfileImage_Image1`
    FOREIGN KEY (`ImageId` )
    REFERENCES `climbdb`.`Image` (`ImageId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserProfileImage_User1`
    FOREIGN KEY (`UserId` )
    REFERENCES `climbdb`.`User` (`UserId` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `climbdb`.`exercise_mongo`
-- -----------------------------------------------------
-- CREATE  TABLE IF NOT EXISTS `climbdb`.`exercise_mongo` (
--   `_id` INT NOT NULL ,
--   `UserId` INT NULL ,
--   `Type` VARCHAR(45) NULL ,
--   `PracticeId` INT NULL ,
--   `Grade` VARCHAR(45) NULL ,
--   `RouteId` INT NULL ,
--   `Steps` INT NULL ,
--   `DateTime` DATETIME NULL ,
--   `EndTime` DATETIME NULL ,
--   PRIMARY KEY (`_id`) )
-- ENGINE = InnoDB;
-- 
-- USE `climbdb` ;
-- 
-- -----------------------------------------------------
-- Placeholder table for view `climbdb`.`vw_LoadProfileImage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `climbdb`.`vw_LoadProfileImage` (`FileName` INT, `ServerLocation` INT);

-- -----------------------------------------------------
-- View `climbdb`.`vw_LoadProfileImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `climbdb`.`vw_LoadProfileImage`;
USE `climbdb`;
CREATE  OR REPLACE VIEW `climbdb`.`vw_LoadProfileImage` AS
SELECT FileName, ServerLocation 
              FROM Image 
              INNER JOIN UserProfileImage 
              ON Image.Imageid=UserProfileImage.ImageId;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `climbdb`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`User` (`UserId`, `Pwd`, `Email`, `IsEmailPublic`, `NickName`, `FirstName`, `LastName`, `PhoneNumber`, `Address`, `Country`, `Sex`, `HomePage`, `ShoeBrand`, `ShoeModel`, `ShoeSize`) VALUES (1, 'sala1', 'testi@testi.com', 1, 'Nikki', 'Testi', 'Nimi', '04044466611', 'testaajankatu 2', 'Finland', 'male', NULL, 'La Sportiva', 'Solution', 39);
INSERT INTO `climbdb`.`User` (`UserId`, `Pwd`, `Email`, `IsEmailPublic`, `NickName`, `FirstName`, `LastName`, `PhoneNumber`, `Address`, `Country`, `Sex`, `HomePage`, `ShoeBrand`, `ShoeModel`, `ShoeSize`) VALUES (2, 'sala2', 'joo@joo.com', 1, 'Nickname', 'joo', 'jaa', '0501234567', 'juukatu 3 ', 'Finland', 'male', NULL, 'La Sportiva', 'Genius', 38);
INSERT INTO `climbdb`.`User` (`UserId`, `Pwd`, `Email`, `IsEmailPublic`, `NickName`, `FirstName`, `LastName`, `PhoneNumber`, `Address`, `Country`, `Sex`, `HomePage`, `ShoeBrand`, `ShoeModel`, `ShoeSize`) VALUES (3, 'sala3', 'jee@jee.com', 1, 'Tunnusnimi', 'juu', 'jee', '0404411122', 'joojoo 3', 'Finland', 'male', NULL, 'La Sportiva', 'Miura VS', 40);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`Comment`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`Comment` (`CommentId`, `CommenterId`, `Comment`, `DateTime`) VALUES (1, 1, 'jeees', '2015-03-10 19-31-25	');
INSERT INTO `climbdb`.`Comment` (`CommentId`, `CommenterId`, `Comment`, `DateTime`) VALUES (2, 1, 'joo', '2015-03-10 19-31-36');
INSERT INTO `climbdb`.`Comment` (`CommentId`, `CommenterId`, `Comment`, `DateTime`) VALUES (3, 3, 'juu', '2015-03-10 19-31-39');

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`Crag`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`Crag` (`CragId`, `Name`, `Lat`, `Lon`) VALUES (1, 'eeppinen', '52.53', '52.54');
INSERT INTO `climbdb`.`Crag` (`CragId`, `Name`, `Lat`, `Lon`) VALUES (2, 'ylieeppinen', '52.55', '52.43');
INSERT INTO `climbdb`.`Crag` (`CragId`, `Name`, `Lat`, `Lon`) VALUES (3, 'hulluneeppinen', '55.60', '52.40');

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`CragCommentTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`CragCommentTarget` (`CommentId`, `CragId`) VALUES (2, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`Image`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`Image` (`ImageId`, `UploaderId`, `ServerLocation`, `FileName`, `Width`, `Height`, `Title`, `Description`) VALUES (1, 1, '/images/', 'joo.jpg', 25, 25, NULL, NULL);
INSERT INTO `climbdb`.`Image` (`ImageId`, `UploaderId`, `ServerLocation`, `FileName`, `Width`, `Height`, `Title`, `Description`) VALUES (2, 2, '/images/', 'juu.jpg', 100, 100, NULL, NULL);
INSERT INTO `climbdb`.`Image` (`ImageId`, `UploaderId`, `ServerLocation`, `FileName`, `Width`, `Height`, `Title`, `Description`) VALUES (3, 2, '/images/', 'jee.jpg', 250, 250, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`CragImageTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`CragImageTarget` (`ImageId`, `CragId`) VALUES (2, 3);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`Practice`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`Practice` (`PracticeId`, `UserId`, `StartTime`, `EndTime`, `IsOutside`) VALUES (1, 1, '2015-03-11 16-28-20', '2015-03-11 16-28-20', 1);
INSERT INTO `climbdb`.`Practice` (`PracticeId`, `UserId`, `StartTime`, `EndTime`, `IsOutside`) VALUES (2, 1, '2015-03-11 16-28-20', '2015-03-11 16-28-20', 1);
INSERT INTO `climbdb`.`Practice` (`PracticeId`, `UserId`, `StartTime`, `EndTime`, `IsOutside`) VALUES (3, 3, '2015-03-11 16-28-20', '2015-03-11 16-28-20', 0);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`Route`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`Route` (`RouteId`, `CragId`, `Name`, `Grade`, `Description`) VALUES (1, 1, 'ihanhullu', 10, NULL);
INSERT INTO `climbdb`.`Route` (`RouteId`, `CragId`, `Name`, `Grade`, `Description`) VALUES (2, 2, 'krimppi', 9, NULL);
INSERT INTO `climbdb`.`Route` (`RouteId`, `CragId`, `Name`, `Grade`, `Description`) VALUES (3, 3, 'sloperi', 15, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`RouteCommentTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`RouteCommentTarget` (`CommentId`, `RouteId`) VALUES (3, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`RouteImageTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`RouteImageTarget` (`ImageId`, `RouteId`, `StartX`, `StartY`, `EndX`, `EndY`) VALUES (1, 2, NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`UserCommentTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`UserCommentTarget` (`CommentId`, `UserId`) VALUES (1, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `climbdb`.`UserImageTarget`
-- -----------------------------------------------------
START TRANSACTION;
USE `climbdb`;
INSERT INTO `climbdb`.`UserImageTarget` (`UserId`, `ImageId`) VALUES (1, 3);

COMMIT;

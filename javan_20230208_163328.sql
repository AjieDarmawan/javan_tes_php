-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "keluarga" -------------------------------------
CREATE TABLE `keluarga`( 
	`id_keluarga` Int( 255 ) AUTO_INCREMENT NOT NULL,
	`nama` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`status` Int( 255 ) NOT NULL,
	`id_parent` Int( 255 ) NOT NULL,
	`jk` Int( 255 ) NOT NULL,
	PRIMARY KEY ( `id_keluarga` ) )
CHARACTER SET = utf8mb4
COLLATE = utf8mb4_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 12;
-- -------------------------------------------------------------


-- Dump data of "keluarga" ---------------------------------
BEGIN;

INSERT INTO `keluarga`(`id_keluarga`,`nama`,`status`,`id_parent`,`jk`) VALUES 
( '1', 'budi', '1', '0', '1' ),
( '2', 'dede', '1', '1', '1' ),
( '3', 'dodi', '1', '1', '1' ),
( '4', 'dedi', '1', '1', '1' ),
( '5', 'dewi', '1', '1', '2' ),
( '6', 'feri', '1', '4', '1' ),
( '7', 'farah', '1', '4', '2' ),
( '8', 'gugus', '1', '3', '1' ),
( '9', 'gandi', '1', '3', '1' ),
( '10', 'hani', '1', '2', '2' ),
( '11', 'hana', '1', '2', '2' );
COMMIT;
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------



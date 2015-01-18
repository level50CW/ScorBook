RENAME TABLE `League` TO  `Division`;
ALTER TABLE 'Division' DROP 'type';
ALTER TABLE  `Division` CHANGE  `idleague`  `iddivision` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `Games` CHANGE  `League_idleague_visiting`  `Division_iddivision_visiting` INT( 11 ) NOT NULL;
ALTER TABLE  `Games` CHANGE  `League_idleague_home`  `Division_iddivision_home` INT( 11 ) NOT NULL;
ALTER TABLE  `Teams` CHANGE  `League_idleague`  `Division_iddivision` INT( 11 ) NOT NULL;
ALTER TABLE  `first_half_legacy` CHANGE  `idLeague`  `idDivision` INT( 11 ) NOT NULL;
ALTER TABLE  `northwoods`.`Games` DROP INDEX  `fk_Games_League1_idx` ,
	ADD INDEX  `fk_Games_Division1_idx` (  `Division_iddivision_visiting` );
ALTER TABLE  `northwoods`.`Games` DROP INDEX  `fk_Games_League2_idx` ,
	ADD INDEX  `fk_Games_Division2_idx` (  `Division_iddivision_home` );

--
-- Table structure for table `league`
--

CREATE TABLE IF NOT EXISTS `league` (
  `idleague` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(150) NOT NULL,
  PRIMARY KEY (`idleague`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `league`
--

INSERT INTO `league` (`idleague`, `Name`) VALUES
(1, 'Northwood League');

ALTER TABLE  `Division` ADD  `league_idleague` INT NOT NULL;
UPDATE Division SET `league_idleague`=1;
ALTER TABLE  `Division` ADD INDEX (  `league_idleague` ) ;
ALTER TABLE  `Division` ADD FOREIGN KEY (  `league_idleague` ) REFERENCES  `league` (
	`idleague`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;


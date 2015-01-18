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
	
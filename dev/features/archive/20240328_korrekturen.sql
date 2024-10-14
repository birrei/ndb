-- update satz set Nr=1 where Nr is null;
-- update satz set Nr=1 where Nr = 0;

-- update musikstueck set Nummer=1 where Nummer is null;
-- update musikstueck set Nummer=1 where Nummer = 0; 




ALTER TABLE `satz` CHANGE `Erprobt` `Erprobt` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `satz` CHANGE `Taktart` `Tonart` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `satz` CHANGE `Tonart` `Tonart` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

SHOW COLUMNS FROM test.satz;

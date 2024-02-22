
/* ## 03.02. 2023 - Vergrößerung varchar-Spalten  */ 

ALTER TABLE `musikstueck` CHANGE `Bearbeiter` `Bearbeiter` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `musikstueck` CHANGE `Epoche` `Epoche` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


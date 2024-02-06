-- nach: 
ALTER TABLE `musikstueck` CHANGE `JahrAuffuehrung` `JahrAuffuehrung` VARCHAR(25) NOT NULL;

-- Problem: leere Felder enthalten jetzt "0", daher update: 
update musikstueck set JahrAuffuehrung='' where JahrAuffuehrung='0'; 


/* ## 03.02. 2023 - Vergrößerung varchar-Spalten  */ 

ALTER TABLE `musikstueck` CHANGE `Bearbeiter` `Bearbeiter` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `musikstueck` CHANGE `Epoche` `Epoche` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


/* Komma zurück zu Semikolon ändern */ 
-- ermittelt aus dem Original: Export_AzureDB_2024-01-22.xlsx

update musikstueck 
set besetzung='Streichquartett; Streichorchester'
where besetzung ='Streichquartett, Streichorchester';

update musikstueck 
set besetzung='Streichorchester; 2 Violinen, 2 Viola, Bass'
where besetzung ='Streichorchester, 2 Violinen, 2 Viola, Bass';

update musikstueck 
set besetzung='Streichorchester; 3 Violinen, Viola, Bass'
where besetzung ='Streichorchester, 3 Violinen, Viola, Bass';

update musikstueck 
set besetzung='Streichorchester; Streichquartett; 4 Violinen, Viola, Bass'
where besetzung ='Streichorchester, Streichquartett, 4 Violinen, Viola, Bass';

update musikstueck 
set besetzung='Streichquartett; Streichorchester; Blockflötenensemble'
where besetzung ='Streichquartett, Streichorchester, Blockflötenensemble';








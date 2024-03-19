SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
FROM information_schema.TABLES 
WHERE TABLE_TYPE LIKE 'VIEW'; 

/* Spalten einer Tabelle anzeigen */ 
SHOW COLUMNS FROM test.satz; 

/* nicht verwendete verlage löschen */ 
    delete from verlag where ID not in (select distinct VerlagID from sammlung where VerlagID is not NULL)  

/* nicht verwendete sammlungen löschen */
    delete from sammlung where ID not in (select distinct SammlungID from musikstueck where SammlungID is not null) 


/* Musiksstücke und Verwendungszwecke  */
    select m.ID as MusikstueckID
        , m.Name as Musikstück 
        , v.ID as VerwendungszweckID
        , v.Name as Verwendungszweck 
    from musikstueck m 
    left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
    left join verwendungszweck v on mv.VerwendungszweckID=v.ID 
    where mv.ID is not null 
    order by m.ID, v.ID 

/* Musikstücke mit mit mehreren Verwendungs-Zwecken */

    select m.ID, count(distinct mv.VerwendungszweckID) anzahl_verwendungszwecke 
    from musikstueck m 
    left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
    left join verwendungszweck v on mv.VerwendungszweckID=v.ID 
    where mv.ID is not null 
    group by m.ID 
    having count(distinct mv.VerwendungszweckID) > 1
    order by anzahl_verwendungszwecke DESC 


        


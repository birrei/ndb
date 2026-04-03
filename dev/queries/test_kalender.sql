


select * 
from kalender k  
-- where k.datum between '2020-12-01' and '2021-01-31' 
order by datum 


select k.datum, schueler.Name, schueler.Unterricht_Wochentag , SUM(u.Anzahl ) Minuten 
from kalender k 
	 left join uebung u on k.datum = u.Datum 
	 left join schueler on k.wochentag_nr = schueler.Unterricht_Wochentag 
	 			and schueler.ID=32
where 1=1 
-- and k.wochentag_nr  = (select Unterricht_Wochentag from schueler where ID=32)	
-- and k.wochentag_nr = 4
and year(k.datum ) in (2025, 2026)
group by k.datum 
order by k.datum desc 



-- kalender wochentag = schüler wochentag 
-- kalender datum nicht gleich übung datum (übung/Unterricht Datum kann gelegentlich abweichen)
-- schueler mit ausweich- wochentag ("variabel" etc.) sind nicht abgebildet 
-- Verworfen! 


SELECT  kalender.datum as `Unterricht Plandatum` 
		, kalender.wochentag_name as Wochentag 
		, schueler.Name as `Schüler Name` 
      , schueler.Unterricht_Reihenfolge as `Unterricht Reihenfolge` 
      , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
      , SUM(uebung.Anzahl ) as `Summe Minuten` 
      , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
      , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Name separator '<br>') `Übungen Inhalte`  
from  
	kalender 
	LEFT JOIN schueler ON schueler.Unterricht_Wochentag = kalender.wochentag_nr  
    left join uebung on kalender.datum = uebung.Datum 
      LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag                   
      left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
      left join satz  on satz.ID=uebung.SatzID 
      left join musikstueck on satz.MusikstueckID = musikstueck.ID
      left JOIN sammlung on sammlung.ID = musikstueck.SammlungID  
      left JOIN v_uebung_lookuptypes on v_uebung_lookuptypes.UebungID = uebung.ID 
WHERE 1=1 
and schueler.ID is not null 
and schueler.ID = 32
and kalender.datum  between curdate() - interval 90 day  and   curdate() + interval 30 day             -- XXX 
GROUP BY kalender.Datum, uebung.SchuelerID   
ORDER BY kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name  





SELECT  kalender.datum as `Unterricht Plandatum` 
          , kalender.wochentag_name as Wochentag 
          , schueler.Name as `Schüler Name` 
            , schueler.Unterricht_Reihenfolge as `Unterricht Reihenfolge` 
            , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
            , SUM(uebung.Anzahl ) as `Summe Minuten` 
            , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
            , GROUP_CONCAT(distinct uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Name separator '
') `Übungen Inhalte`  
      from  
        kalender 
        LEFT JOIN schueler ON schueler.Unterricht_Wochentag = kalender.wochentag_nr  
        left join uebung on kalender.datum = uebung.Datum                 
        left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
      WHERE 1=1 
      and schueler.ID is not null 
        AND kalender.Datum='2026-03-05' 
        GROUP BY kalender.Datum, schueler.ID 
             ORDER BY kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name 
             
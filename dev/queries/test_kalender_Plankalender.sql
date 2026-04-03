
select kalender.datum
	, kalender.wochentag_name as Wochentag 
	, group_concat(schueler.Name order by schueler.Unterricht_Reihenfolge separator ', ') as Schueler
	, DATE_FORMAT(SEC_TO_TIME(sum(schueler.Unterricht_Dauer ) * 60), '%H:%i') summe_dauer -- format minuten -> hh:mm 
from kalender 
left join schueler on kalender.wochentag_nr = schueler.Unterricht_Wochentag 
		   and schueler.Aktiv =1 
where 1=1 
and datum  between curdate() - interval 90 day  and   curdate() + interval 90 day
group by kalender.datum 
order by kalender.datum 



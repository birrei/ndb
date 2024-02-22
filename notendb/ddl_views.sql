CREATE OR REPLACE VIEW musikstuecke_v AS 
select 
/* musikstueck */
	m.Name AS Name
	,m.Nummer AS Nr
    , m.Opus 
	, CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist /* komponist */
	, sa.Name AS Sammlung /* sammlung */ 
	, v.Name AS Verlag /* verlag */
    , m.Bearbeiter
    , m.Epoche
    , m.Verwendungszweck
    , m.Gattung
    , b.Name as Besetzung /* besetzung */

 /* satz */     
    , s.Name as Satz 
    , s.Nr as SatzNr
    , s.Tonart 
    , s.Taktart
    , s.Tempobezeichnung
    , s.Spieldauer
    , s.Schwierigkeitsgrad
    , s.Lagen 
    , s.Stricharten 
    , s.Erprobt 
    , s.Notenwerte

/* ids */
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
    , b.ID as BesetzungID
    , v.ID as VerlagID 
	, m.ID as MusikstueckID
    , s.ID as SatzID 
    , m.ID 
   FROM 
    musikstueck  AS m 
    LEFT join  satz  AS s on m.ID = s.MusikstueckID    
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  komponist  AS k on m.KomponistID = k.ID 
    LEFT join  verlag  AS v on sa.VerlagID = v.ID 
    left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
    left join besetzung b on mb.BesetzungID = b.ID


; 

/* Testviews */


    create OR REPLACE view test_musikstueck_ohne_Besetzung_v 
    AS 
    select m.* 
    from musikstueck m 
    left join musikstueck_besetzung mb 
    on m.ID = mb.MusikstueckID 
    where mb.ID is null 
    ; 

    CREATE OR REPLACE VIEW test_musikstueck_ohne_komponist_v AS
    select m.* 
    from musikstueck m 
    left join komponist k 
    on m.KomponistID = k.ID
    where k.ID is null 
    ; 

    CREATE  OR REPLACE VIEW test_musikstueck_ohne_satz_v 
    AS 
    select m.*
    from  musikstueck m 
    left join satz s 
    on s.MusikstueckID = m.ID 
    where s.ID is null 

    ;

    CREATE OR REPLACE VIEW test_sammlung_ohne_verlag_v AS 
    select s.* 
    from sammlung s 
    left join verlag v on s.VerlagID = v.ID
    where v.ID is null 

    ;

    CREATE  OR REPLACE VIEW test_satz_ohne_musikstueck_v AS 
    select s.*
    from satz s 
    left join musikstueck m 
    on s.MusikstueckID = m.ID 
    where m.ID is null; 

    CREATE OR REPLACE VIEW test_sammlung_ohne_musikstueck_v AS 
    select s.* 
    from sammlung s 
    left join musikstueck m on s.ID = m.SammlungID 
    where m.ID is null ; 


/* distinct views  */ 
    /* Musikstueck */ 

    create or REPLACE view tmp_Gattungen as 
    select distinct Gattung from musikstueck
    where Gattung is not null 
    and Gattung <> ''
    order by Gattung ; 

    create or REPLACE view tmp_Verwendungszwecke as 
    select distinct Verwendungszweck from musikstueck 
    where Verwendungszweck is not null 
   and Verwendungszweck <> ''
    order by Verwendungszweck ; 

    create or REPLACE view tmp_Epochen as 
    select distinct Epoche from musikstueck 
    where Epoche is not null 
    and Epoche <> ''
    order by Epoche 
    ; 


    /* Satz */ 

    create or REPLACE view tmp_Stricharten as 
    select distinct Stricharten from satz 
    where Stricharten is not null 
    and  Stricharten <> ''
    order by Stricharten 

/* ! am Ende der Datei kein Semikolon verwenden */ 
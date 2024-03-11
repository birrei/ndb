CREATE OR REPLACE VIEW v_musikstuecke AS 

SELECT  
	 sa.Name AS Sammlung /* sammlung */ 

	, m.Name AS Name
	, m.Nummer AS Nr
    , m.Opus 
	, CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist /* komponist */

	, v.Name AS Verlag /* verlag */
    , m.Bearbeiter
    , m.Epoche
    , vz.Name as Verwendungszweck 
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
/*    --  , s.Stricharten */
    , st.Name as Strichart 
    , s.Erprobt 
    , s.Notenwerte
/* ids */
    , sa.ID AS SammlungID 
    , k.ID AS KomponistID
    , b.ID as BesetzungID
    , vz.ID as VerwendungszweckID
    , v.ID as VerlagID 
	-- , m.ID as MusikstueckID
    , s.ID as SatzID 
    , ss.ID as StrichartID 
    , m.ID 
   FROM 
    musikstueck  AS m 
    LEFT join  satz  AS s on m.ID = s.MusikstueckID    
    LEFT join  sammlung  AS sa on m.SammlungID = sa.ID 
    LEFT join  komponist  AS k on m.KomponistID = k.ID 
    LEFT join  verlag  AS v on sa.VerlagID = v.ID 
    left join musikstueck_besetzung mb on m.ID = mb.MusikstueckID
    left join besetzung b on mb.BesetzungID = b.ID
    left join musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
    left join verwendungszweck vz on mv.VerwendungszweckID=vz.ID 
    left join satz_strichart ss on ss.SatzID=ss.ID
    left join strichart st on ss.StrichartID = st.ID 

-- where m.ID=1
order by sa.ID, m.Nummer, b.ID, vz.ID,  s.Nr
; 


/* Testviews */

/* Sammlung */

    CREATE OR REPLACE VIEW v_test_sammlung_ohne_musikstueck AS 
    select s.ID, s.Name
    from sammlung s 
    left join musikstueck m on s.ID = m.SammlungID 
    where m.ID is null ; 

    CREATE OR REPLACE VIEW v_test_sammlung_ohne_verlag AS 
    select s.ID, s.Name
    from sammlung s 
    left join verlag v on s.VerlagID = v.ID
    where v.ID is null 

    ;

/* Musikstück */

    create OR REPLACE view v_test_musikstueck_ohne_besetzung
    AS 
    select m.ID, m.Name as Musikstueck_Name, s.Name as Sammlung_Name 
    from sammlung s 
    left join musikstueck m on s.ID = m.SammlungID 
    left join musikstueck_besetzung mb 
    on m.ID = mb.MusikstueckID 
    where mb.ID is null 
    ; 

    CREATE OR REPLACE VIEW v_test_musikstueck_ohne_komponist AS
    select m.ID, m.Name as Musikstueck_Name, s.Name as Sammlung_Name 
    from sammlung s 
    left join musikstueck m on s.ID = m.SammlungID 
    left join komponist k 
    on m.KomponistID = k.ID
    where k.ID is null 
    ; 

    CREATE  OR REPLACE VIEW v_test_musikstueck_ohne_satz
    AS 
    select m.ID, m.Name as Musikstueck_Name, s.Name as Sammlung_Name 
    from musikstueck m 
    left join  sammlung s on s.ID = m.SammlungID 
    left join satz sa on sa.MusikstueckID = m.ID 
    where sa.ID is null 

    ;

    CREATE  OR REPLACE VIEW v_test_satz_ohne_musikstueck AS 
    select s.*
    from satz s 
    left join musikstueck m 
    on s.MusikstueckID = m.ID 
    where m.ID is null; 



/* tmp. distinct views  */ 

/* Sammlung */ 

    create or REPLACE view v_tmp_Standorte as 
    select distinct 0 as ID, Standort from sammlung
    where Standort is not null 
    and Standort <> ''
    order by Standort ; 

/* Musikstueck */ 

    create or REPLACE view v_tmp_Gattungen as 
    select distinct 0 as ID, Gattung from musikstueck
    where Gattung is not null 
    and Gattung <> ''
    order by Gattung ; 

    create or REPLACE view v_tmp_Epochen as 
    select distinct 0 as ID, Epoche from musikstueck 
    where Epoche is not null 
    and Epoche <> ''
    order by Epoche; 

/* satz */
    create or REPLACE view v_tmp_Tonart as 
    select distinct 0 as ID, Tonart from satz  
    where Tonart is not null 
    and Tonart <> ''
    order by Tonart; 


    create or REPLACE view v_tmp_Taktart as 
    select distinct 0 as ID, Taktart from satz  
    where Taktart is not null 
    and Taktart <> ''
    order by Taktart; 

    create or REPLACE view v_tmp_Tempobezeichnung as 
    select distinct 0 as ID, Tempobezeichnung from satz  
    where Tempobezeichnung is not null 
    and Tempobezeichnung <> ''
    order by Tempobezeichnung; 
  
    create or REPLACE view v_tmp_Schwierigkeitsgrad as 
    select distinct 0 as ID, Schwierigkeitsgrad from satz  
    where Schwierigkeitsgrad is not null 
    and Schwierigkeitsgrad <> ''
    order by Schwierigkeitsgrad; 
   
    create or REPLACE view v_tmp_Lagen as 
    select distinct 0 as ID, Lagen from satz  
    where Lagen is not null 
    and Lagen <> ''
    order by Lagen; 

  
    create or REPLACE view v_tmp_Erprobt as 
    select distinct 0 as ID, Erprobt from satz  
    where Erprobt is not null 
    and Erprobt <> ''
    order by Erprobt; 
        
     create or REPLACE view v_tmp_Notenwerte as 
    select distinct 0 as ID, Notenwerte from satz  
    where Notenwerte is not null 
    and Notenwerte <> ''
    order by Notenwerte
    -- ; 

-- /* ! am Ende der Datei kein Semikolon verwenden */ 

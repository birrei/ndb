/* Views für Auswahl-Elemente */ 


create or replace view v_sammlung as
select s.ID
    , s.Name
    , v.Name as Verlag
    , st.Name as Standort
    , s.Bestellnummer
    , s.Bemerkung 
from sammlung s
        left join verlag v on s.VerlagID = v.ID 
        left join standort st on s.StandortID = st.ID
    ; 


create or replace view v_komponist as 
select ID
    , case 
        when Vorname <> '' and Nachname <> '' 
        then  CONCAT(COALESCE(Nachname, '') , ', ', COALESCE(Vorname, '')) 
    when COALESCE(Vorname, '') = '' and COALESCE(Nachname,'') <> '' 
        then  Nachname 
    when COALESCE(Vorname,'') <> '' and COALESCE(Nachname, '')  =''
        then  Vorname 
    End Name
    , Vorname
    , Nachname 
from komponist
;



/* Testviews */

/* Sammlung */

    CREATE OR REPLACE VIEW v_test_sammlung_ohne_musikstueck AS 
    select s.ID, s.Name, 
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

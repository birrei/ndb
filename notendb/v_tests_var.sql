

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
    select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
    from sammlung s 
    inner join musikstueck m on s.ID = m.SammlungID 
    left join musikstueck_besetzung mb 
    on m.ID = mb.MusikstueckID 
    where mb.ID is null 
    ; 

    CREATE OR REPLACE VIEW v_test_musikstueck_ohne_komponist AS
    select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
    from sammlung s 
    left join musikstueck m on s.ID = m.SammlungID 
    left join komponist k 
    on m.KomponistID = k.ID
    where k.ID is null 
    ; 

    CREATE  OR REPLACE VIEW v_test_musikstueck_ohne_satz
    AS 
    select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
    from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    left join satz sa on sa.MusikstueckID = m.ID 
    where sa.ID is null 
    and m.ID is not nULL 

; 

/* Satz */

    CREATE  OR REPLACE VIEW v_test_satz_ohne_spieldauer AS 
        select s.Name as Sammlung_Name
        , sa.ID
        , m.Name as Musikstueck_Name
        , sa.Nr
        , sa.Name 
        , sa.Spieldauer
    from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
 where sa.Spieldauer is NULL

; 


CREATE  OR REPLACE VIEW v_test_satz_ohne_erprobt AS 
        select s.Name as Sammlung_Name
        , m.Name as Musikstueck_Name
        , sa.Nr 
        , sa.Name as Satz_Name 
       , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join erprobt on erprobt.ID = sa.ErprobtID 
 where erprobt.ID is NULL


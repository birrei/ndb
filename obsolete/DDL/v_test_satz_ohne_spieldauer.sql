
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
 order by sa.ID DESC 

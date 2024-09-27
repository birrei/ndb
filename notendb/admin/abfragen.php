
<?php 

include('../head_raw.php');
include("../cl_db.php"); 
include("../cl_abfrage.php"); 



/**************** vordefinierte Tests  */

/* Sammlung  */

$tests[] = array('name' => 'Test - Sammlungen ohne Musikstück'
              , 'query'   => "
              select s.ID, s.Name, standort.Name as Standort
                from sammlung s
                left join standort on standort.ID = s.StandortID 
                left join musikstueck m on s.ID = m.SammlungID 
                where m.ID is null 
                order by s.ID DESC 
              "
              , 'table'   => "sammlung"              
              );

$tests[] = array('name' => 'Test - Sammlungen ohne Verlag'
, 'query'   => "
            select s.ID, s.Name
            from sammlung s 
            left join verlag v on s.VerlagID = v.ID
            where v.ID is null 
            order by s.ID DESC "
, 'table'   => "sammlung"              
);




/* Musikstücke */



$tests[] = array('name' => 'Test - Musikstücke ohne Satz'
            , 'query'   => "select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
                from musikstueck m 
                inner join  sammlung s on s.ID = m.SammlungID 
                left join satz sa on sa.MusikstueckID = m.ID 
                where sa.ID is null 
                and m.ID is not nULL 
                order by m.ID DESC "
            , 'table'   => "musikstueck"              
           );


$tests[] = array('name' => 'Test - Musikstücke ohne Komponist'
           , 'query'   => "select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
                from sammlung s 
                left join musikstueck m on s.ID = m.SammlungID 
                left join komponist k 
                on m.KomponistID = k.ID
                where k.ID is null 
                order by m.ID DESC 
"
           , 'table'   => "musikstueck"              
          );



$tests[] = array(
        'name'    => 'Test - Musikstücke ohne Besetzung'
      , 'query'   => "select 
                        s.Name as Sammlung_Name
                        , m.ID
                        , m.Name as Musikstueck_Name
                      from sammlung s 
                      inner join musikstueck m on s.ID = m.SammlungID 
                      left join musikstueck_besetzung mb 
                      on m.ID = mb.MusikstueckID 
                      where mb.ID is null 
                      order by m.ID DESC"
        , 'table'   => "musikstueck"              
    );          



$tests[] = array(
        'name'    => 'Test - Musikstücke ohne Verwendungszweck'
      , 'query'   => "select 
                          sammlung.Name as Sammlung_Name
                          , musikstueck.ID
                          , musikstueck.Name as Musikstueck_Name
                      from sammlung
                      inner join musikstueck 
                          on sammlung.ID = musikstueck.SammlungID 
                      left join musikstueck_verwendungszweck 
                          on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
                      where musikstueck_verwendungszweck.ID is null 
                      order by musikstueck.ID DESC"
      , 'table'   => "musikstueck"              
    );          




  
/* Satz */

$tests[] = array('name' => 'Test - Satz ohne Spieldauer'
, 'query'   => "select sa.ID   
        , s.Name as Sammlung_Name
        , m.Name as Musikstueck_Name
        , sa.Nr as Satz_Nr
        , sa.Name as Satz_Name
        , sa.Bemerkung as Satz_Bemerkung 
    from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
 where sa.Spieldauer is NULL
 order by sa.ID DESC 

"
, 'table'   => "satz"              
);


$tests[] = array('name' => 'Test - Satz ohne Erprobt-Angabe'
, 'query'   => "
select s.Name as Sammlung_Name
        , m.Name as Musikstueck_Name
        , sa.Nr 
        , sa.Name as Satz_Name 
       , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_erprobt on satz_erprobt.SatzID = sa.ID 
where satz_erprobt.SatzID is NULL
order by sa.ID DESC 

"
, 'table'   => "satz"              
);

$tests[] = array('name' => 'Test - Satz ohne Schwierigkeitsgrad'
    , 'query'   => "
    select s.Name as Sammlung_Name
        , m.Name as Musikstueck_Name
        , sa.Nr 
        , sa.Name as Satz_Name 
       , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = sa.ID 
where satz_schwierigkeitsgrad.ID is NULL
order by sa.ID DESC
    "
    , 'table'   => "satz"              
    );



/* sonst */


$tests[] = array('name' => 'Test - Besonderheiten doppelt belegt'
              , 'query'   => "
                SELECT v_lookup.LookupTypeID as ID
                    --  , v_lookup.ID as LookupID
                    , v_lookup.Name as LookupName
                    , v_lookup.LookupType
                from v_lookup
                inner JOIN  (
                select Name, count(distinct LookupTypeID)  anz_typen 
                from v_lookup
                group by Name  
                having count(distinct LookupTypeID) > 1
                ) dbl
                on v_lookup.Name = dbl.Name
                order by v_lookup.Name
              "
              , 'table'   => "lookup_type"              
              );


$tests[] = array('name' => 'Alle verwendeten Tonarten'
              , 'query'   => "
                  select distinct Tonart from satz  
                where Tonart is not null 
                and Tonart <> ''
                order by Tonart
              "
              , 'table'   => ""              
              );


$tests[] = array('name' => 'Alle verwendeten Taktarten'
        , 'query'   => "
select distinct Taktart from satz  
where Taktart is not null 
and Taktart <> ''
order by Taktart
        "
        , 'table'   => ""              
        );

$tests[] = array('name' => 'Alle verwendeten Tempobezeichnungen'
        , 'query'   => "
            select distinct Tempobezeichnung from satz  
            where Tempobezeichnung is not null 
            and Tempobezeichnung <> ''
            order by Tempobezeichnung
                    "
        , 'table'   => ""              
        );



echo '<pre>'; 



foreach ($tests as $test){

    $abfrage = new Abfrage(); 
    $abfrage->Name=$test["name"];
    $abfrage->Beschreibung='*(Vordefinierte Abfrage)* ';
    $abfrage->Abfrage = $test["query"];
    $abfrage->Tabelle = $test["table"];
    $abfrage->insert_row2(); 

    echo 'Abfrage '.$abfrage->Name .' wurde gespeichert'.PHP_EOL; 
}


echo '</pre>'; 



include('../foot_raw.php');

?>

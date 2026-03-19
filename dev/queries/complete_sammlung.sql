SELECT sammlung.ID
        , sammlung.Name as Sammlung        
        , standort.Name as Standort    
        , verlag.Name as Verlag            
        , sammlung.Bemerkung as Bemerkung
        , GROUP_CONCAT(
            DISTINCT CONCAT('* ', 
              musikstueck.Nummer, ' - ', 
              musikstueck.Name, ' - ',  
              satz.Nr, 
              IF(satz.Name <> '', CONCAT(' - ', satz.Name), '') )  
              ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr 
              SEPARATOR '<br />') `Musikstueck und Saetze`          
        , GROUP_CONCAT(DISTINCT CONCAT('* ', material.Name)  ORDER BY material.Name SEPARATOR '<br >') Materialien 
        , lookups.LookupList as `Sammlung Besonderheiten` 
        , sammlung.Erfasst as `vollständig erfasst`
FROM sammlung 
    LEFT JOIN standort  on sammlung.StandortID = standort.ID    
    LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
    LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID
    -- LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID         
    LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID
    LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID
    LEFT JOIN material on material.SammlungID = sammlung.ID 
    LEFT JOIN v_sammlung_lookuptypes as lookups on lookups.SammlungID = sammlung.ID 


/* Druck-Version (CONCAT) -- nur Sammlung-Infos
   Entwurf für class.sammlung.php  -> print()
 */

SELECT sammlung.ID 
    , CONCAT('Sammlung ID: ', sammlung.ID, '<br>'
            , 'Sammlung Name: ', sammlung.Name, '<br>'
            , 'Verlag: ', verlag.Name, '<br>'
            , 'Bemerkung: ', verlag.Name, '<br>'                  
            , IF(COALESCE(sammlung.Bemerkung,'') <> '', concat('Bemerkung: ', sammlung.Bemerkung,''))                  
    )  as RowDesc   
FROM sammlung 
    LEFT JOIN standort  on sammlung.StandortID = standort.ID    
    LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
    LEFT JOIN v_sammlung_lookuptypes as lookups on lookups.SammlungID = sammlung.ID 


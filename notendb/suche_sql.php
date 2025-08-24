<?php 

function getSQL_SELECT($Ansicht){
  $query=''; 
  switch ($Ansicht){
        
    case 'Sammlung': 
      $query.="SELECT sammlung.ID
      , sammlung.Name as Sammlung
      , standort.Name as Standort                  
      , verlag.Name as Verlag
      , sammlung.Bemerkung ".PHP_EOL;

      break; 

    case 'Sammlung erweitert': 
      $query.="SELECT sammlung.ID
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
      , sammlung.Erfasst as `vollständig erfasst`".PHP_EOL; 

      break; 
            
    case 'Sammlung Links': 
      $query.="SELECT sammlung.ID
      , standort.Name as Standort
      , sammlung.Name as Sammlung
      , links.LinkText             
      , links.LinkTyp ".PHP_EOL; 

      break;   

    case 'Musikstueck':         
      $query.="SELECT musikstueck.ID
      , standort.Name as Standort        
      , sammlung.Name as Sammlung
      , musikstueck.Nummer as Nr
      , musikstueck.Name as Musikstueck
      , komponist.Name as Komponist
      , v_musikstueck_besetzungen.Besetzungen 
      , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke   
      , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Saetze         
      , musikstueck.Bearbeiter 
      , gattung.Name as Gattung 
      , epoche.Name as Epoche ".PHP_EOL;         

      break; 
  

        
    case 'Satz': 
      $query.="SELECT satz.ID
          , standort.Name as Standort        
          ,sammlung.Name as Sammlung
          -- , musikstueck.Nummer as MNr
          , komponist.Name as Komponist            
          , musikstueck.Name as Musikstueck
          , satz.Nr as Nr
          , satz.Name as Satz 
          , satz.Tempobezeichnung            
          , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                   
          -- , SatzSchwierigkeitsgrad.Schwierigkeitsgrade           
        , v_satz_lookuptypes.LookupList as Besonderheiten                  
          , satz.Orchesterbesetzung 
          , satz.Bemerkung 
          
          ".PHP_EOL;        
          
        break;   
              
        
    case 'Satz Schueler': 
      $query.="SELECT satz.ID
          , standort.Name as Standort
          , CONCAT(
              'Sammlung: ',sammlung.Name, 
              ', Musikstück: ', musikstueck.Nummer, ' ', musikstueck.Name, 
              ', Satz: ', satz.Nr, '  ', satz.Name) Satz
          , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                    
          , GROUP_CONCAT(DISTINCT concat(schueler.Name, ' (Status: ', status.Name, ')')  ORDER BY schueler.Name SEPARATOR '<br > ') Schueler  ".PHP_EOL;                   

      break;     

    case 'Satz Besonderheiten':           
      $query.="SELECT satz.ID
      , v_satz_lookuptypes.LookupList2 as Besonderheiten    
      , standort.Name as Standort                              
      , sammlung.Name as Sammlung
      , musikstueck.Nummer as MNr
      , musikstueck.Name as Musikstueck
      , satz.Nr as SatzNr
      , satz.Name as Satz ".PHP_EOL;        

      break;   

    
    case 'Material': 
      $query.="select material.ID
      , material.Name
      , material.Bemerkung 
      , materialtyp.Name as Materialtyp
      , sammlung.Name as Sammlung ".PHP_EOL;        
      
      break;   

    case 'Material_erweitert': 
      $query.="select material.ID
      , material.Name
      , material.Bemerkung 
      , materialtyp.Name as Materialtyp
      , sammlung.Name as Sammlung  
      , GROUP_CONCAT(DISTINCT concat(schueler.Name, ' (Status: ', status.Name, ')')  ORDER BY schueler.Name SEPARATOR '<br > ') Schueler   ".PHP_EOL;        
      break;  

    case 'Schueler': 
      $query.="SELECT schueler.ID 
      , schueler.Name
      , schueler.Bemerkung       
      , v_schueler_instrumente.Instrumente  
      , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN ".PHP_EOL;        
      break; 
    case 'Schueler erweitert':         
      $query.="SELECT schueler.ID 
      , schueler.Name
      , schueler.Bemerkung       
      , v_schueler_instrumente.Instrumente
      , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN   
      , GROUP_CONCAT(DISTINCT CONCAT(
                  IF(sm.ID is not null
                      , CONCAT('* ', sm.Name, ': ', material.Name)
                      , CONCAT('* ', material.Name)
                    ) 
                    , IF(schueler_material.StatusID is not null, CONCAT(' / Status: ', status_m.Name), '')
                    , IF(schueler_material.Bemerkung <> '', CONCAT(' / ', schueler_material.Bemerkung), '')		                  
                  ) 
                  order by 
                  IF(sm.ID is not NULL, CONCAT(sm.Name, ': ', material.Name), material.Name)
            SEPARATOR '<br />') as Materialien
      , GROUP_CONCAT(
              DISTINCT concat('* ', sammlung.Name, ' / ', musikstueck.Name, 
                      IF(satz.Name <> '', CONCAT(' / ', satz.Name), ''), 
                      IF(schueler_satz.StatusID is not null, CONCAT(' / Status: ', status_s.Name), ''),
                      IF(schueler_satz.Bemerkung <> '', CONCAT(' / ', schueler_satz.Bemerkung), '')
          )  
          order by sammlung.Name, musikstueck.Nummer 
          SEPARATOR '<br />') as Noten ".PHP_EOL;        
      break;  
  }
  return $query; 
}

function getSQL_FROM($Ansicht){
  $query=''; 
  switch ($Ansicht){
    case 'Sammlung':       
      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID 
      LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
      LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
      LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID           
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID
      LEFT JOIN material on material.SammlungID = sammlung.ID        
      ".PHP_EOL; 
      break; 


    case 'Sammlung erweitert':       
      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID
      LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
      LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
      LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID        
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID
      LEFT JOIN material on material.SammlungID = sammlung.ID 
      LEFT JOIN v_sammlung_lookuptypes as lookups on lookups.SammlungID = sammlung.ID ".PHP_EOL; 
      break; 

    case 'Sammlung Links':       
      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID 
      LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
      LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
      LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID           
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
      LEFT JOIN material on material.SammlungID = sammlung.ID       
      LEFT JOIN v_links as links on links.SammlungID = sammlung.ID ".PHP_EOL; 
      break; 
      
    case 'Musikstueck': 
      $query="FROM sammlung 
        LEFT JOIN standort  on sammlung.StandortID = standort.ID    
        LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
        LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID 
        LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
        LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
        LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID     
        LEFT JOIN material on material.SammlungID = sammlung.ID                  
        LEFT JOIN (
          select musikstueck_besetzung.MusikstueckID         
              , GROUP_CONCAT(DISTINCT besetzung.Name  order by besetzung.Name SEPARATOR ', ') Besetzungen       
          from musikstueck_besetzung 
              left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
          group by musikstueck_besetzung.MusikstueckID 
                  ) v_musikstueck_besetzungen 
              on v_musikstueck_besetzungen.MusikstueckID = musikstueck.ID 
        LEFT JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
        LEFT JOIN verwendungszweck on musikstueck_verwendungszweck.VerwendungszweckID=verwendungszweck.ID    
        LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
        LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID ". PHP_EOL; 
        break; 

    case 'Satz':
      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID
       LEFT JOIN material on material.SammlungID = sammlung.ID             
      LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
      LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
      LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID        
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
      LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
      LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
      LEFT JOIN instrument_schwierigkeitsgrad 
          ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
          AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
      LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
      LEFT JOIN schueler_satz on schueler_satz.SatzID = satz.ID ". PHP_EOL; 

      
      // -- LEFT JOIN schueler on schueler.ID = schueler_satz.SchuelerID
      // -- LEFT JOIN material on sammlung.ID = material.SammlungID 
      // -- LEFT JOIN materialtyp on materialtyp.ID = material.MaterialtypID

      // LEFT JOIN (
      //   SELECT satz_schwierigkeitsgrad.SatzID      
      //       , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  
      //         ORDER by concat(instrument.Name, ': ', schwierigkeitsgrad.Name) SEPARATOR ', ') `Schwierigkeitsgrade`                    
      //   from satz_schwierigkeitsgrad 
      //   LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      //   LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      //   group by satz_schwierigkeitsgrad.SatzID 
      //   )  SatzSchwierigkeitsgrad ON satz.ID = SatzSchwierigkeitsgrad.SatzID 

      break; 
        
    case 'Satz Besonderheiten':   
      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID  
      LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
      LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
      LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID        
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
      LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
      LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
      LEFT JOIN instrument_schwierigkeitsgrad 
          ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
          AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
      LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
      LEFT JOIN schueler_satz on schueler_satz.SatzID = satz.ID 
       LEFT JOIN material on material.SammlungID = sammlung.ID           
      
      ". PHP_EOL;                   

      // LEFT JOIN (
      //   SELECT satz_schwierigkeitsgrad.SatzID      
      //       , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  
      //         ORDER by concat(instrument.Name, ': ', schwierigkeitsgrad.Name) SEPARATOR ', ') `Schwierigkeitsgrade`                    
      //   from satz_schwierigkeitsgrad 
      //   LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      //   LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      //   group by satz_schwierigkeitsgrad.SatzID 
      //   )  SatzSchwierigkeitsgrad ON satz.ID = SatzSchwierigkeitsgrad.SatzID 

      break; 

    case 'Satz Schueler': 

      $query="FROM sammlung 
      LEFT JOIN standort  on sammlung.StandortID = standort.ID    
      LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID  
      LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
      LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
       LEFT JOIN material on material.SammlungID = sammlung.ID           
      LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
      LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
      LEFT JOIN instrument_schwierigkeitsgrad 
          ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
          AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
      LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
      LEFT JOIN schueler_satz on schueler_satz.SatzID = satz.ID
      LEFT JOIN schueler on schueler.ID = schueler_satz.SchuelerID
      LEFT JOIN status ON status.ID = schueler_satz.StatusID ". PHP_EOL;                   
  
      break; 

    case 'Material_erweitert':
      $query="FROM material  
      LEFT JOIN materialtyp on materialtyp.ID = material.MaterialtypID 
      LEFT JOIN sammlung on sammlung.ID = material.SammlungID 
      LEFT JOIN schueler_material on schueler_material.MaterialID = material.ID 
      LEFT JOIN status on status.ID = schueler_material.StatusID         
      LEFT JOIN schueler on schueler.ID = schueler_material.SchuelerID  ". PHP_EOL; 

      break; 

    case 'Material': 
      $query="FROM material  
      LEFT JOIN materialtyp on materialtyp.ID = material.MaterialtypID 
      LEFT JOIN sammlung on sammlung.ID = material.SammlungID 
      LEFT JOIN schueler_material on schueler_material.MaterialID = material.ID ". PHP_EOL; 

      break; 


    case 'Schueler': 
      $query.="FROM schueler 
      LEFT join schueler_material on schueler_material.SchuelerID = schueler.ID
      LEFT join material on material.ID = schueler_material.MaterialID 
      LEFT JOIN status status_m on status_m.Name = schueler_material.StatusID      
      LEFT join sammlung sm on sm.ID=material.SammlungID 
      LEFT join schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
      LEFT join status as status_s on status_s.ID = schueler_satz.StatusID
      LEFT join satz on satz.ID = schueler_satz.SatzID 
      LEFT join musikstueck on musikstueck.ID = satz.MusikstueckID
      LEFT join sammlung on sammlung.ID = musikstueck.SammlungID    
      LEFT join v_schueler_instrumente on v_schueler_instrumente.SchuelerID = schueler.ID ". PHP_EOL; 

      break;         
    case 'Schueler erweitert': 
      $query.="FROM schueler 
      LEFT join schueler_material on schueler_material.SchuelerID = schueler.ID
      LEFT join material on material.ID = schueler_material.MaterialID 
      LEFT JOIN status status_m on status_m.Name = schueler_material.StatusID      
      LEFT join sammlung sm on sm.ID=material.SammlungID 
      LEFT join schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
      LEFT join status as status_s on status_s.ID = schueler_satz.StatusID
      LEFT join satz on satz.ID = schueler_satz.SatzID 
      LEFT join musikstueck on musikstueck.ID = satz.MusikstueckID
      LEFT join sammlung on sammlung.ID = musikstueck.SammlungID    
      LEFT join v_schueler_instrumente on v_schueler_instrumente.SchuelerID = schueler.ID ". PHP_EOL; 

        break;      
  }

  return $query; 
}  

function getSQL_WHERE_Filter_Lookup($lookup_values_selected, $relations) {
  // Filter: einer oder mehrere LookupIDs können zutreffen (normaler Modus)
  // echo 'Anzahl relations: '.count($relations).'<br>'; // TEST 
  //   echo 'Anzahl lookups: '.count($lookup_values_selected).'<br>'; // TEST 
  
  
  $query_WHERE=''; 
  

  if(count($relations) > 1) {
    // Lookup-Typ mit mehreren Relations -> ODER verknüpfung! 
    $query_WHERE.='AND (1=2 '. PHP_EOL; 
    for ($r = 0; $r < count($relations); $r++) {

      //  $relation=$relations[$r]; 
      //  echo 'relation: '.$relation.'<br>'; // TEST
      switch($relations[$r]) {
        case 'satz'; 
          $query_WHERE.='OR satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
        break;      
        case 'musikstueck'; 
          $query_WHERE.='OR musikstueck.ID IN (SELECT MusikstueckID from musikstueck_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
        break;    
        case 'sammlung'; 
          $query_WHERE.='OR sammlung.ID IN (SELECT SammlungID from sammlung_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
        break;                                               
        case 'material'; 
          $query_WHERE.='OR material.ID IN (SELECT MaterialID from material_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
        break;                   
      }

    }
    $query_WHERE.=') '. PHP_EOL;
  } elseif(count($relations)==1) {
    // Lookup-Typ mit genau einer relation-Verknüpfung
    // echo 'relation 0: '.$relations[0]; // TEST 
    switch($relations[0]) {
      case 'satz'; 
        $query_WHERE.='AND satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
      break;      
      case 'musikstueck'; 
        $query_WHERE.='AND musikstueck.ID IN (SELECT MusikstueckID from musikstueck_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
      break;    
      case 'sammlung'; 
        $query_WHERE.='AND sammlung.ID IN (SELECT SammlungID from sammlung_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
      break;                                               
      case 'material'; 
        $query_WHERE.='AND material.ID IN (SELECT MaterialID from material_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) '. PHP_EOL; 
      break;                   
    }
  }   
  
  return $query_WHERE; 
}

function getSQL_WHERE_Filter_Lookup_include($LookupID, $relations) {
  // Filter: alle ausgewählten LookupIDs müssen zutreffen ("Einschluss-Suche") 
  // XXXX 

  $query_WHERE=''; 

  if(count($relations) > 1) {
    // Lookup-Typ mit mehreren Relations -> ODER verknüpfung! 
    $query_WHERE.='AND (1=2 '; 
    for ($r = 0; $r < count($relations); $r++) {
      switch($relations[$r]) {
        case 'satz'; 
          $query_WHERE.='OR satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID='.$LookupID.') '. PHP_EOL; 
        break;      
        case 'musikstueck'; 
          $query_WHERE.='OR musikstueck.ID IN (SELECT MusikstueckID from musikstueck_lookup WHERE LookupID='.$LookupID.') '. PHP_EOL; 
        break;    
        case 'sammlung'; 
          $query_WHERE.='OR sammlung.ID IN (SELECT SammlungID from sammlung_lookup WHERE LookupID='.$LookupID.') '. PHP_EOL; 
        break;                                               
        case 'material'; 
          $query_WHERE.='OR material.ID IN (SELECT MaterialID from sammlung_lookup WHERE LookupID='.$LookupID.') '. PHP_EOL; 
        break;                   
      }
        $query_WHERE.=') ';
    }
  } elseif(count($relations)==1) {
    // Lookup-Typ mit genau einer relation-Verknüpfung
    // echo 'relation 0: '.$relations[0]; // TEST 
    switch($relations[0]) {
      case 'satz'; 
        $query_WHERE.='AND satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID='.$LookupID.') '. PHP_EOL; 
      break;      
      case 'musikstueck'; 
        $query_WHERE.='AND musikstueck.ID IN (SELECT MusikstueckID from musikstueck_lookup WHERE LookupID='.$LookupID.' '. PHP_EOL; 
      break;    
      case 'sammlung'; 
        $query_WHERE.='AND sammlung.ID IN (SELECT SammlungID from sammlung_lookup WHERE LookupID='.$LookupID.' '. PHP_EOL; 
      break;                                               
      case 'material'; 
        $query_WHERE.='AND material.ID IN (SELECT MaterialID from sammlung_lookup WHERE LookupID='.$LookupID.' '. PHP_EOL; 
      break;                   
    }
  } 

  return $query_WHERE; 
}


function getSQL_WHERE_Suchtext($AnsichtGruppe, $suchtext) {
  $strSQL=''; 
  switch($AnsichtGruppe) {
    case 'Noten': 
      $strSQL="AND (sammlung.Name LIKE '%".$suchtext."%' OR  
      sammlung.Bemerkung LIKE '%".$suchtext."%' OR                              
      musikstueck.Name LIKE '%".$suchtext."%' OR                              
      musikstueck.Opus LIKE '%".$suchtext."%' OR
      musikstueck.Bearbeiter LIKE '%".$suchtext."%' OR 
      komponist.Name  LIKE '%".$suchtext."%' OR 
      epoche.Name  LIKE '%".$suchtext."%' OR    
      gattung.Name  LIKE '%".$suchtext."%' OR                 
      satz.Name LIKE '%".$suchtext."%' OR
      satz.Tempobezeichnung LIKE '%".$suchtext."%' OR
      satz.Orchesterbesetzung LIKE '%".$suchtext."%' OR 
      satz.Bemerkung LIKE '%".$suchtext."%' OR 
      satz_erprobt.Bemerkung LIKE '%".$suchtext."%') ". PHP_EOL; 
      break; 
    case 'Schueler':  
      $strSQL="AND (schueler.Name LIKE '%".$suchtext."%' OR  
      schueler.Bemerkung LIKE '%".$suchtext."%' OR                              
      schueler_satz.Bemerkung LIKE '%".$suchtext."%' OR                              
      schueler_material.Bemerkung LIKE '%".$suchtext."%') ". PHP_EOL;              
      break;   
    case 'Material':   
      $strSQL="AND (material.Name LIKE '%".$suchtext."%' OR  
      material.Bemerkung LIKE '%".$suchtext."%'                                                                                                
      ) ". PHP_EOL;              
      break;              
  }
  return $strSQL; 
}

function getSQL_GROUP_BY($AnsichtEbene) {
  $strSQL=''; 
  switch ($AnsichtEbene){    
    case 'Sammlung':
      $strSQL.="GROUP BY sammlung.ID ". PHP_EOL;     
      break;                      
    case 'Musikstueck': 
      $strSQL.="GROUP BY musikstueck.ID ". PHP_EOL;        
      break; 
    case 'Satz':                 
      $strSQL.="GROUP BY satz.ID ". PHP_EOL;             
      break;      
    case 'Material':         
      $strSQL.="GROUP BY material.ID ". PHP_EOL;     
      break;  
    case 'Schueler':         
    case 'Schueler erweitert':     
      $strSQL.="GROUP BY schueler.ID ". PHP_EOL;     
      break;             
  }
  return $strSQL; 
}

function getSQL_ORDER_BY($Ansicht, $filter=true) {  
  $strSQL=''; 
  switch ($Ansicht){    
    case 'Sammlung': 
    case 'Sammlung Links':   
    case 'Sammlung erweitert':  
      $strSQL.=($filter?'ORDER BY sammlung.Name':'ORDER BY sammlung.ID DESC LIMIT 5').PHP_EOL;                     
      break; 
    case 'Musikstueck': 
      $strSQL.=($filter?'ORDER BY sammlung.Name, musikstueck.Nummer':'ORDER BY musikstueck.ID DESC LIMIT 5').PHP_EOL;                         
      break; 
    case 'Satz Besonderheiten':   
    case 'Satz Schueler':                     
    case 'Satz': 
      $strSQL.=($filter?'ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr ':'ORDER BY satz.ID DESC LIMIT 5').PHP_EOL;                
      break;  
    case 'Material':    
    case 'Material_erweitert':          
      $strSQL.=($filter?'ORDER BY material.Name ':'ORDER BY material.ID DESC LIMIT 5').PHP_EOL;             
      break;    
    case 'Schueler': 
    case 'Schueler erweitert':  
      $strSQL.=($filter?'ORDER BY schueler.Name ':'ORDER BY schueler.ID DESC LIMIT 5').PHP_EOL;           
      break;                                   
  }
  return $strSQL; 
}

function getAnsichtGruppe($AnsichtEbene) {
  $strTmp=''; 
  switch ($AnsichtEbene){
    case 'Sammlung':        
    case 'Musikstueck': 
    case 'Satz':
      $strTmp='Noten';                         
      break;   
    case 'Material':
      $strTmp='Material'; 
      break; 
    case 'Schueler': 
      $strTmp='Schueler'; 
      break; 
    }
    return $strTmp; 
}

function getAnsichtEbene($Ansicht) {
  $AnsichtEbene=''; 
  switch ($Ansicht){
    case 'Sammlung Links': 
    case 'Sammlung erweitert':    
    case 'Sammlung':               
      $AnsichtEbene='Sammlung'; 
      break;   
    case 'Musikstueck': 
    case 'Musikstueck Summe':       
      $AnsichtEbene='Musikstueck'; 
      break; 
    case 'Satz Schueler': 
    case 'Satz Besonderheiten':
    case 'Satz':         
      $AnsichtEbene='Satz';                         
      break;   
    case 'Material':
    case 'Material_erweitert':        
      $AnsichtEbene='Material';                         
      break;   
    case 'Schueler':
    case 'Schueler erweitert':
      $AnsichtEbene='Schueler';                         
      break;          
    }
    return $AnsichtEbene; 
}

function getEditTable($AnsichtEbene) {

  switch ($AnsichtEbene){
    case 'Sammlung':        
      $edit_table='sammlung'; 
      break;   
    case 'Musikstueck': 
      $edit_table='musikstueck'; 
      break; 
    case 'Satz':
      $edit_table='satz';                         
      break;   
    case 'Material':
      $edit_table='material';                         
      break;  
    case 'Schueler':
      $edit_table='schueler';                         
      break;                      
    }
    return $edit_table; 
}



?>

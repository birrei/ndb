<?php
$PageTitle='Verwendungszweck Planung'; 
include_once('head.php');

include_once("classes/dbconn/class.db.php");
include_once("classes/class.verwendungszweck.php");
include_once("classes/class.htmltable.php"); 
include_once("classes/class.htmlinfo.php"); 

  echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 

/***** Einstellungen für Bearbeiten-Link */

$add_link_edit=true; // Bearbeiten-Link in Ergebnistabelle anzeigen
$table_edit_title='satz'; // Titel der Seite, die über den Bearbeiten-Link aufgerufen wird 
$edit_link_show_newpage=false; // true: Das öffnen des Bearbeiten-Links soll in einem neuen Fenster erfolge

$VerwendungszweckID=(isset($_REQUEST["VerwendungszweckID"])?$_REQUEST["VerwendungszweckID"]:'');

/********************************/

echo '<form action="" method="get">'.PHP_EOL; 
$Verwendungszweck = new Verwendungszweck(); 
echo 'Verwendungszweck: '.PHP_EOL; 
$Verwendungszweck->print_preselect($VerwendungszweckID); 

echo '<form><br><br>';           

if ($VerwendungszweckID=='') {goto pagefoot;}

$query="SELECT satz.ID
          , standort.Name as Standort        
          ,sammlung.Name as Sammlung
          -- , musikstueck.Nummer as MNr
          , komponist.Name as Komponist            
          , musikstueck.Name as Musikstueck
          , satz.Nr as Nr
          , satz.Name as Satz 
          , satz.Tempobezeichnung            
         -- , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                   
          -- , SatzSchwierigkeitsgrad.Schwierigkeitsgrade           
          , v_satz_lookuptypes.LookupList as Besonderheiten                  
          , satz.Orchesterbesetzung 
          , satz.Bemerkung 
          , SEC_TO_TIME(satz.Spieldauer) as `Spieldauer` 
          
        FROM sammlung 
          LEFT JOIN standort  on sammlung.StandortID = standort.ID    
          LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID  
          LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
          -- LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
          -- LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID     
          LEFT JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
          LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
          LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
          LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
          -- LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
          -- LEFT JOIN instrument_schwierigkeitsgrad 
          --     ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
          --     AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
          -- LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
          -- LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
          LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
          LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
          LEFT JOIN schueler_satz on schueler_satz.SatzID = satz.ID 

          WHERE 1=1 
            ";

$query.=($VerwendungszweckID!=''?'AND VerwendungszweckID='.$VerwendungszweckID.' '.PHP_EOL:''); 

$query.= 'GROUP BY satz.ID'.PHP_EOL; 

$query.= 'ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr '.PHP_EOL; 

// echo '<pre>'.$query.'</pre>'; // Test 

/******************************* */



$conn = new DBConnection(); 
$db=$conn->db; 

// ------------------------------------------------

$query_Summe="SELECT SEC_TO_TIME(SUM(satz.Spieldauer)) as `Summe Spieldauer`  
    from musikstueck inner join satz 
    on satz.MusikstueckID = musikstueck.ID 
    inner JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
    where musikstueck_verwendungszweck.VerwendungszweckID=".$VerwendungszweckID.PHP_EOL; 
    ; 


$select = $db->prepare($query_Summe); 
  
try {
  $select->execute(); 
  $html = new HTML_Table($select); 
  $html->add_link_edit= false; 
  // $html->edit_link_table='satz'; 
  // $html->edit_link_open_newpage = true; 
  // $html->edit_link_title= $table_edit_title; 
  echo '<div width="20%">'; 
  $html->print_table2();
  echo '</div>';  
}
catch (PDOException $e) {

  $info = new HTML_Info();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}



// ------------------------------------------------

$select = $db->prepare($query); 
  
try {
  $select->execute(); 
  $html = new HTML_Table($select); 
  $html->add_link_edit= $add_link_edit; 
  $html->edit_link_table='satz'; 
  $html->edit_link_open_newpage = true; 
  $html->edit_link_title= $table_edit_title; 
  $html->print_table2(); 
}
catch (PDOException $e) {

  $info = new HTML_Info();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}



pagefoot: 

include_once('foot.php');
?>

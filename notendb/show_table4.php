<?php
include_once('classes/class.htmlinfo.php');
include_once('classes/class.sqlpart.php');

$Ansicht=$_REQUEST["Ansicht"]; 

$show_data=true; 
$add_link_edit=true; 
$show_insert_link=false; // "Neu einfügen" - Link anzeigen ja / nein - default: nein 
$add_link_show=false; 

/*********** Filter  ********************/

switch ($Ansicht) {

  case 'schueler': 
    $PageTitle='Übersicht Schüler';  
    include_once('head.php');   
    include_once("classes/class.status.php");
    include_once("classes/class.wochentage.php");

    $table='schueler'; 
    $table_edit = $table; 
    $show_insert_link=true;     

    echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 

    $StatusID=(isset($_REQUEST["StatusID"])?$_REQUEST["StatusID"]:'');
    $Status_Umkehr=(isset($_REQUEST["Status_Umkehr"])?true:false);    
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:'');
    $Unterricht_Wochentag =(isset($_REQUEST["wochentag_nr"])?$_REQUEST["wochentag_nr"]:0);

    $Aktiv=1; 
    if(isset($_REQUEST["Filter"])) {
      $Aktiv=(isset($_REQUEST["Aktiv"])?1:0); 
    }



    echo '<form action="" method="get">'.PHP_EOL;  
    echo '<label><input type="checkbox" name="Aktiv" onchange="this.form.submit()" '.($Aktiv==1?'checked':'').'>Aktiv</label>'; 
    echo ' &#9475;';

    $status = new Status(); 
    echo 'Status Satz Verknüpfung: '.PHP_EOL; 
    $status->print_preselect($StatusID); 

    echo '<label><input type="checkbox" name="Status_Umkehr" onchange="this.form.submit()" '.($Status_Umkehr?'checked':'').'>Umkehrsuche</label>'; 
    echo ' &#9475;'; 
    echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 
    echo ' &#9475; Wochentag: '; 
    $wochentage = new Wochentage(); 
    $wochentage->print_preselect($Unterricht_Wochentag); 
        
    echo '<input type="hidden" name="Ansicht" value="'.$Ansicht.'">'; 
    echo '<input type="hidden" name="Filter" value="gesetzt">'; // Nur beim Erstaufruf der Seite nicht gesetzt 
    echo '</form><br>';           

    $sqlpart = new SQLPart(); 

    $query="SELECT schueler.ID 
          , schueler.Name
          , schueler.Bemerkung       
          , v_schueler_instrumente.Instrumente
          -- , wochentage.wochentag_name
          , IF(schueler.Unterricht_Wochentag=0, '', wochentage.wochentag_name) as   `Unterricht Wochentag` 
          , IF(schueler.Unterricht_Reihenfolge=0, '', schueler.Unterricht_Reihenfolge) as `Unterricht Tag Reihenfolge` 
          , IF(COUNT(distinct uebung.Datum) > 0, COUNT(distinct uebung.Datum), NULL) as `Uebung Tage`  
          , MAX(uebung.Datum) as `Datum letzte Übung` "; 

      if ($StatusID!='') {
        $query.=', '.$sqlpart->getSQL_COL_CONCAT_Noten(200); 
      }

    $query.="
        FROM schueler 
          LEFT JOIN  v_schueler_instrumente ON v_schueler_instrumente.SchuelerID = schueler.ID 
          LEFT JOIN uebung ON schueler.ID = uebung.SchuelerID
          LEFT JOIN schueler_satz on  schueler_satz.SchuelerID= schueler.ID 
          LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag 
      ";

    $query.="

          LEFT JOIN status on schueler_satz.StatusID= status.ID             
          LEFT join satz on satz.ID = schueler_satz.SatzID 
          LEFT join musikstueck on musikstueck.ID = satz.MusikstueckID 
          LEFT JOIN sammlung on sammlung.ID = musikstueck.SammlungID
      WHERE 1=1 
      ";

      // if ($Status_Umkehr) {
      //   $query.=($StatusID!=''?'AND schueler.ID NOT IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // } else {
      //   $query.=($StatusID!=''?'AND schueler.ID IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // }
    
    $query.=($Aktiv==1?"AND schueler.Aktiv=1 ".PHP_EOL:"AND schueler.Aktiv=0 "); 

    if ($Status_Umkehr) {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID!='.$StatusID.' '.PHP_EOL:' ');
    } else {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID='.$StatusID.' '.PHP_EOL:' ');      
    }

    if ($Unterricht_Wochentag > 0 ) {
      $query.="AND schueler.Unterricht_Wochentag=".$Unterricht_Wochentag." ";  
    }

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ";  
    }

    $query.="GROUP By schueler.ID 
            -- ORDER BY schueler.Name 
            ORDER BY schueler.Unterricht_Reihenfolge 
            "; 

    break; 


  case 'uebungen': 
    $PageTitle='Übersicht Übungen';  
    include_once('head.php');   

    $table='uebung'; 
    $table_edit = $table; 

    echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 
    
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 

    echo '<form action="" method="get">'.PHP_EOL;       

    echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    echo '<input type="hidden" name="Ansicht" value="'.$Ansicht.'">'; 

    echo '</form><br>';           

    $sqlpart = new SQLPart(); 

    $query="SELECT 
                  schueler.Name as Schueler
                  , uebung.Datum as `Datum`                   
                  , schueler.Unterricht_Reihenfolge as `Reihenfolge`
                  , uebung.Name as `Uebung Inhalt`  
                  "; 

    $query.=", ".$sqlpart->getSQL_COL_CONCAT_Noten(300); 
    $query.="      
                  , v_uebung_lookuptypes.LookupList2 as Besonderheiten   
                  , uebung.Bemerkung 
                  , CONCAT(uebung.Anzahl, ' ', uebungtyp.Einheit) Menge  
                  , uebungtyp.Name as `Uebung Typ`
                  , uebung.ID
    
    "; 

    $query.="FROM uebung 
                  INNER join schueler on schueler.ID=uebung.SchuelerID
                                and schueler.Aktiv=1
                  left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
                  left join satz  on satz.ID=uebung.SatzID 
                  left join musikstueck on satz.MusikstueckID = musikstueck.ID
                  left JOIN sammlung on sammlung.ID = musikstueck.SammlungID
                  left join v_uebung_lookuptypes on v_uebung_lookuptypes.UebungID=uebung.ID 

    
                WHERE 1=1 "; 

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ";  
    }

    $query.="ORDER BY uebung.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name "; 

  break; 
 
}

if ($show_insert_link) {
  echo '<a href="edit_'.$table.'.php?option=insert">Neu erfassen</a><br><br>';
}

/******************************* */
    // echo '<pre>'.$query.'</pre>'; // Test 

include_once("classes/dbconn/class.db.php");
$conn = new DBConnection(); 
$db=$conn->db; 

$select = $db->prepare($query); 
  
try {
  $select->execute(); 
  include_once("classes/class.htmltable.php");      
  $html = new HTML_Table($select); 
  // $html->add_link_show=$add_link_show; 
  $html->add_link_edit= $add_link_edit; 
  $html->edit_link_table=$table_edit; 
  $html->edit_link_open_newpage = true; 
  // $html->edit_link_title= $table_edit_title; 
  $html->print_table2(); 
}
catch (PDOException $e) {
  // include_once("classes/class.htmlinfo.php"); 
  $info = new HTML_Info();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}


pagefoot: 
include_once('foot.php');
?>

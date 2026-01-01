<?php
include_once('classes/class.htmlinfo.php');
include_once('classes/class.sqlpart.php');

$table=$_REQUEST["table"]; 

$show_data=true; 
$add_link_edit=true; 
$show_insert_link=false; // "Neu einfügen" - Link anzeigen ja / nein - default: nein 
$add_link_show=false; 
$table_edit = $table; 

/*********** Filter  ********************/

switch ($table) {

  case 'schueler': 
    $PageTitle='Übersicht Schüler';  
    include_once('head.php');   


    echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 

    echo '<form action="" method="get">'.PHP_EOL;       
    include_once("classes/class.status.php");
    $StatusID=(isset($_REQUEST["StatusID"])?$_REQUEST["StatusID"]:'');
    $Status_Umkehr=(isset($_REQUEST["Status_Umkehr"])?true:false);    
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:'');

    $status = new Status(); 
    echo 'Status Satz Verknüpfung: '.PHP_EOL; 
    $status->print_preselect($StatusID); 

    echo '<label><input type="checkbox" name="Status_Umkehr" onchange="this.form.submit()" '.($Status_Umkehr?'checked':'').'>Umkehrsuche</label>'; 

    echo '&#9475;'; 
    echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    echo '<input type="hidden" name="table" value="'.$table.'">'; 

    echo '</form><br>';           

    // if (empty($Datum)) {
    //   echo 'Datum ist leer '; 
    // } else {
    //   echo $Datum; 
    // }

    $sqlpart = new SQLPart(); 


    $query="SELECT schueler.ID 
          , schueler.Name
          , schueler.Bemerkung       
          , v_schueler_instrumente.Instrumente         
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
      ";

    $query.="

          LEFT JOIN status on schueler_satz.StatusID= status.ID             
          LEFT join satz on satz.ID = schueler_satz.SatzID 
          LEFT join musikstueck on musikstueck.ID = satz.MusikstueckID 
          LEFT JOIN sammlung on sammlung.ID = musikstueck.SammlungID
      WHERE 1=1 
      AND schueler.Aktiv=1 
      ";

      // if ($Status_Umkehr) {
      //   $query.=($StatusID!=''?'AND schueler.ID NOT IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // } else {
      //   $query.=($StatusID!=''?'AND schueler.ID IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // }
    

    if ($Status_Umkehr) {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID!='.$StatusID.' '.PHP_EOL:' ');
    } else {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID='.$StatusID.' '.PHP_EOL:' ');      
    }

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ";  
    }

    $query.="GROUP By schueler.ID 
            ORDER BY schueler.Name "; 

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
  $html->add_link_show=$add_link_show; 
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

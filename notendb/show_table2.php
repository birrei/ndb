<?php
include('head.php');

$object=$_GET['table']; // obligatorisch, Name Tabelle oder View (falls View, Benennung: "v_[tabelle]")
$edit_table=$object; // default 


/******************************* */
/** Festlegungen für Bearbeiten-Link */

$add_link_edit=true; // Bearbeiten-Link anzeigen, falls ja: 
$edit_table_title=''; // Titel der Seite, die über den Bearbeiten-Link aufgerufen wird 
$edit_link_show_newpage=false; // true: Das öffnen des Bearbeiten-Links soll in einem neuen Fenster erfolge
$add_link_show=false;  // true, falls eine zusätzliche Spalte "Anzeigen" ergänzt werden soll

/* Ausnahme Tabellen-Views */
if (substr($object,0,2)=='v_') {
  $edit_table=substr($object,2, strlen($object)-2);     // bei Views (suffix v_): "v_" vorne abschneiden
}

/*  Ausnahme Info-Views  */
if (substr($object,0,3)=='v2_') {
  $add_link_edit=false; 
}

/* Ausnahme Test-Views  */
if (substr($object,0,3)=='v3_') {
  $add_link_edit=false; 
}


if (isset($_GET['title'])) {
  $edit_table_title=$_GET['title']; 
}

if (isset($_GET['edit_link_show_newpage'])) {
  $edit_link_show_newpage=true; 
}

/******************************* */
/** Festlegungen für Anzeige "Neu einfügen" - Link (Seitenkopf) */

$show_insert_link=true; // default 

if (in_array($edit_table, array('musikstueck','satz', 'lookup'))) {
  $show_insert_link=false;
}

/*  Info-Views  */
if (substr($object,0,3)=='v2_') {
  $show_insert_link=false;
}

/*  Test-Views  */
if (substr($object,0,3)=='v3_') {
  $show_insert_link=false;  
}

/********************************/
/** Anzeige Link "Anzeigen" in zusäztlicher Spalte der Ergebnistabelle */
$add_link_show=false; 
if (isset($_GET['add_link_show'])) {
  $add_link_show=true; 
}

/******************************* */
/** Soll Filter-Möglichkeit angezeigt werden?  */

$show_filter=false; // falls ein Filter-Box angezeigt werden soll

if (isset($_GET['show_filter'])) {
  $show_filter=true; 
}

/********************************/

$query = 'SELECT * FROM '.$object.' WHERE 1=1 ';

// echo '<h3>'.$edit_table_title.'</h3>'.PHP_EOL; 



/*********** Filter-Anzeige, Query Filter  ********************/

if($show_filter) {

  echo '<form action="" method="post">'.PHP_EOL; 
  switch ($object) {
    case 'v_abfrage': 
      include_once("cl_abfragetyp.php");
      $AbfragetypID=(isset($_POST["AbfragetypID"])?$_POST["AbfragetypID"]:'');
      $abfragetyp = new Abfragetyp(); 
      echo 'Abfragetyp: '.PHP_EOL; 
      $abfragetyp->print_preselect($AbfragetypID); 
      $query.=($AbfragetypID!=''?'AND AbfragetypID='.$AbfragetypID.' '.PHP_EOL:''); 
    break; 

    case 'v_lookup': 
      include_once("cl_lookuptype.php");
      $LookupTypeID=(isset($_POST["LookupTypeID"])?$_POST["LookupTypeID"]:'');
      $lookuptype = new Lookuptype(); 
      echo 'Besonderheit Typ: '.PHP_EOL; 
      $lookuptype->print_preselect($LookupTypeID); 
      $query.=($LookupTypeID!=''?'AND LookupTypeID='.$LookupTypeID.' '.PHP_EOL:''); 
    break; 

    case 'v_sammlung': 
      include_once("cl_standort.php");
      $StandortID=(isset($_POST["StandortID"])?$_POST["StandortID"]:'');
      $Erfasst=(isset($_POST["Erfasst"])?1:0); 
      $standort = new Standort(); 
      echo 'Standort: '.PHP_EOL; 
      $standort->print_preselect($StandortID); 
      echo '<label><input type="checkbox" name="Erfasst" onchange="this.form.submit()" '.($Erfasst==1?'checked':'').'>Vollständig erfasst</label>'; 
      $query.=($StandortID!=''?'AND StandortID='.$StandortID.' '.PHP_EOL:''); 
      $query.='AND Erfasst='.$Erfasst; 
      
      
    break;     

  }
  echo '</form>'.PHP_EOL; 
  echo '<p></p>'; 
}

/******** Query Sortierung ***********************/
$sortcol=(isset($_GET['sortcol'])?$_GET['sortcol']:'ID'); 
$sortorder=(isset($_GET['sortorder'])?$_GET['sortorder']:'ASC'); 

$query.= ' ORDER BY '.$sortcol.' '.$sortorder.PHP_EOL; 

// echo '<pre>'.$query.'</pre>'; // Test 




/******************************* */

include_once("dbconn/cl_db.php");
$conn = new DbConn(); 
$db=$conn->db; 

$select = $db->prepare($query); 
  
try {
  $select->execute(); 
  include_once("cl_html_table.php");      
  $html = new HtmlTable($select); 
  $html->add_link_show=$add_link_show; 
  
  // Link für Neu-Erfassung anzeigen? 
  if ($show_insert_link) {
    echo '<p><a href="edit_'.$edit_table.'.php?title='.$edit_table_title.'&option=insert" target="_blank">Neu erfassen</a></p>';
  }

  $html->add_link_edit= $add_link_edit; 
  $html->edit_link_table=$edit_table; 
  $html->edit_link_open_newpage = $edit_link_show_newpage; 
  $html->edit_link_title= $edit_table_title; 
  $html->print_table2(); 
}
catch (PDOException $e) {
  include_once("cl_html_info.php"); 
  $info = new HtmlInfo();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}



// if (isset($_GET['edit_table'])) {
//   $edit_table=$_GET['edit_table']; // XXX gibt es diese Konstellation überhaupt? 
// } else {
//   $edit_table=$object; 
//   if (substr($object,0,2)=='v_') {
//     $edit_table=substr($object,2, strlen($object)-2);     // bei Views (suffix v_): "v_" vorne abschneiden
//   }
// }



include('foot.php');
?>

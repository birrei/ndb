<?php

  $table=$_GET['table']; // Tabelle oder View 

/* Tabellen-Name für Bearbeiten-Links */

  $table_orgnames = array("v_besonderheiten" => "lookup", 
                          "v_besonderheittypen" => "lookup_type");

  $table_edit=array_key_exists($table, $table_orgnames)?$table_orgnames[$table]:$table; 

  $table_edit=(substr($table_edit,0,2)=='v_')?substr($table_edit,2, strlen($table)-2):$table_edit; // falls $table mit "v_" beginnt, dann diesen Suffix abschneiden 
  
  // echo '<p>table_edit: '.$table_edit.'</p>'; // test 
 

/* Überschriften (Anzeige Tabellen-Name oder Tabellen-Alias- Name) */

  $table_aliases = array("v_besonderheiten" => "Besonderheiten"
                       , "v_besonderheittypen" => "Besonderheit-Typen");
  
  $header=array_key_exists($table, $table_aliases)?$table_aliases[$table]:ucfirst($table_edit); 

  // echo '<p>header: '.$header.'</p>';  

  $PageTitle=$header; // übergabe Seiten-Titel an head.php: 

  include_once('head.php');



  /******************************* */
  /***** Einstellungen für Bearbeiten-Link */

  $add_link_edit=true; // Bearbeiten-Link in Ergebnistabelle anzeigen
  $table_edit_title=''; // Titel der Seite, die über den Bearbeiten-Link aufgerufen wird 
  $edit_link_show_newpage=false; // true: Das öffnen des Bearbeiten-Links soll in einem neuen Fenster erfolge


  /*  Info-Views  */
  if (substr($table,0,3)=='v2_') {
    $add_link_edit=false; 
  }

  /* Test-Views  */
  if (substr($table,0,3)=='v3_') {
    $add_link_edit=false; 
  }
  if (isset($_GET['title'])) {
    $table_edit_title=$_GET['title']; 
  }

  if (isset($_GET['edit_link_show_newpage'])) {
    $edit_link_show_newpage=true; 
  }

  /******* Einstellungen für "Neu einfügen" - Link ********/
  $show_insert_link=true; // default 

  /*  Info-Views  */
  if (substr($table,0,3)=='v2_') {
    $show_insert_link=false;
  }

  /*  Test-Views  */
  if (substr($table,0,3)=='v3_') {
    $show_insert_link=false;  
  }

  /********* Zusätzliche "Anzeigen" Spalte in Ergebnistabelle */
  $add_link_show=false; 

  if (isset($_GET['add_link_show'])) {
    $add_link_show=true; 
  }

  /* Sortierung */
  $sortcol=(isset($_GET['sortcol'])?$_GET['sortcol']:'ID'); 
  $sortorder=(isset($_GET['sortorder'])?$_GET['sortorder']:'ASC'); 

  /********************************/

  $query = 'SELECT * FROM '.$table.' WHERE 1=1 ';

  echo '<h3>'.$header.'</h3>'.PHP_EOL; 

  // Link für Neu-Erfassung anzeigen? 
  if ($show_insert_link) {
    echo '<a href="edit_'.$table_edit.'.php?option=insert">Neu erfassen</a><br><br>';
  }

  /*********** Filter  ********************/
    switch ($table) {

      case 'v_material': 
        echo '<form action="" method="get">'.PHP_EOL;       
        include_once("classes/class.materialtyp.php");
        $MaterialtypID=(isset($_REQUEST["MaterialtypID"])?$_REQUEST["MaterialtypID"]:'');
        $materialtyp = new Materialtyp(); 
        echo 'Materialtyp: '.PHP_EOL; 
        $materialtyp->print_preselect($MaterialtypID); 
        $query.=($MaterialtypID!=''?'AND MaterialtypID='.$MaterialtypID.' '.PHP_EOL:''); 
        echo '<input type="hidden" name="table" value="'.$table.'">
              <input type="hidden" name="sortcol" value="'.$sortcol.'">
              <input type="hidden" name="sortorder" value="'.$sortorder.'">
              </form><br>';           


      break; 

      case 'v_abfrage': 
        echo '<form action="" method="get">'.PHP_EOL; 
        include_once("classes/class.abfragetyp.php");
        $AbfragetypID=(isset($_REQUEST["AbfragetypID"])?$_REQUEST["AbfragetypID"]:'');
        $abfragetyp = new Abfragetyp(); 
        echo 'Abfragetyp: '.PHP_EOL; 
        $abfragetyp->print_preselect($AbfragetypID); 
        $query.=($AbfragetypID!=''?'AND AbfragetypID='.$AbfragetypID.' '.PHP_EOL:''); 
        echo '<input type="hidden" name="table" value="'.$table.'">
              <input type="hidden" name="sortcol" value="'.$sortcol.'">
              <input type="hidden" name="sortorder" value="'.$sortorder.'">
              </form><br>';           

      break; 

      case 'v_besonderheiten': // case 'v_lookup': 

        echo '<form action="" method="get">'.PHP_EOL; 
        include_once("classes/class.lookuptype.php");
        $LookupTypeID=(isset($_REQUEST["LookupTypeID"])?$_REQUEST["LookupTypeID"]:'');
        $lookuptype = new Lookuptype(); 
        echo 'Besonderheit Typ: '.PHP_EOL; 
        $lookuptype->print_preselect($LookupTypeID); 
        $query.=($LookupTypeID!=''?'AND LookupTypeID='.$LookupTypeID.' '.PHP_EOL:''); 
        echo '<input type="hidden" name="table" value="'.$table.'">
              <input type="hidden" name="sortcol" value="'.$sortcol.'">
              <input type="hidden" name="sortorder" value="'.$sortorder.'">
              </form><br>';           

      break; 

      case 'v_sammlung': 
        echo '<form action="" method="get">'.PHP_EOL; 
        include_once("classes/class.standort.php");
        $StandortID=(isset($_REQUEST["StandortID"])?$_REQUEST["StandortID"]:'');
        $Erfasst=(isset($_REQUEST["Erfasst"])?1:0); 
        $standort = new Standort(); 
        echo 'Standort: '.PHP_EOL; 
        $standort->print_preselect($StandortID); 
        // echo '<label><input type="checkbox" name="Erfasst" onchange="this.form.submit()" '.($Erfasst==1?'checked':'').'>Vollständig erfasst</label>'; 
        $query.=($StandortID!=''?'AND StandortID='.$StandortID.' '.PHP_EOL:''); 
        // $query.='AND Erfasst='.$Erfasst; 
        echo '<input type="hidden" name="table" value="'.$table.'">
              <input type="hidden" name="sortcol" value="'.$sortcol.'">
              <input type="hidden" name="sortorder" value="'.$sortorder.'">
              </form><br>';           

      break;     

    case 'v_schueler': 
      $Aktiv_JN='Ja'; 
      if(isset($_REQUEST["filter"])) {
        $Aktiv_JN=(isset($_REQUEST["Aktiv_JN"])?'Ja':'Nein'); 
      }
      echo '<form action="" method="get">'.PHP_EOL; 
      echo '<label><input type="checkbox" name="Aktiv_JN" onchange="this.form.submit()" '.($Aktiv_JN=='Ja'?'checked':'').'>Aktiv</label>'; 
      $query.=($Aktiv_JN!=""?"AND Aktiv_JN='".$Aktiv_JN."' ".PHP_EOL:""); 
      echo '<input type="hidden" name="table" value="'.$table.'">
            <input type="hidden" name="sortcol" value="'.$sortcol.'">
            <input type="hidden" name="sortorder" value="'.$sortorder.'">
            <input type="hidden" name="filter" value="aktive">            
            </form><br>';           

      break;     
    }


  /******** Query Sortierung ***********************/

  $query.= 'ORDER BY '.$sortcol.' '.$sortorder.PHP_EOL; 
 
  // echo '<pre>'.$query.'</pre>'; // Test 

  /******************************* */

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
    $html->edit_link_open_newpage = $edit_link_show_newpage; 
    $html->edit_link_title= $table_edit_title; 
    $html->print_table2(); 
  }
  catch (PDOException $e) {
    include_once("classes/class.htmlinfo.php"); 
    $info = new HTML_Info();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }


include_once('foot.php');
?>

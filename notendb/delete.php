
<?php 

$table=$_REQUEST["table"];
$source=(isset($_REQUEST["source"])?$_REQUEST["source"]:'table'); // z.B: "iframe", "table" 
$source=($source!=''?$source:'table'); 

/** Einstellungen für den "Tabelle"-Link (Aufruf show_table2.php) */
$tablelink_table=$table; // Tabellen-Name oder View-Name (letzterer muss mit Suffix "v_" angegeben werden)     
$tablelink_sortcol='Name'; // 

/** Einstellungen für Ausführung in iFrame */
$iframe_parent_key=''; // ID Parent-Screens - Name 
$iframe_parent_ID=''; // ID Parent-Screen - Wert  


// echo $table; 

/*************************** */

switch($table) {
  // case 'sammlung': 
  //   include_once('cl_sammlung.php');
  //   $objekt = new Sammlung(); 
  //   break;   
     
  // case 'musikstueck': 
  //   include_once('cl_musikstueck.php');
  //   $objekt = new Musikstueck(); 
  //   $show_link_table=false;     
  //   break; 

  // case 'satz': 
  //   include_once('cl_satz.php');
  //   $objekt = new Satz(); 
  //   $show_link_table=false;         
  //   break;      
  // ------------------------

  case 'standort': 
    include_once('cl_standort.php');
    $objekt = new Standort(); 
    break; 

  case 'verlag': 
    include_once('cl_verlag.php');
    $objekt = new Verlag(); 
    break; 

  case 'komponist': 
    include_once('cl_komponist.php');
    $objekt = new Komponist(); 
    $tablelink_table='v_komponist'; // view-Name 
    break; 

  case 'besetzung': 
    include_once('cl_besetzung.php');
    $objekt = new Besetzung(); 
    break; 
  
  case 'verwendungszweck': 
    include_once('cl_verwendungszweck.php');
    $objekt = new Verwendungszweck(); 
    break; 

  case 'gattung': 
    include_once('cl_gattung.php');
    $objekt = new Gattung(); 
    break; 

  case 'epoche': 
    include_once('cl_epoche.php');
    $objekt = new Epoche(); 
    break; 

  case 'erprobt': 
    include_once('cl_erprobt.php');
    $objekt = new Erprobt(); 
    break; 

  case 'lookup': 
    include_once('cl_lookup.php');
    $objekt = new Lookup(); 
    $tablelink_table='v_lookup'; // view-Name
    // $in_iframe=true;           
    $show_link_table=false;       
    break; 

  case 'instrument': 
    include_once('cl_instrument.php');
    $objekt = new Instrument(); 
    break; 


  case 'schwierigkeitsgrad': 
    include_once('cl_schwierigkeitsgrad.php');
    $objekt = new Schwierigkeitsgrad(); 
    break;     

  case 'lookup_type': 
    include_once('cl_lookuptype.php');
    $objekt = new Lookuptype();     
    break; 

  case 'linktype': 
    include_once('cl_linktype.php');
    $objekt = new Linktype();        
    break; 

  case 'link': 
    include_once('cl_link.php');
    $objekt = new Link();
    $show_link_table=true;      
    // $in_iframe=true;     
    break;  

  case 'satz_erprobt': 
    include_once('cl_satz_erprobt.php');
    $objekt = new SatzErprobt();
    $show_link_table=true;      
    // $in_iframe=true;     
    break;  

  case 'abfrage': 
    include_once('cl_abfrage.php');
    $objekt = new Abfrage();     
    $tablelink_table='v_abfrage'; // view-Name      
    break; 

  case 'abfragetyp': 
    include_once('cl_abfragetyp.php');
    $objekt = new Abfragetyp();     
    $tablelink_table='abfragetyp'; 
    break; 

  case 'schueler': // XXX 
    include_once('cl_schueler.php');
    $objekt = new Schueler();     
    $tablelink_table='v_schueler'; 
    break; 

  case 'materialtyp': 
    include_once('cl_materialtyp.php');
    $objekt = new Materialtyp();     
    $tablelink_table='materialtyp'; 
    break; 

  // case 'material': 
  //   include_once('cl_material.php');
  //   $objekt = new Material();     
  //   $tablelink_table='v_material'; 
  //   break;     
      
}



if ($source=='iframe') {
  include('head_raw.php');
} else {
  include('head.php');
}

include("cl_html_info.php");

// echo '$source: '.$source.'<br>'; // test 
// echo '$table: '.$table.'<br>';  // test 


/*************************** */
if (isset($objekt)) { 
    $objekt->ID = $_REQUEST["ID"];
    $objekt->load_row(); 
    echo '<p><b>'.$objekt->Title.' löschen</b></p>'; 
    $info=new HtmlInfo(); 
    if (isset($_POST["confirm"])) {
      if($objekt->delete()) { 
        echo '<p>Die Zeile mit der ID '.$objekt->ID.' wurde aus '.$objekt->Title.' gelöscht.</p>';    
        if($source!='iframe') {
          $info->print_link_table($tablelink_table, 'sortcol='.$tablelink_sortcol, $objekt->Titles,false);  
        }
      } else {
        echo '<p>Die Löschung wurde nicht durchgeführt.</p>'; 
        $info->source=$source; 
        $info->print_link_edit($objekt->table_name, $objekt->ID,$objekt->Title,'',false);
      }
    }
    else {
      echo '
      <form action="" method="post">
      <p>ID '.$objekt->ID.' wird gelöscht </b>
      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $objekt->ID . '">  
      <input type="hidden" name="table" value="' . $objekt->table_name . '">
      <input type="hidden" name="source" value="'.$source.'">                   
      </form>
      </p>  '; 
      $info->source=$source; 
      $info->print_link_edit($objekt->table_name,$objekt->ID,$objekt->Title,false);   
    }

}

if ($source=='iframe') {
  include('foot_raw.php');
} else {
  include('foot.php');
}


?>


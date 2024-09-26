
<?php 

$table=$_REQUEST["table"];

$tablelink_table=$table; 
$tablelink_sortcol='Name'; 
$show_table_link=true; 
$show_html_head=true; 

// echo $table; 

/*************************** */

switch($table) {
  case 'sammlung': 
    include_once('cl_sammlung.php');
    $objekt = new Sammlung(); 
    break;   
     
  case 'musikstueck': 
    include_once('cl_musikstueck.php');
    $objekt = new Musikstueck(); 
    $show_table_link=false;     
    break; 

  case 'satz': 
    include_once('cl_satz.php');
    $objekt = new Satz(); 
    $show_table_link=false;         
    break;      
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
    $show_html_head=false;          
    $show_table_link=false;       
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
    $show_table_link=false;      
    $show_html_head=false; 
    break;  

  case 'satz_erprobt': 
    include_once('cl_satz_erprobt.php');
    $objekt = new SatzErprobt();
    $show_table_link=false;      
    $show_html_head=false; 
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
      
}

if ($show_html_head) {
  include('head.php');
} else {
  include('head_raw.php');
}

include("cl_html_info.php");



/*************************** */
if (isset($objekt)) { 
    $objekt->ID = $_REQUEST["ID"];
    $objekt->load_row(); 
    if ($show_html_head) {
      echo '<h2>'.$objekt->Title.' löschen</h2>'; 
    }
    $info=new HtmlInfo(); 
    if (isset($_POST["confirm"])) {
      if($objekt->delete()) { 
        if($show_table_link) {
          $info->print_link_table($tablelink_table, 'sortcol='.$tablelink_sortcol, $objekt->Titles,false);  
        }
        echo '<p>Die Zeile mit der ID '.$objekt->ID.' wurde aus '.$objekt->Titles.' gelöscht.';     
      } else {
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
      </form>
      </p>  '; 
      $info->print_link_edit($objekt->table_name,$objekt->ID,$objekt->Title,false);   
    }

}

if ($show_html_head) {
  include('foot.php');
} else {
  include('foot_raw.php');
}


?>


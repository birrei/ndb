
<?php 

$table=$_REQUEST["table"];

$tablelink_table=$table; 
$tablelink_sortcol='Name'; 



$show_link_table=true; // sinnvoll, wenn delete.php als Einzelformular angezeigt wird. 

$in_iframe=false; // delete.php wird in iframe aufgerufen 

/* back to list-Link in iframes */
$iframe_parent_key=''; // Name der zur ID des Parent-Screens (z.B. SammlungiD)
$iframe_parent_ID=''; // Wert der ID des Parent-Screens 


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
    $show_link_table=false;     
    break; 

  case 'satz': 
    include_once('cl_satz.php');
    $objekt = new Satz(); 
    $show_link_table=false;         
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
    $in_iframe=true;           
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
    $in_iframe=true;     
    break;  

  case 'satz_erprobt': 
    include_once('cl_satz_erprobt.php');
    $objekt = new SatzErprobt();
    $show_link_table=true;      
    $in_iframe=true;     
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

if (!$in_iframe) {
  include('head.php');
} else {
  include('head_raw.php');
}

include("cl_html_info.php");



/*************************** */
if (isset($objekt)) { 
    $objekt->ID = $_REQUEST["ID"];
    $objekt->load_row(); 
    if (!$in_iframe) {
      echo '<h2>'.$objekt->Title.' löschen</h2>'; 
    }
    $info=new HtmlInfo(); 
    if (isset($_POST["confirm"])) {
      echo $objekt->ID; 

      if($objekt->delete()) { 
        echo '<p>Die Zeile mit der ID '.$objekt->ID.' wurde aus '.$objekt->Titles.' gelöscht.';    
        if($show_link_table) {
          $info->print_link_table($tablelink_table, 'sortcol='.$tablelink_sortcol, $objekt->Titles,false);  
        }
      } else {
        echo '<p>keine löscheung ... XXX </p>'; 
      }
      $info->print_link_edit($objekt->table_name, $objekt->ID,$objekt->Title,'',false);

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

if (!$in_iframe) {
  include('foot.php');
} else {
  include('foot_raw.php');
}


?>


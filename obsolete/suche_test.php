
<?php 
include('head.php');
include("cl_db.php");

include("cl_html_table.php");    
include("cl_html_info.php");  


include("cl_standort.php"); 
include("cl_lookup.php");   
include("cl_lookuptype.php");


/* Arrays zur Aufnahme der jeweilig ausgewählten Elemente pro Multi-Select- Auswahlfeld*/

$Standorte=[];   /* Sammlung */


/* Tabelle, die über Bearbeiten-Link in Ergebnis-Tabelle abrufbar sein soll */

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Sammlung'; // default 
}

/********* XXX TEST  *******************/

/* 
Verwendung für Multis-Select-Felder: 
Zweidimensionales Array, dieses enthält: 
  Array Ebene 1: alle (markierten!) Auswahl-Boxen (1 pro Lookup Type), in denen mind 1 Eintrag markiert wurde   
  Array Ebene 2: die jeweils markierten Werte (Liste der IDs ) 
*/

echo '<pre>';
// $lookuptypes_selected=$_POST; 
// echo '<p>print_r($lookuptypes_selected):<br>';
// print_r($lookuptypes_selected); 
// echo '<p>print_r($lookuptypes_selected["besmelod"]): <br>';
// print_r($lookuptypes_selected["besmelod"]); 
// if (isset($_POST["besmelod"])) {
//   print_r($_POST["besmelod"]); 

// }

// for ($i = 0; $i < count($lookuptypes_selected); $i++) {
//   $lookup_key = array_keys($lookuptypes_selected)[$i];
//   echo '<br>lookup_key: '.$lookup_key ;   
//   // $field_name=$lookuptypes_selected[$i]["id"]; 
//   // echo '<br>lookup Name: '.$field_name ;   // entspricht in Tabelle "lookup_type" dem Feld "lookup_key" (nicht "Name")
//   // echo  'Anzahl ausgewählte Einträge: '.count($arLookups[$i]);  
//   echo  '<br>Anzahl ausgewählte Einträge: '.count($lookuptypes_selected[$lookup_key]); 
//  // print_r($lookuptypes_selected[$lookup_key]);  
//   $ID_List = implode(',', $lookuptypes_selected[$lookup_key]); // Umwandlung in Text 
//   echo '- ID_List: '.$ID_List; 
//   echo '<br/>';     
//}  



echo '</pre>';


/*************************************************** */

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  if (isset($_REQUEST['Standorte'])) {
    $Standorte = $_REQUEST['Standorte'];  
  }

}
?> 


<form id="Suche" action="" method="post">



<b>Standort(e):</b> <br>   
        <?php 
            $standort = new Standort();
            $standort->print_select_multi($Standorte);         
          echo ''; 
        ?>

<p></p>
<script type="text/javascript">  
          function Reset_All() {  
          for(i=0; i<document.forms[0].elements.length; i++){
            if(document.forms[0].elements[i].type == 'text'){
              document.forms[0].elements[i].value=""; 
            }
            if(document.forms[0].elements[i].type == 'select-multiple'){
              document.forms[0].elements[i].selectedIndex = -1;
            }   
          }
      }  
</script> 
<input type="submit" value="Suchen" class="btnSave">
</form>
<?php


  $filter=false; 

  $filterStandorte='';   
  


  if (isset($_POST['Standorte'])) {
      $Standorte = $_REQUEST['Standorte'];   
      $filterStandorte = 'IN ('.implode(',', $Standorte).')'; 
      $filter=true; 
  }
   
include('foot.php');

?>

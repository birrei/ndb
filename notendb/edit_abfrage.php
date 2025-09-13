
<?php 
$PageTitle='Abfrage'; 
include_once('head.php');
include_once("classes/class.abfrage.php");
include_once("classes/class.abfragetyp.php");
include_once("classes/class.htmlinfo.php");

$abfrage = new Abfrage();
$info= new HTML_Info(); 

$show_data=true; 
$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';

switch($option) {
  case 'edit': 
    $abfrage->ID=$_GET["ID"];
    $show_data = $abfrage->load_row(); 
    break; 

  case 'insert': 
    $abfrage->insert_row('');
    break; 
  
  case 'update': 
    $abfrage->ID = $_POST["ID"];    
    $abfrage->update_row(
          $_POST["Name"]
        , $_POST["Beschreibung"]   
        , $_POST["AbfragetypID"]   
        )
        ;    
    break;
     
  case 'delete_1': 
    $abfrage->ID = $_POST["ID"];  
    $abfrage->load_row(); 
    $Name=$abfrage->Name; 
    if($abfrage->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$abfrage->ID,'delete_2','Löschung');  
    }     
    break; 

  case 'delete_2': 
    $abfrage->ID=$_REQUEST["ID"]; 
    $abfrage->delete(); 
    $show_data=false; 
    break; 

    
  default: 
    $show_data=false;     

}

if (!$show_data) {goto pagefoot;}

$info->print_screen_header($abfrage->Title.' bearbeiten'); 

echo '<a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage&Name='.$abfrage->Name.'" class="form-link">Ergebnis anzeigen</a>'; 
$info->print_link_edit2($abfrage->table_name, $abfrage->ID,'Abfrage-Text',false);  
$info->print_link_table('v_abfrage', 'sortcol=Name&add_link_show&show_filter', $abfrage->Titles,false);
echo '</p>
<form action="edit_abfrage.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$abfrage->ID.'</td>
  </label>
    </tr> 


  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Abfragetyp:</td>  
  <td class="form-edit form-edit-col2">     
        '; 
        $abfragtypen = new Abfragetyp();
        $abfragtypen->print_select($abfrage->AbfragetypID); 

  echo ' </label>  &nbsp;
      '; 

  $info->print_link_edit($abfragtypen->table_name, $abfrage->AbfragetypID,$abfragtypen->Title, true); 
  $info->print_link_table($abfragtypen->table_name,'sortcol=Name',$abfragtypen->Titles,true,'');    
  $info->print_link_insert($abfragtypen->table_name,$abfragtypen->Title,true); 

echo '
  </tr>

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($abfrage->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Beschreibung:</td>  
    <td class="form-edit form-edit-col2">
    <textarea name="Beschreibung" rows=5 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Beschreibung).'</textarea> (max. 250 Zeichen)  
    </td>
    </label>
  </tr> 
  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 


<input type="hidden" name="option" value="update"> 
<input type="hidden" name="title" value="Abfrage">          
<input type="hidden" name="ID" value="' . $abfrage->ID. '">

</form>

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2">
    <br>'; 
    $info->print_form_inline('delete_1',$abfrage->ID,$abfrage->Title, 'löschen'); 
    // $info->print_form_inline('copy',$abfrage->ID,$abfrage->Title, 'kopieren'); 
    echo '
    </td>
  </tr>
  
</table> 
'; 



pagefoot: 

include_once('foot.php');

?>

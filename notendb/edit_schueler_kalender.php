
<?php 
$PageTitle='Schüler Übungstag'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

$schuelerdatum = new SchuelerKalendertag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $schuelerdatum->ID=$_GET["ID"];
    $schuelerdatum->load_row(); 
    break; 


  // case 'insert': // XXXX   
  //   $schuelerdatum->insert_row('');
  //   $show_data=true; 
  //   break; 
  
  case 'update': 
    $schuelerdatum->ID = $_POST["ID"];    
    $schuelerdatum->update_row($_POST["Bemerkung"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $schuelerdatum->ID = $_REQUEST["ID"];  
    $schuelerdatum->load_row(); 
    if($schuelerdatum->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $schuelerdatum->Title, $schuelerdatum->ID, $schuelerdatum->Datum_DE);   
    }     
    $show_data=true;      
    break; 

  case 'delete_2': 
    $schuelerdatum->ID=$_REQUEST["ID"]; 
    $schuelerdatum->delete(); 
    $show_data=false; 
    break; 
     
  default: 
    $show_data=false;   
}

$info->print_screen_header($schuelerdatum->Title.' bearbeiten'); 
// $info->print_link_table($schuelerdatum->table_name, 'sortcol=Name', $schuelerdatum->Titles); 


if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_schueler_kalender.php" method="post">
<table class="form-edit"> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2"><b>'.$schuelerdatum->SchuelerName.'</b></td>
  </label>
    </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Datum:</td>  
  <td class="form-edit form-edit-col2"><b>'.$schuelerdatum->Datum_DE.'</b> </td>
  </label>
    </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="'.$schuelerdatum->Bemerkung.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

    <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schuljahr:</td>  
  <td class="form-edit form-edit-col2">'.$schuelerdatum->Schuljahr.' '.$schuelerdatum->Ferien.' '.$schuelerdatum->Feiertag.'</td>
  </label>
    </tr> 



  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="' . $schuelerdatum->ID. '">

</form>

<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$schuelerdatum->ID,$schuelerdatum->Title, 'löschen'); 
  echo '     
  </td>
</tr> 


</table> 

'; 

pagefoot: 
include_once('foot.php');

?>

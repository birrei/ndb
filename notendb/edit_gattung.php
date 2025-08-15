
<?php 
$PageTitle='Gattung'; 
include_once('head.php');
include_once("classes/class.gattung.php");
include_once("classes/class.htmlinfo.php");


$gattung = new Gattung();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $gattung->ID=$_GET["ID"];
    $show_data = $gattung->load_row();     
    break; 

  case 'insert': 
    $gattung->insert_row('');
    break; 
  
  case 'update': 
    $gattung->ID = $_POST["ID"];    
    $gattung->update_row($_POST["Name"]);           
    break; 

  case 'delete_1': 
    $gattung->ID = $_REQUEST["ID"];  
    $gattung->load_row(); 
    if($gattung->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$gattung->ID,'delete_2','Löschung');  
    }           
    break; 

  case 'delete_2': 
    $gattung->ID=$_REQUEST["ID"]; 
    $gattung->delete(); 
    $show_data=false; 
    break; 

  default: 
    $show_data=false;     
}

$info->print_screen_header($gattung->Title.' bearbeiten'); 
$info->print_link_table($gattung->table_name, 'sortcol=Name', $gattung->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_gattung.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$gattung->ID.'</td>
  </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$gattung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
    </td>
  </tr> 

<input type="hidden" name="option" value="update">       
<input type="hidden" name="ID" value="' . $gattung->ID. '">

</form>
  
<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$gattung->ID,$gattung->Title, 'löschen'); 
  echo '     
  </td>
</tr> 

</table> 


'; 

pagefoot: 
include_once('foot.php');

?>


<?php 
$PageTitle='Verlag'; 
include_once('head.php');
include_once("classes/class.verlag.php");
include_once("classes/class.htmlinfo.php");

$verlag = new Verlag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'edit': // geöffnet über einen "Bearbeiten"-Link
    $verlag->ID=$_GET["ID"];
    $show_data = $verlag->load_row();     
    break; 

  case 'insert': 
    $verlag->insert_row(''); 
    break; 
  
  case 'update': 
    $verlag->ID = $_POST["ID"];    
    $verlag->update_row($_POST["Name"], $_POST["Bemerkung"]);       
    break; 

  case 'delete_1': 
    $verlag->ID = $_REQUEST["ID"];  
    $verlag->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$verlag->ID,'delete_2','Löschung');    
    break; 

  case 'delete_2': 
    $verlag->ID=$_REQUEST["ID"]; 
    if($verlag->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
  break; 

  default: 
    $show_data=false;     

}

$info->print_screen_header($verlag->Title.' bearbeiten'); 
$info->print_link_table($verlag->table_name, 'sortcol=Name', $verlag->Titles); 

if (!$show_data) {goto pagefoot;}

echo '<p> 
<form action="edit_verlag.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$verlag->ID.'</td>
  </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$verlag->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="'.$verlag->Bemerkung.'" size="45" maxlength="80"  oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="' . $verlag->ID. '">

</form>


<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$verlag->ID,$verlag->Title, 'löschen'); 
  echo '     
  </td>
</tr> 

</table> 


'; 

pagefoot: 
include_once('foot.php');

?>

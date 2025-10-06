
<?php 
$PageTitle='Besetzung'; 
include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.besetzung.php");


$besetzung = new Besetzung();;
$info= new HTML_Info(); 
$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $besetzung->ID=$_GET["ID"];
    $besetzung->load_row(); 
    break; 

  case 'insert': 
    $besetzung->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $besetzung->ID = $_POST["ID"];    
    $besetzung->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $besetzung->ID = $_REQUEST["ID"];  
    $besetzung->load_row(); 
    if($besetzung->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $besetzung->Title, $besetzung->ID, $besetzung->Name);   
    }    
    break; 

  case 'delete_2': 
    $besetzung->ID=$_REQUEST["ID"]; 
    $besetzung->delete(); 
    $show_data=false; 
    break; 

  case 'copy': 
    $besetzung->ID=$_REQUEST["ID"]; 
    $besetzung->copy();   
    $besetzung->load_row();       
   // $info->print_info_copy($besetzung->Title, $ID_ref, $besetzung->ID, 'edit_uebung'); 
    $option='update'; 
    $show_data=true; 
  break;         
    
  default: 
    $show_data=false; 
}

$info->print_screen_header($besetzung->Title.' bearbeiten'); 
$info->print_link_table($besetzung->table_name, 'sortcol=Name', $besetzung->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_besetzung.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$besetzung->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$besetzung->Name.'" size="120" required="required" autofocus oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
    </td>
  </tr> 

<input type="hidden" name="option" value="update">  
<input type="hidden" name="title" value="Besetzung">        
<input type="hidden" name="ID" value="' . $besetzung->ID. '">

</form>

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$besetzung->ID,$besetzung->Title, 'löschen'); 
    $info->print_form_inline('copy',$besetzung->ID,$besetzung->Title, 'kopieren'); 


  echo '     
    </td>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2">


    </td>
  </tr> 


</table> 


'; 


pagefoot: 

include_once('foot.php');

?>


<?php 
$PageTitle='Erprobt'; 
include_once('head.php');
include_once("classes/class.erprobt.php");
include_once("classes/class.htmlinfo.php");

$erprobt=new Erprobt(); 
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $erprobt->ID=$_GET["ID"];
    $erprobt->load_row(); 
    break; 

  case 'insert': 
    $erprobt->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $erprobt->ID = $_POST["ID"];    
    $erprobt->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $erprobt->ID = $_REQUEST["ID"];  
    $erprobt->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$erprobt->ID,'delete_2','Löschung');  
    $show_data=true;      
    break; 

  case 'delete_2': 
    $erprobt->ID=$_REQUEST["ID"]; 
    if($erprobt->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 
    
  default: 
    $show_data=false;    
}

$info->print_screen_header($erprobt->Title.' bearbeiten'); 
$info->print_link_table($erprobt->table_name, 'sortcol=Name', $erprobt->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_erprobt.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$erprobt->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$erprobt->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


  <input type="hidden" name="option" value="update">  
  <input type="hidden" name="title" value="Erprobt">        
  <input type="hidden" name="ID" value="' . $erprobt->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$erprobt->ID,$erprobt->Title, 'löschen'); 

  echo '     
    </td>
  </tr> 

</table> 


'; 



pagefoot: 
include_once('foot.php');

?>

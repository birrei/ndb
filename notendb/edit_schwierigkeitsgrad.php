
<?php 
$PageTitle='Schwierigkeitsgrad'; 
include_once('head.php');
include_once("classes/class.schwierigkeitsgrad.php");
include_once("classes/class.htmlinfo.php");

$schwierigkeitsgrad=new Schwierigkeitsgrad(); 
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $schwierigkeitsgrad->ID=$_GET["ID"];
    $show_data = $schwierigkeitsgrad->load_row();     
    break; 

  case 'insert': 
    $schwierigkeitsgrad->insert_row('');
    break; 
  
  case 'update': 
    $schwierigkeitsgrad->ID = $_POST["ID"];    
    $schwierigkeitsgrad->update_row($_POST["Name"]);         
    break; 

  case 'delete_1': 
    $schwierigkeitsgrad->ID = $_REQUEST["ID"];  
    $schwierigkeitsgrad->load_row(); 
    if($schwierigkeitsgrad->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$schwierigkeitsgrad->ID,'delete_2','Löschung');        
    }          
    break; 

  case 'delete_2': 
    $schwierigkeitsgrad->ID=$_REQUEST["ID"]; 
    $schwierigkeitsgrad->delete(); 
    $show_data=false;   
    break; 

  default: 
    $show_data=false;  

}

$info->print_screen_header($schwierigkeitsgrad->Title.' bearbeiten'); 
$info->print_link_table($schwierigkeitsgrad->table_name, 'sortcol=Name', $schwierigkeitsgrad->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_schwierigkeitsgrad.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$schwierigkeitsgrad->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schwierigkeitsgrad->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $schwierigkeitsgrad->ID. '">
  <input type="hidden" name="title" value="Schwierigkeitsgrad"> 

  </form>

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$schwierigkeitsgrad->ID,$schwierigkeitsgrad->Title, 'löschen'); 
    echo '     
    </td>
  </tr> 

</table> 

  '; 


  pagefoot: 

include_once('foot.php');

?>


<?php 
$PageTitle='Standort'; 
include_once('head.php');
include_once("classes/class.standort.php");
include_once("classes/class.htmlinfo.php");


$standort = new Standort();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $standort->ID=$_GET["ID"];
    $show_data = $standort->load_row();     
    break; 

  case 'insert': 
    $standort->insert_row(''); 
    break; 
  
  case 'update': 
    $standort->ID = $_POST["ID"];    
    $standort->update_row($_POST["Name"]);           
    break; 

  case 'delete_1': 
    $standort->ID = $_REQUEST["ID"];  
    $standort->load_row(); 
    if($standort->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $standort->Title, $standort->ID, $standort->Name);   
    }     
   
    break; 

  case 'delete_2': 
    $standort->ID=$_REQUEST["ID"]; 
    $standort->delete(); 
    $show_data=false;   
    break; 

  default: 
    $show_data=false;       
  
}

$info->print_screen_header($standort->Title.' bearbeiten'); 
$info->print_link_table($standort->table_name, 'sortcol=Name', $standort->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_standort.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$standort->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$standort->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $standort->ID. '">

  </form>
  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$standort->ID,$standort->Title, 'löschen'); 
    echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>

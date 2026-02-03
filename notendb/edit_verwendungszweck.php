
<?php 
$PageTitle='Verwendungszweck'; 
include_once('head.php');
include_once("classes/class.verwendungszweck.php");
include_once("classes/class.htmlinfo.php");

$verwendungszweck = new Verwendungszweck();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $verwendungszweck->ID=$_GET["ID"];
    $show_data = $verwendungszweck->load_row();     
    break; 

  case 'insert': 
    $verwendungszweck->insert_row('');
    break; 
  
  case 'update': 
    $verwendungszweck->ID = $_POST["ID"];    
    $verwendungszweck->update_row($_POST["Name"]);           
    break; 

  case 'delete_1': 
    $verwendungszweck->ID = $_REQUEST["ID"];  
    if($verwendungszweck->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $verwendungszweck->Title, $verwendungszweck->ID, $verwendungszweck->Name);   
    }  
    break; 

  case 'delete_2': 
    $verwendungszweck->ID=$_REQUEST["ID"]; 
    $verwendungszweck->delete(); 
    $show_data=false; 

  break; 

  default: 
    $show_data=false;    
    
}

$info->print_screen_header($verwendungszweck->Title.' bearbeiten'); 
$info->print_link_table2('verwendungszwecke'); 


if (!$show_data) {goto pagefoot;}
    
echo '
<form action="edit_verwendungszweck.php" method="post">
<table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$verwendungszweck->ID.'</td>
    </label>
    </tr> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$verwendungszweck->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
      </td>
    </tr> 

    <input type="hidden" name="option" value="update">        
    <input type="hidden" name="ID" value="'. $verwendungszweck->ID. '">

    </form>

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><br>
      '; 
      $info->print_form_inline('delete_1',$verwendungszweck->ID,$verwendungszweck->Title, 'löschen'); 
      echo '     
      </td>
    </tr> 
 </table>   
 '; 


pagefoot: 
include_once('foot.php');

?>

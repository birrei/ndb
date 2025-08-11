
<?php 
$PageTitle='Instrument'; 
include_once('head.php');
include_once("classes/class.instrument.php");
include_once("classes/class.htmlinfo.php");

$instrument = new Instrument();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $instrument->ID=$_GET["ID"];
    $instrument->load_row(); 
    break; 

  case 'insert': 
    $instrument->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $instrument->ID = $_POST["ID"];    
    $instrument->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $instrument->ID = $_REQUEST["ID"];  
    $instrument->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$instrument->ID,'delete_2','Löschung');  
    $show_data=true;      
    break; 

  case 'delete_2': 
    $instrument->ID=$_REQUEST["ID"]; 
    if($instrument->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 
     
  default: 
    $show_data=false;   
}



// if (isset($_REQUEST["option"])) {
//   switch($_REQUEST["option"]) {
//     case 'edit': // über "Bearbeiten"-Link
//       $instrument->ID=$_GET["ID"];
//       if ($instrument->load_row()) {
//         $show_data=true;       
//       }
//       break; 

//     case 'insert': 
//       $instrument->insert_row('');
//       $show_data=true; 
//       break; 
    
//     case 'update': 
//       $instrument->ID = $_POST["ID"];    
//       $instrument->update_row($_POST["Name"]); 
//       $show_data=true;           
//       break; 
//   }
// }

$info->print_screen_header($instrument->Title.' bearbeiten'); 
$info->print_link_table($instrument->table_name, 'sortcol=Name', $instrument->Titles); 


if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_instrument.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$instrument->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlspecialchars($instrument->Name).'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="' . $instrument->ID. '">

</form>

<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$instrument->ID,$instrument->Title, 'löschen'); 
  echo '     
  </td>
</tr> 


</table> 

'; 

pagefoot: 
include_once('foot.php');

?>

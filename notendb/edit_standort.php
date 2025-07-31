
<?php 
include_once('head.php');
include_once("classes/class.standort.php");
include_once("classes/class.htmlinfo.php");


$standort = new Standort();
$info= new HTML_Info(); 



$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $standort->ID=$_GET["ID"];
      if ($standort->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $standort->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $standort->ID = $_POST["ID"];    
      $standort->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($standort->Title.' bearbeiten'); 
$info->print_link_table($standort->table_name, 'sortcol=Name', $standort->Titles); 


if ($show_data) {

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

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $standort->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($standort->table_name, $standort->ID,$standort->Title); 
  
} 
else {
    $info->print_user_error(); 
}
include_once('foot.php');

?>

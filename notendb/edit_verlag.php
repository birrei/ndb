
<?php 
include_once('head.php');
include_once("classes/class.verlag.php");
include_once("classes/class.htmlinfo.php");

$verlag = new Verlag();
$info= new HTML_Info(); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // geöffnet über einen "Bearbeiten"-Link
      $verlag->ID=$_GET["ID"]; 
      if ($verlag->load_row()) {
        $show_data=true;       
      }      
      break; 

    case 'insert': 
      $verlag->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $verlag->ID = $_POST["ID"];    
      $verlag->update_row($_POST["Name"], $_POST["Bemerkung"]); 
      $show_data=true;          
      break; 
  }

}

$info->print_screen_header($verlag->Title.' bearbeiten'); 
$info->print_link_table($verlag->table_name, 'sortcol=Name', $verlag->Titles); 

if ($show_data) {

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

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $verlag->ID. '">

  </form>
  </p> 

  '; 

  $info->print_link_delete_row2($verlag->table_name, $verlag->ID, $verlag->Title, false); 
}
else {
  $info->print_user_error(); 
}

include_once('foot.php');

?>

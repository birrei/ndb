
<?php 
include_once('head.php');
include_once("classes/class.erprobt.php");
include_once("classes/class.htmlinfo.php");

$erprobt=new Erprobt(); 
$info= new HTML_Info(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $erprobt->ID=$_GET["ID"];
      if ($erprobt->load_row()) {
        $show_data=true;       
      }
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
  }
}

$info->print_screen_header($erprobt->Title.' bearbeiten'); 
$info->print_link_table($erprobt->table_name, 'sortcol=Name', $erprobt->Titles); 

if ($show_data) {
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

  </table> 
  <input type="hidden" name="option" value="update">  
  <input type="hidden" name="title" value="Erprobt">        
  <input type="hidden" name="ID" value="' . $erprobt->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($erprobt->table_name, $erprobt->ID, $erprobt->Title); 
} 
else {
    $info->print_user_error(); 
}


include_once('foot.php');

?>

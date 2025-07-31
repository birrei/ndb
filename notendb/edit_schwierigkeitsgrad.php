
<?php 
include_once('head.php');
include_once("classes/class.schwierigkeitsgrad.php");
include_once("classes/class.htmlinfo.php");

$schwierigkeitsgrad=new Schwierigkeitsgrad(); 
$info= new HTML_Info(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schwierigkeitsgrad->ID=$_GET["ID"];
      if ($schwierigkeitsgrad->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $schwierigkeitsgrad->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $schwierigkeitsgrad->ID = $_POST["ID"];    
      $schwierigkeitsgrad->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($schwierigkeitsgrad->Title.' bearbeiten'); 
$info->print_link_table($schwierigkeitsgrad->table_name, 'sortcol=Name', $schwierigkeitsgrad->Titles); 

if ($show_data) {
    
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

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $schwierigkeitsgrad->ID. '">
  <input type="hidden" name="title" value="Schwierigkeitsgrad"> 

  </form>
  '; 
  $info->print_link_delete_row2($schwierigkeitsgrad->table_name, $schwierigkeitsgrad->ID, $schwierigkeitsgrad->Title);     
} 
else {
    $info->print_user_error(); 
}

include_once('foot.php');

?>

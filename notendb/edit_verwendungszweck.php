
<?php 
$PageTitle='Verwendungszweck'; 
include_once('head.php');
include_once("classes/class.verwendungszweck.php");
include_once("classes/class.htmlinfo.php");


$verwendungszweck = new Verwendungszweck();
$info= new HTML_Info(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $verwendungszweck->ID=$_GET["ID"];
      if ($verwendungszweck->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $verwendungszweck->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $verwendungszweck->ID = $_POST["ID"];    
      $verwendungszweck->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($verwendungszweck->Title.' bearbeiten'); 
$info->print_link_table($verwendungszweck->table_name, 'sortcol=Name', $verwendungszweck->Titles); 

if ($show_data) {
    
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

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="'. $verwendungszweck->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($verwendungszweck->table_name, $verwendungszweck->ID, $verwendungszweck->Title); 

} 
else {
    $info->print_user_error(); 
}


include_once('foot.php');

?>

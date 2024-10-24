
<?php 
include('head.php');
include("cl_epoche.php");
include("cl_html_info.php");

$epoche = new Epoche();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $epoche->ID=$_GET["ID"];
      if ($epoche->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $epoche->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $epoche->ID = $_POST["ID"];    
      $epoche->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($epoche->Title.' bearbeiten'); 
$info->print_link_table($epoche->table_name, 'sortcol=Name', $epoche->Titles); 

if ($show_data) {
    
  echo '
  <form action="edit_epoche.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$epoche->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$epoche->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Epoche">          
  <input type="hidden" name="ID" value="' . $epoche->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($epoche->table_name, $epoche->ID, $epoche->Title); 
} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>

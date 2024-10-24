
<?php 
include('head.php');
include("cl_abfragetyp.php");
include("cl_html_info.php");

$abfragetyp = new Abfragetyp();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $abfragetyp->ID=$_GET["ID"];
      if ($abfragetyp->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $abfragetyp->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $abfragetyp->ID = $_POST["ID"];    
      $abfragetyp->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($abfragetyp->Title.' bearbeiten'); 
$info->print_link_table($abfragetyp->table_name, 'sortcol=Name', $abfragetyp->Titles); 

if ($show_data) {
    
  echo '
  <form action="edit_abfragetyp.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$abfragetyp->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$abfragetyp->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Abfragetyp">          
  <input type="hidden" name="ID" value="' . $abfragetyp->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($abfragetyp->table_name, $abfragetyp->ID, $abfragetyp->Title); 
} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>

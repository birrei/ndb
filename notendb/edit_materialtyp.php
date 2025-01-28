
<?php 
include('head.php');
include("cl_materialtyp.php");
include("cl_html_info.php");

$materialtyp = new Materialtyp();
$info= new HtmlInfo(); 



$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // geöffnet über einen "Bearbeiten"-Link
      $materialtyp->ID=$_GET["ID"]; 
      if ($materialtyp->load_row()) {
        $show_data=true;       
      }      
      break; 

    case 'insert': 
      $materialtyp->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $materialtyp->ID = $_POST["ID"];    
      $materialtyp->update_row($_POST["Name"]); 
      $show_data=true;          
      break; 
  }

}

$info->print_screen_header($materialtyp->Title.' bearbeiten'); 
$info->print_link_table($materialtyp->table_name, 'sortcol=Name', $materialtyp->Titles); 

if ($show_data) {

  echo '<p> 
  <form action="edit_materialtyp.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$materialtyp->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$materialtyp->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $materialtyp->ID. '">

  </form>
  </p> 

  '; 
  $info->source= 'table'; 
  $info->print_link_delete_row2($materialtyp->table_name, $materialtyp->ID, $materialtyp->Title); 
}
else {
  $info->print_user_error(); 
}

include('foot.php');

?>

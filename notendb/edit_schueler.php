
<?php 
include('head.php');
include("cl_schueler.php");
include("cl_html_info.php");

$schueler = new Schueler();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schueler->ID=$_GET["ID"];
      if ($schueler->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $schueler->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $schueler->ID = $_POST["ID"];    
      $schueler->update_row($_POST["Name"],$_POST["Bemerkung"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($schueler->Title.' bearbeiten'); 
$info->print_link_table($schueler->table_name, 'sortcol=Name', $schueler->Titles); 


if ($show_data) {
    
  echo '
  <form action="edit_schueler.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$schueler->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schueler->Name.'" size="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"required></td>
      </label>
    </tr> 


    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bemerkung:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="'.$schueler->Bemerkung.'" size="120" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 




    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
      </td>
    </tr> 
    </table> 

    <input type="hidden" name="option" value="update">     
    <input type="hidden" name="title" value="Schüler">    
    <input type="hidden" name="ID" value="' . $schueler->ID. '">

  </form>
  '; 

  // XXX $info->print_link_delete_row2($schueler->table_name, $schueler->ID,$schueler->Title); 
} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>

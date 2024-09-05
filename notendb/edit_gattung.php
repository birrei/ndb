
<?php 
include('head.php');
include("cl_gattung.php");
include("cl_html_info.php");


$gattung = new Gattung();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $gattung->ID=$_GET["ID"];
      if ($gattung->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $gattung->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $gattung->ID = $_POST["ID"];    
      $gattung->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($gattung->Title.' bearbeiten', ' | '); 
$info->print_link_table($gattung->table_name, 'sortcol=Name', $gattung->Titles); 

if ($show_data) {
  echo '
  <form action="edit_gattung.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$gattung->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$gattung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">
  <input type="hidden" name="title" value="Gattung">        
  <input type="hidden" name="ID" value="' . $gattung->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($gattung->table_name, $gattung->ID, $gattung->Title); 
} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>

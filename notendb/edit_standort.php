
<?php 
include('head.php');
include("cl_standort.php");
include("cl_html_info.php");


$standort = new Standort();
$info= new HtmlInfo(); 



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

$info->print_screen_header($standort->Title.' bearbeiten', ' | '); 
$info->print_link_table($standort->table_name, 'sortcol=Name', $standort->Titles); 


if ($show_data) {

  echo '
  <form action="edit_standort.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$standort->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$standort->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $standort->ID. '">

  </form>
  '; 

  $info->print_link_delete_row($standort->table_name, $standort->ID,$standort->Title); 
  
} 
else {
    $info->print_user_error(); 
}
include('foot.php');

?>

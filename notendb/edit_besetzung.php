
<?php 
include('head.php');
include("cl_besetzung.php");
include("cl_html_info.php");

echo '<h2>Besetzung bearbeiten</h2>'; 


$besetzung = new Besetzung();;
$info= new HtmlInfo(); 


$info->print_link_table('besetzung', 'sortcol=Name', 'Besetzungen'); 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $besetzung->ID=$_GET["ID"];
      if ($besetzung->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $besetzung->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $besetzung->ID = $_POST["ID"];    
      $besetzung->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

if ($show_data) {
  echo '
  <form action="edit_besetzung.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$besetzung->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$besetzung->Name.'" size="120" required="required" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">  
  <input type="hidden" name="title" value="Besetzung">        
  <input type="hidden" name="ID" value="' . $besetzung->ID. '">

  </form>
  '; 

  $info->print_link_delete_row($besetzung->table_name, $besetzung->ID,'Besetzung'); 

} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>

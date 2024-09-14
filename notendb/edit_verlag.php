
<?php 
include('head.php');
include("cl_verlag.php");
include("cl_html_info.php");

$verlag = new Verlag();
$info= new HtmlInfo(); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // geöffnet über einen "Bearbeiten"-Link
      $verlag->ID=$_GET["ID"]; 
      if ($verlag->load_row()) {
        $show_data=true;       
      }      
      break; 

    case 'insert': 
      $verlag->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $verlag->ID = $_POST["ID"];    
      $verlag->update_row($_POST["Name"], $_POST["Bemerkung"]); 
      $show_data=true;          
      break; 
  }

}

$info->print_screen_header($verlag->Title.' bearbeiten'); 
$info->print_link_table($verlag->table_name, 'sortcol=Name', $verlag->Titles); 

if ($show_data) {

  echo '<p> 
  <form action="edit_verlag.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$verlag->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$verlag->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr>    
      <label>
      <td class="eingabe">Bemerkung:</td>  
      <td class="eingabe"><input type="text" name="Bemerkung" value="'.$verlag->Bemerkung.'" size="45" maxlength="80"  oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $verlag->ID. '">

  </form>
  </p> 

  '; 

  $info->print_link_delete_row2($verlag->table_name, $verlag->ID, $verlag->Title, false); 
}
else {
  $info->print_user_error(); 
}

include('foot.php');

?>

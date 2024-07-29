
<?php 
include('head.php');
include("cl_instrument.php");
include("cl_html_info.php");

echo '<h2>Instrument bearbeiten</h2>'; 

$instrument = new Instrument();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $instrument->ID=$_GET["ID"];
      if ($instrument->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $instrument->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $instrument->ID = $_POST["ID"];    
      $instrument->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}


$info->print_link_table('instrument', 'sortcol=Name', 'Instrumente'); 

if ($show_data) {
  echo '
  <form action="edit_instrument.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$instrument->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$instrument->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $instrument->ID. '">

  </form>
  '; 
  $info->print_link_delete_row($instrument->table_name, $instrument->ID, $instrument->Title);   
} 
else {
  $info->print_user_error(); 
}


include('foot.php');

?>

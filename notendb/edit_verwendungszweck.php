
<?php 
include('head.php');
include("cl_verwendungszweck.php");
include("cl_html_info.php");


$verwendungszweck = new Verwendungszweck();
$info= new HtmlInfo(); 

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

$info->print_screen_header($verwendungszweck->Title.' bearbeiten', ' | '); 
$info->print_link_table($verwendungszweck->table_name, 'sortcol=Name', $verwendungszweck->Titles); 

if ($show_data) {
    
  echo '
  <form action="edit_verwendungszweck.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$verwendungszweck->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$verwendungszweck->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="'. $verwendungszweck->ID. '">

  </form>
  '; 

  $info->print_link_delete_row($verwendungszweck->table_name, $verwendungszweck->ID, $verwendungszweck->Title); 

} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>

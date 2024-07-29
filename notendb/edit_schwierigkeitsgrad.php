
<?php 
include('head.php');
include("cl_schwierigkeitsgrad.php");
include("cl_html_info.php");

echo '<h2>Schwierigkeitsgrad-Eintrag bearbeiten</h2>'; 

$schwierigkeitsgrad=new Schwierigkeitsgrad(); 
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schwierigkeitsgrad->ID=$_GET["ID"];
      if ($schwierigkeitsgrad->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $schwierigkeitsgrad->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $schwierigkeitsgrad->ID = $_POST["ID"];    
      $schwierigkeitsgrad->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}


$info->print_link_table('schwierigkeitsgrad', 'sortcol=Name', 'Schwierigkeitsgrade'); 

if ($show_data) {
    
  echo '
  <form action="edit_schwierigkeitsgrad.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$schwierigkeitsgrad->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$schwierigkeitsgrad->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $schwierigkeitsgrad->ID. '">
  <input type="hidden" name="title" value="Schwierigkeitsgrad"> 

  </form>
  '; 
} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>

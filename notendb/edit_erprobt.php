
<?php 
include('head.php');
include("cl_erprobt.php");
include("cl_html_info.php");

echo '<h2>Erprobt-Eintrag bearbeiten</h2>'; 

$erprobt=new Erprobt(); 
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $erprobt->ID=$_GET["ID"];
      if ($erprobt->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $erprobt->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $erprobt->ID = $_POST["ID"];    
      $erprobt->update_row($_POST["Name"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_link_table('erprobt', 'sortcol=Name', 'Erprobt-Einträge'); 

if ($show_data) {
  echo '
  <form action="edit_erprobt.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$erprobt->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$erprobt->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">  
  <input type="hidden" name="title" value="Erprobt">        
  <input type="hidden" name="ID" value="' . $erprobt->ID. '">

  </form>
  '; 

  $info->print_link_delete_row($erprobt->table_name, $erprobt->ID, $erprobt->Title); 
} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>

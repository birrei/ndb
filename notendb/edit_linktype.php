
<?php 
include('head.php');
include("cl_linktype.php");
include("cl_html_info.php");

$linktype = new Linktype();
$info= new HtmlInfo(); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // geöffnet über einen "Bearbeiten"-Link
      $linktype->ID=$_GET["ID"]; 
      if ($linktype->load_row()) {
        $show_data=true;       
      }      
      break; 

    case 'insert': 
      $linktype->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $linktype->ID = $_POST["ID"];    
      $linktype->update_row($_POST["Name"]); 
      $show_data=true;          
      break; 
  }

}

$info->print_screen_header($linktype->Title.' bearbeiten'); 
$info->print_link_table($linktype->table_name, 'sortcol=Name', $linktype->Titles); 

if ($show_data) {

  echo '<p> 
  <form action="edit_linktype.php" method="post">
  <table class="eingabe"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$linktype->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.$linktype->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $linktype->ID. '">

  </form>
  </p> 

  '; 

  $info->print_link_delete_row2($linktype->table_name, $linktype->ID, $linktype->Title); 
}
else {
  $info->print_user_error(); 
}

include('foot.php');

?>

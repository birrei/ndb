
<?php 
include('head.php');
include("cl_komponist.php");
include("cl_html_info.php");


$komponist = new Komponist();
$info= new HtmlInfo(); 

$show_data=false; 



if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $komponist->ID=$_GET["ID"];
      if ($komponist->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $komponist->insert_row('', ''); ;
      $show_data=true; 
      break; 
    
    case 'update': 
      $komponist->ID = $_POST["ID"];    
      $komponist->update_row(
        $_POST["Vorname"]
        , $_POST["Nachname"]
        , $_POST["Geburtsjahr"]
        , $_POST["Sterbejahr"]
        , $_POST["Bemerkung"]   
      )
          ;
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($komponist->Title.' bearbeiten', ' | '); 
$info->print_link_table($komponist->table_name, 'sortcol=Nachname,Vorname', $komponist->Titles); 


if ($show_data) {
    
  echo '<form action="edit_komponist.php" method="post">

  <table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$komponist->ID.'</td>
  </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Vorname:</td>  
      <td class="eingabe"><input type="text" name="Vorname" value="'.$komponist->Vorname.'" size="45" maxlength="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Nachname:</td>  
      <td class="eingabe"><input type="text" name="Nachname" value="'.$komponist->Nachname.'" size="45" maxlength="80" required="required" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr>    
    <label>
    <td class="eingabe">Geburtsjahr:</td>  
    <td class="eingabe"><input type="text" name="Geburtsjahr" value="'.$komponist->Geburtsjahr.'" size="10" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 
  <tr>    
    <label>
    <td class="eingabe">Sterbejahr:</td>  
    <td class="eingabe"><input type="text" name="Sterbejahr" value="'.$komponist->Sterbejahr.'" size="10" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

    <tr>    
      <label>
      <td class="eingabe">Bemerkung:</td>  
      <td class="eingabe"><input type="text" name="Bemerkung" value="'.$komponist->Bemerkung.'" size="80" maxlength="80" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <input type="hidden" name="option" value="update">      
      <input type="hidden" name="title" value="Komponist"> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">  
      </td>
    </tr> 

    </table> 
    <input type="hidden" name="ID" value="' . $komponist->ID. '">

    </form>
    '; 

    $info->print_link_delete_row2($komponist->table_name, $komponist->ID,$komponist->Title); 

  } 
  else {
      $info->print_user_error(); 
  }
    

include('foot.php');

?>

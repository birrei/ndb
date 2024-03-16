
<?php 
include('head.php');
include("cl_komponist.php");
include("cl_html_info.php");

echo '<h2>Komponist bearbeiten</h2>'; 

$komponist = new Komponist();

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $komponist->load_row($ID); 
}

if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 

    $komponist->update_row(
                      $ID
                      , $_POST["Vorname"]
                      , $_POST["Nachname"]
                      , $_POST["Geburtsjahr"]
                      , $_POST["Sterbejahr"]
                      , $_POST["Bemerkung"]                      
                    ); 
  }
  $info= new HtmlInfo(); 
  $info->print_action_info($komponist->ID, 'update'); 
  $info->print_close_form_info();         
}

echo '
<form action="edit_komponist.php" method="post">

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
    <td class="eingabe"><input type="text" name="Vorname" value="'.$komponist->Vorname.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Nachname:</td>  
    <td class="eingabe"><input type="text" name="Nachname" value="'.$komponist->Nachname.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
  <label>
  <td class="eingabe">Geburtsjahr:</td>  
  <td class="eingabe"><input type="text" name="Geburtsjahr" value="'.$komponist->Geburtsjahr.'" size="10" maxlength="80" autofocus="autofocus"></td>
  </label>
</tr> 
<tr>    
  <label>
  <td class="eingabe">Sterbejahr:</td>  
  <td class="eingabe"><input type="text" name="Sterbejahr" value="'.$komponist->Sterbejahr.'" size="10" maxlength="80" autofocus="autofocus"></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" value="'.$komponist->Bemerkung.'" size="80" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <input type="hidden" name="option" value="edit">      
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 

  </table> 
  <input type="hidden" name="ID" value="' . $komponist->ID. '">

  </form>
  '; 

if (isset($_POST["senden"])) {
    $ID= $_POST["ID"]; 
    if ($_POST["option"] == 'edit') { 
      $info= new HtmlInfo(); 
      $info->print_action_info($komponist->ID, 'update'); 
      $info->print_close_form_info();       
     }
}


include('foot.php');

?>


<?php 
include('head.php');
include("cl_komponist.php");
include("cl_html_info.php");

echo '<h2>Komponist bearbeiten</h2>'; 

$komponist = new Komponist();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $komponist->ID=$_GET["ID"];
  $komponist->load_row();  
  $info->print_action_info($komponist->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $komponist->insert_row($_GET["Vorname"], $_GET["Nachname"]); ;  
  $info->print_action_info($komponist->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $komponist->ID = $_POST["ID"];    
  $komponist->update_row(
                      $_POST["Vorname"]
                      , $_POST["Nachname"]
                      , $_POST["Geburtsjahr"]
                      , $_POST["Sterbejahr"]
                      , $_POST["Bemerkung"]                      
                    ); 
  $info->print_action_info($komponist->ID, 'update');     
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
    <input type="hidden" name="option" value="edit">      
    <input type="hidden" name="title" value="Komponist"> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 

  </table> 
  <input type="hidden" name="ID" value="' . $komponist->ID. '">

  </form>
  '; 


include('foot.php');

?>

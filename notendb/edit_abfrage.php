
<?php 
include('head.php');
include("cl_abfrage.php");
include("cl_html_info.php");

echo '<h2>Abfrage bearbeiten</h2>'; 

$abfrage = new Abfrage();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $abfrage->ID=$_GET["ID"];
  $abfrage->load_row(); 
  if ($abfrage->success) {
    $info->print_action_info($abfrage->ID, 'view');       
  }
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $abfrage->insert_row($_GET["Name"]); 
  $info->print_action_info($abfrage->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $abfrage->ID = $_POST["ID"];    
  $abfrage->update_row(
        $_POST["Name"]
      , $_POST["Beschreibung"]
      , $_POST["Abfrage"]      
      , $_POST["Tabelle"]      
      )
      ; 
  $info->print_action_info($abfrage->ID, 'update');     
}

if ($abfrage->success) {
echo '
  <p>
  <a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage">Abfrage-Ergebnis anzeigen</a>
</p> 

<form action="edit_abfrage.php" method="post">
<table class="eingabe" width="100%"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$abfrage->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($abfrage->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="eingabe">Beschreibung:</td>  
    <td class="eingabe">
    <textarea name="Beschreibung" rows=2 cols=120 maxlength="255" oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Beschreibung).'</textarea> (max. 250 Zeichen)  
    </td>
    </label>
  </tr> 

    <tr>    
      <label>
      <td class="eingabe">Abfrage (SQL):</td>  
      <td class="eingabe">
      <textarea name="Abfrage" rows=7 cols=120 maxlength="1000" oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Abfrage).'</textarea> (max. 10000 Zeichen)
      </td>
      </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Tabelle für Bearbeitung:</td>  
    <td class="eingabe"><input type="text" name="Tabelle" value="'.$abfrage->Tabelle.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 



  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 


</table> 
<input type="hidden" name="option" value="edit"> 
<input type="hidden" name="title" value="Abfrage">          
<input type="hidden" name="ID" value="' . $abfrage->ID. '">

</form>


<p>
<a href="delete_abfrage.php?ID=' . $abfrage->ID . '&title=Abfrage löschen">Abfrage löschen</a>
</p>

'; 
} 

include('foot.php');

?>

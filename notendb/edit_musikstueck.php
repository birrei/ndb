
<?php 
include('head.php');
include("cl_musikstueck.php");
include("cl_komponist.php");
include("cl_sammlung.php");
include("cl_gattung.php");
include("cl_epoche.php");
include('cl_html_info.php');

echo '<h2>Musikstück bearbeiten</h2>';

$musikstueck = new Musikstueck();
$info= new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $musikstueck->ID=$_GET["ID"]; 
  $musikstueck->load_row(); 
  $info->print_action_info($musikstueck->ID, 'view');      
}
if (isset($_GET["option"])){
  if($_GET["option"]=='insert') {
    $musikstueck->SammlungID=$_GET["SammlungID"]; 
    $musikstueck->insert_row('',''); 
    $info->print_action_info($musikstueck->ID, 'insert');       
  } 
}
if (isset($_POST["senden"])) {
  if ($_POST["option"] == 'edit') { 
    $musikstueck->ID=$_POST["ID"];    
    $musikstueck->update_row(
                $_POST["Nummer"]
                    , $_POST["Name"]
                    , $_POST["SammlungID"]
                    , $_POST["KomponistID"]
                    , $_POST["Opus"]
                    , $_POST["GattungID"]
                    , $_POST["Bearbeiter"]
                    , $_POST["EpocheID"]
                    , $_POST["JahrAuffuehrung"]
                    ); 
    $musikstueck->load_row();   
    $info= new HtmlInfo(); 
    $info->print_action_info($musikstueck->ID, 'update');      
  }
}

echo '
<form action="edit_musikstueck.php?title=Musikstueck" method="post">

<table class="eingabe"> 
<tr>    
<label>
<td class="eingabe"><b>ID:</b></td>  
<td class="eingabe">'.$musikstueck->ID.'</td>
</label>
</tr> 
<tr>    
<label>
<td class="eingabe"><b>Sammlung:</b></td>  
<td class="eingabe">
'; 

$sammlung = new Sammlung();
$sammlung->print_select($musikstueck->SammlungID); 

echo ' <a href="edit_sammlung.php?ID='.$musikstueck->SammlungID.'&title=Sammlung">Gehe zu Sammlung</a>'; 
echo '</tr></label>
<tr>    
<label>
<td class="eingabe"><b>Nummer:</b></td>  
<td class="eingabe"><input type="text" name="Nummer" value="'.$musikstueck->Nummer.'" size="30" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
</label>
</tr> 

<tr>    
  <label>
  <td class="eingabe"><b>Name:</b></td>  
  <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($musikstueck->Name).'" size="100" maxlength="100" required="required" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
  </label>
</tr> 

<tr>    
<label>
<td class="eingabe"><b>Komponist:</b></td>  
<td class="eingabe">    
'; 
  $komponisten = new Komponist();
  $komponisten->print_select($musikstueck->KomponistID); 

echo  ' </label> 
&nbsp; <a href="edit_komponist.php?title=Komponist&option=insert" target="_blank">Neu erfassen</a>
 | <a href="show_table2.php?table=v_komponist&sortcol=Name&title=Komponisten" target="_blank">Daten anzeigen</a>

</td>
</tr> 



<tr>    
  <label>
  <td class="eingabe"><b>Opus:</b></td>  
  <td class="eingabe"><input type="text" name="Opus" value="'.$musikstueck->Opus.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 

<tr>    
  <label>
  <td class="eingabe"><b>Bearbeiter:</td>  
  <td class="eingabe"><input type="text" name="Bearbeiter" value="'.$musikstueck->Bearbeiter.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 

<tr>    
<label>
  <td class="eingabe"><b>Epoche:</b>
  
  </td>  
  <td class="eingabe">    
  '; 
    $epochen = new Epoche();
    $epochen->print_select($musikstueck->EpocheID); 

  echo  ' </label>  
  &nbsp; <a href="edit_epoche.php?title=Epoche&option=insert" target="_blank">Neu erfassen</a>
      | <a href="show_table2.php?table=epoche&sortcol=Name&title=Epochen" target="_blank">Daten anzeigen</a>
 
  </td>
   
</tr> 

<tr>    
<label>
  <td class="eingabe"><b>Gattung:</b></td>  
  <td class="eingabe">    
  '; 
    $gattungen = new Gattung();
    $gattungen->print_select($musikstueck->GattungID); 

  echo  '  </label>  
  &nbsp; <a href="edit_gattung.php?title=Gattung&option=insert" target="_blank">Neu erfassen</a>
   | <a href="show_table2.php?table=gattung&sortcol=Name&title=Gattungen" target="_blank">Daten anzeigen</a>
  </td>
</tr> 

<tr>    
<label>
<td class="eingabe"><b>Aufführungsjahre:</b></td>  
<td class="eingabe"><input type="text" name="JahrAuffuehrung" value="'.$musikstueck->JahrAuffuehrung.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
</label>
</tr>         

<tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">
</td>
</tr> 

    <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
    <input type="hidden" name="option" value="edit">      
    <input type="hidden" name="title" value="Musikstueck">  
    </form>

  <tr> 
    <td class="eingabe"><b>Verwendungszweck(e):</b>
      <br><a href="edit_verwendungszweck.php?title=Verwendungszweck&option=insert" target="_blank">Neu erfassen</a>
      <br><a href="show_table2.php?table=verwendungszweck&sortcol=Name&title=Verwendungszwecke" target="_blank">Daten anzeigen</a>
      <br><a href="edit_musikstueck_list_verwendungszwecke.php?MusikstueckID='.$musikstueck->ID.'" target="Verwendungszwecke">Aktualisieren</a>
    </td> 
    <td class="eingabe">
      <iframe src="edit_musikstueck_list_verwendungszwecke.php?MusikstueckID='.$musikstueck->ID.'" width="500" height="100" name="Verwendungszwecke"></iframe> 
    </td>
  </tr> 

  <tr> 
    <td class="eingabe"><b>Besetzung(en):</b>
      <br> <a href="edit_besetzung.php?title=Besetzung&option=insert" target="_blank">Neu erfassen</a>
      <br> <a href="show_table2.php?table=besetzung&sortcol=Name&title=Besetzungen" target="_blank">Daten anzeigen</a>      
      <br> <a href="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$musikstueck->ID.'" target="Besetzungen">Aktualisieren</a>    
      </td> 
    <td class="eingabe">
      <iframe src="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$musikstueck->ID.'" width="500" height="100" name="Besetzungen"></iframe>
    </td>
  </tr> 

  <tr> 
    <td class="eingabe"><b>Sätze:</b>
    <br><a href="edit_satz.php?MusikstueckID='.$musikstueck->ID.'&option=insert&title=Satz" target="_blank">Satz hinzufügen</a>
    <br><a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$musikstueck->ID.'" target="Saetze">Aktualisieren</a>
    
    </td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_saetze.php?MusikstueckID='.$musikstueck->ID.'" width="100%" height="400" name="Saetze"></iframe>
  </td>
  </tr> 
               

</table> 

<p>
<a href="delete_musikstueck.php?ID=' . $musikstueck->ID . '&title=Musikstück löschen">Musikstück löschen</a>
</p>
'; 




include('foot.php');

?>


<?php 
include('head.php');
include("cl_musikstueck.php");
include("cl_komponist.php");
include("cl_sammlung.php");

$table='musikstueck'; 

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $musikstueck = new Musikstueck();
  $musikstueck->load_row($ID); 
}

if (isset($_POST["senden"])) {
  $ID= $_POST["ID"];  
  $musikstueck = new Musikstueck();
  $musikstueck->update_row(
    $ID
    , $_POST["Nummer"]
    , $_POST["Name"]
    , $_POST["SammlungID"]
    , $_POST["KomponistID"]
    , $_POST["Opus"]
    , $_POST["Gattung"]
    , $_POST["Bearbeiter"]
    , $_POST["Epoche"]
    , $_POST["JahrAuffuehrung"]
  ); 
  $musikstueck->load_row($ID);   
}




echo '

<h2>Musikstück bearbeiten</h2>

<form action="edit_musikstueck.php" method="post">

<table class="eingabe"> 
<tr>    
<label>
<td class="eingabe">ID:</td>  
<td class="eingabe">'.$musikstueck->ID.'</td>
</label>
</tr> 

<tr>    
<label>
<td class="eingabe">Nummer:</td>  
<td class="eingabe"><input type="text" name="Nummer" value="'.$musikstueck->Nummer.'" size="45" maxlength="80"  autofocus="autofocus"></td>
</label>
</tr> 

<tr>    
  <label>
  <td class="eingabe">Name:</td>  
  <td class="eingabe"><input type="text" name="Name" value="'.$musikstueck->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
  </label>
</tr> 

<tr>    
<label>
<td class="eingabe">Komponist:</td>  
<td class="eingabe">
<!-- Auswahlliste Komponist  -->         
'; 
  $komponisten = new Komponist();
  $komponisten->print_select($musikstueck->KomponistID); 
  echo ' </label>'; 

  // echo get_html_insert_link2('komponist', true);  

echo  '</td>
</tr> 
<tr>    
<label>
<td class="eingabe">Sammlung:</td>  
<td class="eingabe">

'; 

$sammlung = new Sammlung();
$sammlung->print_select($musikstueck->SammlungID); 

echo '</tr></label>
<tr>    
  <label>
  <td class="eingabe">Opus:</td>  
  <td class="eingabe"><input type="text" name="Opus" value="'.$musikstueck->Opus.'" size="45" maxlength="80" autofocus="autofocus"></td>
  </label>
</tr> 

<tr>    
  <label>
  <td class="eingabe">Bearbeiter:</td>  
  <td class="eingabe"><input type="text" name="Bearbeiter" value="'.$musikstueck->Bearbeiter.'" size="45" maxlength="80" autofocus="autofocus"></td>
  </label>
</tr> 

<tr>    
  <label>
  <td class="eingabe">Epoche:</td>  
  <td class="eingabe"><input type="text" name="Epoche" value="'.$musikstueck->Epoche.'" size="45" maxlength="80" autofocus="autofocus"></td>
  </label>
</tr> 

<tr>    
<label>
<td class="eingabe">Gattung:</td>  
<td class="eingabe"><input type="text" name="Gattung" value="'.$musikstueck->Gattung.'" size="45" maxlength="80" autofocus="autofocus"></td>
</label>
</tr> 

</tr> 

<tr>    
<label>
<td class="eingabe">Aufführungsjahre:</td>  
<td class="eingabe"><input type="text" name="JahrAuffuehrung" value="'.$musikstueck->JahrAuffuehrung.'" size="45" maxlength="80" autofocus="autofocus"></td>
</label>
</tr>         

<tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input type="submit" name="senden" value="Speichern und Datensatz neu laden">
</td>
</tr> 

    <input type="hidden" name="ID" value="' . $ID. '">
    <input type="hidden" name="option" value="edit">      

    </form>


    <tr> 
    <td class="eingabe">Verwendungszweck(e):</td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_verwendungszwecke.php?MusikstueckID='.$ID.'" width="1000" height="200" name="Besetzungen"></iframe>
  </td>
  </tr> 
      

  <tr> 
    <td class="eingabe">Besetzung(en):</td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$ID.'" width="1000" height="200" name="Besetzungen"></iframe>
  </td>
  </tr> 

  <tr> 
    <td class="eingabe">Sätze:<br>(Anzeige ausgewählte Felder)</td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_saetze.php?MusikstueckID='.$ID.'" width="1000" height="400" name="Saetze"></iframe>
  </td>
  </tr> 
               

</table> 

'; 


// echo get_html_showtablelink($table); 

include('foot.php');

?>

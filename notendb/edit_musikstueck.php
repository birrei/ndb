
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
<td class="eingabe">Sammlung:</td>  
<td class="eingabe">
'; 

$sammlung = new Sammlung();
$sammlung->print_select($musikstueck->SammlungID); 

echo '</tr></label>


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
'; 
  $komponisten = new Komponist();
  $komponisten->print_select($musikstueck->KomponistID); 

echo  '</td>
</tr> 
</label>


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
  <td class="eingabe">    
  '; 
    $epochen = new Epoche();
    $epochen->print_select($musikstueck->EpocheID); 

  echo  '</td>
  </label>  
</tr> 


<tr>    
<label>
  <td class="eingabe">Gattung:</td>  
  <td class="eingabe">    
  '; 
    $gattungen = new Gattung();
    $gattungen->print_select($musikstueck->GattungID); 

  echo  '</td>
  </label>  
</tr> 




<tr>    
<label>
<td class="eingabe">Aufführungsjahre:</td>  
<td class="eingabe"><input type="text" name="JahrAuffuehrung" value="'.$musikstueck->JahrAuffuehrung.'" size="45" maxlength="80" autofocus="autofocus"></td>
</label>
</tr>         

<tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">
</td>
</tr> 

    <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
    <input type="hidden" name="option" value="edit">      

    </form>


    <tr> 
    <td class="eingabe">Verwendungszweck(e):</td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_verwendungszwecke.php?MusikstueckID='.$musikstueck->ID.'" width="500" height="100" name="Besetzungen"></iframe>
  </td>
  </tr> 
      

  <tr> 
    <td class="eingabe">Besetzung(en):</td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$musikstueck->ID.'" width="500" height="100" name="Besetzungen"></iframe>
  </td>
  </tr> 

  <tr> 
    <td class="eingabe">Sätze:
    <br><a href="edit_satz.php?MusikstueckID='.$musikstueck->ID.'&option=insert" target="_blank">Satz hinzufügen</a></p>
    </td> 
    <td class="eingabe"><iframe src="edit_musikstueck_list_saetze.php?MusikstueckID='.$musikstueck->ID.'" width="1000" height="400" name="Saetze"></iframe>
  </td>
  </tr> 
               

</table> 

'; 

include('foot.php');

?>

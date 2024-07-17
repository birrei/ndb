
<?php 
include('head.php');
include('cl_satz.php');
include('cl_musikstueck.php');
include('cl_erprobt.php');
include('cl_schwierigkeitsgrad.php'); // entfernen 
include('cl_html_info.php');

echo '<h2>Satz bearbeiten</h2>'; 

$satz=new Satz(); 
$info= new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $satz->ID= $_GET["ID"]; 
  $satz->load_row(); 
  $info->print_action_info($satz->ID, 'view');      
}
if (isset($_GET["option"])){
  if($_GET["option"]=='insert') {
    $satz->MusikstueckID=$_GET["MusikstueckID"]; 
    $satz->insert_row('',''); 
    $info->print_action_info($satz->ID, 'insert');       
  } 
}
if (isset($_POST["option"])) {
  $satz->ID=$_POST["ID"];    
  if ($_POST["option"] == 'edit') { 
    $satz->update_row(
                $_POST["Name"]
                  , $_POST["Nr"]
                  , $_POST["MusikstueckID"]
                  , $_POST["Tonart"]
                  , $_POST["Taktart"]
                  , $_POST["Tempobezeichnung"]
                  , $_POST["Spieldauer"]
                  , $_POST["Lagen"]
                  , $_POST["ErprobtID"]
                  , $_POST["Bemerkung"]
                  
                    ); 
    $info= new HtmlInfo(); 
    $info->print_action_info($satz->ID, 'update'); 
    // $info->print_close_form_info();                     
  }
}
?>

<p id="test"></p>
<?php

echo 
'<form action="edit_satz.php" method="post">

<table class="eingabe"> 
<tr>    
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$satz->ID.'</td>
</tr> 

<tr>    
  <label>
  <td class="eingabe"><b>Musikstück:</b></td>  
  <td class="eingabe">
  '; 
  $musikstueck=new Musikstueck(); 
  $musikstueck->ID=$satz->MusikstueckID; 
  $musikstueck->print_select($satz->MusikstueckID); 
  
  echo ' <a href="edit_musikstueck.php?ID='.$satz->MusikstueckID.'&title=Musikstück" tabindex="-1">Gehe zu Musikstück</a>'; 
  echo '
  </td>  
  </label>
</tr>         

<tr>    
  <label>
  <td class="eingabe"><b>Nr:</b></td>  
  <td class="eingabe"><input type="text" name="Nr" value="'.$satz->Nr.'" size="45" maxlength="80"  autofocus="autofocus" required oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="eingabe"><b>Name:</b></td>  
    <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($satz->Name).'" size="100" maxlength="100" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe"><b>Tonart:</b></td>  
    <td class="eingabe"><input type="text" name="Tonart" value="'.$satz->Tonart.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe"><b>Taktart:</b></td>  
    <td class="eingabe"><input type="text" name="Taktart" value="'.$satz->Taktart.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe"><b>Tempobezeichnung:</b></td>  
    <td class="eingabe"><input type="text" name="Tempobezeichnung" value="'.$satz->Tempobezeichnung.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe"><b>Spieldauer:</b></td>  
    <td class="eingabe">
    
    Minuten: <input type="text" id="input_minutes" size="10" oninput="set_seconds();changeBackgroundColor(this)">
    Sekunden: <input type="text" id="input_seconds" name="Spieldauer" value="'.$satz->Spieldauer.'" size="10" maxlength="80" onchange="changeBackgroundColor(this)"> 
      
      <script type="text/javascript">  
        function set_seconds() {
          var txt_min = document.getElementById("input_minutes").value;
          var sekunden = getSeconds(txt_min);
          document.getElementById("input_seconds").value=sekunden;         
        }
      </script> 
      </td>
      </label>
  </tr> 
  
  <tr>   
    <td class="eingabe"><b>Erprobt:</b></td>   
    <td class="eingabe">'; 
      $erprobt=new Erprobt(); 
      $erprobt->print_select($satz->ErprobtID); 
    echo  '
    &nbsp; 
    <a href="edit_erprobt.php?ID='.$satz->ErprobtID.'&title=Erprobt" target="_blank" tabindex="-1">Bearbeiten</a> | 
    <a href="show_table2.php?table=erprobt&sortcol=Name&title=Erprobt" target="_blank" tabindex="-1">Daten anzeigen</a> | 
    <a href="edit_erprobt.php?title=Erprobt&option=insert" target="_blank" tabindex="-1">Neu erfassen</a>

    </td>
  </tr>

  <tr>    
    <label>
    <td class="eingabe"><b>Lagen:</b> (zu Besonderheiten?) </td>  
    <td class="eingabe"><input type="text" name="Lagen" value="'.$satz->Lagen.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
  <label>
  <td class="eingabe"><b>Bemerkung:</b></td>  
  <td class="eingabe">
  <textarea name="Bemerkung" rows=5 cols=100 maxlength="500" oninput="changeBackgroundColor(this)">'.htmlentities($satz->Bemerkung).'</textarea> (max. 500 Zeichen)
  </td>
  </label>
</tr>

  <tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input class="btnSave" type="submit" name="update" value="Speichern">

  </td>
  </tr> 

  <input type="hidden" name="ID" value="' . $satz->ID . '">
  <input type="hidden" name="option" value="edit"> 
  <input type="hidden" name="title" value="Satz">      

  </form>

  <tr> 
  <td class="eingabe"><b>Schwierigkeitsgrad(e):</b>
      <br> <a href="edit_instrument.php?title=Instrument&option=insert" target="_blank">Neues Instrument erfassen</a>   
      <br> <a href="show_table2.php?table=instrument&sortcol=Name&title=Instrumente" target="_blank">Übersicht Instrumente</a>  
      <br> <a href="edit_satz_list_schwierigkeitsgrade.php?SatzID='.$satz->ID.'" target="Schwierigkeitsgrade">Aktualisieren</a> 
  </td> 
  <td class="eingabe">
    <iframe src="edit_satz_list_schwierigkeitsgrade.php?SatzID='.$satz->ID.'" width="500" height="100" name="Schwierigkeitsgrade"></iframe>
  </td>
  </tr> 

  <tr> 
  <td class="eingabe"><b>Besonderheiten:</b>
            <br> <a href="show_table2.php?table=v_lookup&sortcol=LookupType,Name&title=Besonderheiten" target="_blank">Übersicht Besonderheiten</a>  
            <br> <a href="edit_satz_list_lookups.php?SatzID='.$satz->ID.'" target="Lookups">Aktualisieren</a>    
  </td> 
  <td class="eingabe"><iframe src="edit_satz_list_lookups.php?SatzID='.$satz->ID.'" width="500" height="300" name="Lookups"></iframe>
  </td>
  </tr> 

  
</table> 

<p>
<a href="delete_satz.php?ID=' . $satz->ID . '&title=Satz löschen">Satz löschen</a>
</p>
'; 



include('foot.php');

?>



<?php 
include('head.php');
include('cl_satz.php');
include('cl_musikstueck.php');
include('cl_erprobt.php');
include('cl_schwierigkeitsgrad.php');
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
if (isset($_POST["senden"])) {
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
                  , $_POST["SchwierigkeitsgradID"]
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
  <td class="eingabe">Musikstück:</td>  
  <td class="eingabe">
  '; 
  $musikstueck=new Musikstueck(); 
  $musikstueck->ID=$satz->MusikstueckID; 
  $musikstueck->print_select($satz->MusikstueckID); 
  
  echo '
  </td>  
  </label>
</tr>         

<tr>    
  <label>
  <td class="eingabe">Nr:</td>  
  <td class="eingabe"><input type="text" name="Nr" value="'.$satz->Nr.'" size="45" maxlength="80"  autofocus="autofocus" required></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($satz->Name).'" size="100" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Tonart:</td>  
    <td class="eingabe"><input type="text" name="Tonart" value="'.$satz->Tonart.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Taktart:</td>  
    <td class="eingabe"><input type="text" name="Taktart" value="'.$satz->Taktart.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Tempobezeichnung:</td>  
    <td class="eingabe"><input type="text" name="Tempobezeichnung" value="'.$satz->Tempobezeichnung.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Spieldauer:</td>  
    <td class="eingabe">
    Minuten: <input type="text" id="input_minutes" size="10" oninput="set_seconds();">
    Sekunden: <input type="text" id="input_seconds" name="Spieldauer" value="'.$satz->Spieldauer.'" size="10" maxlength="80"> Info unter <a href="help.php" target="_blank">Hilfe</a>, Kapitel: Erfassung Satz: "Spieldauer" XXX 
      </td>
      </label>

  </tr> 



  <tr>   
    <label>
    <td class="eingabe">Schwierigkeitsgrad:</td>   
    <td class="eingabe">'; 
      $erprobt=new Schwierigkeitsgrad(); 
      $erprobt->print_select($satz->SchwierigkeitsgradID); 
    echo  
    '</td>
    </label>
  </tr>
  
  <tr>   
    <td class="eingabe">Erprobt:</td>   
    <td class="eingabe">'; 
      $erprobt=new Erprobt(); 
      $erprobt->print_select($satz->ErprobtID); 
    echo  
    '</td>
  </tr>

  <tr>    
    <label>
    <td class="eingabe">Lagen:</td>  
    <td class="eingabe"><input type="text" name="Lagen" value="'.$satz->Lagen.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" value="'.htmlentities($satz->Bemerkung).'" size="100" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 



  <tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">

  </td>
  </tr> 

  <input type="hidden" name="ID" value="' . $satz->ID . '">
  <input type="hidden" name="option" value="edit">      

  </form>

  <tr> 
  <td class="eingabe">Stricharten:</td> 
  <td class="eingabe"><iframe src="edit_satz_list_stricharten.php?SatzID='.$satz->ID.'" width="500" height="100" name="Stricharten"></iframe>
  </td>
  </tr> 

  <tr> 
  <td class="eingabe">Notenwerte:</td> 
  <td class="eingabe"><iframe src="edit_satz_list_notenwerte.php?SatzID='.$satz->ID.'" width="500" height="100" name="Stricharten"></iframe>
  </td>
  </tr> 

  <tr> 
  <td class="eingabe">Übungen:</td> 
  <td class="eingabe"><iframe src="edit_satz_list_uebungen.php?SatzID='.$satz->ID.'" width="500" height="100" name="Uebungen"></iframe>
  </td>
  </tr> 


</table> 

'; 

include('foot.php');

?>


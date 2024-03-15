
<?php 
include('head.php');
include('cl_satz.php');
include('cl_musikstueck.php');
include('cl_html_info.php');

$satz=new Satz(); 

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $satz->ID= $ID;   
  $satz->load_row(); 
}
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  $satz->ID= $ID;     
  if ($_POST["option"] == 'edit') { 
    $satz->update_row(
                $_POST["Name"]
                  , $_POST["Nr"]
                  , $_POST["MusikstueckID"]
                  , $_POST["Tonart"]
                  , $_POST["Taktart"]
                  , $_POST["Tempobezeichnung"]
                  , $_POST["Spieldauer"]
                  , $_POST["Schwierigkeitsgrad"]
                  , $_POST["Lagen"]
                  , $_POST["Notenwerte"]
                  , $_POST["Erprobt"]
                  , $_POST["Bemerkung"]
                  
                    ); 
    $info= new HtmlInfo(); 
    $info->print_action_info($satz->ID, 'update'); 
    $info->print_close_form_info();                     
  }
}

echo 
'<h2>Satz bearbeiten</h2>
<form action="edit_satz.php" method="post">

<table class="eingabe"> 
<tr>    
<label>
<td class="eingabe">ID:</td>  
<td class="eingabe">'.$ID.'</td>
</label>
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
  </label></td></tr>         
  <tr>    
  <label>
  <td class="eingabe">Nr:</td>  
  <td class="eingabe"><input type="text" name="Nr" value="'.$satz->Nr.'" size="45" maxlength="80"  autofocus="autofocus" required></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$satz->Name.'" size="45" maxlength="80" autofocus="autofocus"></td>
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
    <td class="eingabe"><input type="text" name="Spieldauer" value="'.$satz->Spieldauer.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Schwierigkeitsgrad:</td>  
    <td class="eingabe"><input type="text" name="Schwierigkeitsgrad" value="'.$satz->Schwierigkeitsgrad.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Lagen:</td>  
    <td class="eingabe"><input type="text" name="Lagen" value="'.$satz->Lagen.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Notenwerte:</td>  
    <td class="eingabe"><input type="text" name="Notenwerte" value="'.$satz->Notenwerte.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 



  <tr>    
    <label>
    <td class="eingabe">Erprobt:</td>  
    <td class="eingabe"><input type="text" name="Erprobt" value="'.$satz->Erprobt.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" value="'.$satz->Bemerkung.'" size="100" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 



<tr> 
<td class="eingabe"></td> 
<td class="eingabe"><input type="submit" name="senden" value="Speichern">

</td>
</tr> 

  <input type="hidden" name="ID" value="' . $satz->ID . '">
  <input type="hidden" name="option" value="edit">      

  </form>

  <tr> 
  <td class="eingabe">Stricharten:</td> 
  <td class="eingabe"><iframe src="edit_satz_list_stricharten.php?SatzID='.$satz->ID.'" width="500" height="200" name="Stricharten"></iframe>
</td>
</tr> 



</table> 

'; 

include('foot.php');

?>

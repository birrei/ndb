
<?php 
include('head.php');
include('cl_satz.php');
include('cl_musikstueck.php');
include('cl_erprobt.php');
include('cl_schwierigkeitsgrad.php'); // entfernen 
include('cl_html_info.php');

echo '<h2>Satz bearbeiten</h2>'; 

$info= new HtmlInfo(); 

$satz=new Satz(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $satz->ID=$_GET["ID"];
      if ($satz->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $satz->MusikstueckID=$_GET["MusikstueckID"]; 
      $satz->insert_row('',''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $satz->ID = $_POST["ID"];    
      $satz->update_row(
        $_POST["Name"]
          , $_POST["Nr"]
          , $_POST["MusikstueckID"]
          , $_POST["Tonart"]
          , $_POST["Taktart"]
          , $_POST["Tempobezeichnung"]
          , $_POST["Spieldauer"]
          , $_POST["Bemerkung"]
          , $_POST["Orchesterbesetzung"]                  
            ); 
          ;
      $show_data=true;           
      break; 

    case 'copy': 
      $ID_ref=$_REQUEST["ID"]; 
      $satz->ID=$ID_ref; 
      $satz->copy();   
      $satz->load_row();       
      $info->print_info_copy($satz->Title, $ID_ref, $satz->ID, 'edit_satz'); 
      $show_data=true; 
      break; 
            
  }
}



if ($show_data) {
    
  echo 
  '<form action="edit_satz.php" method="post">

  <table class="form-edit"> 
  <tr>    
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$satz->ID.'</td>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Musikstück:</td>  
    <td class="form-edit form-edit-col2">
    '; 
    $musikstueck=new Musikstueck(); 
    $musikstueck->ID=$satz->MusikstueckID; 
    $musikstueck->print_select($satz->MusikstueckID); 
    
    echo ' <a href="edit_musikstueck.php?ID='.$satz->MusikstueckID.'&title=Musikstück&option=edit" tabindex="-1" class="form-link">Gehe zu Musikstück</a>'; 
    echo '
    </td>  
    </label>
  </tr>         

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Nr:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Nr" value="'.$satz->Nr.'" size="45" maxlength="80"  autofocus="autofocus" required oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($satz->Name).'" size="100" maxlength="100" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
      </label>
    </tr> 


    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Tempobezeichnung:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Tempobezeichnung" value="'.$satz->Tempobezeichnung.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Tonart:</td>  
      <td class="form-edit form-edit-col2">
      <input type="text" name="Tonart" value="'.$satz->Tonart.'" size="45" oninput="changeBackgroundColor(this)">
      </label>
     <label>
      Taktart: 
      <input type="text" name="Taktart" value="'.$satz->Taktart.'" size="45" oninput="changeBackgroundColor(this)"></td>
            </label>
      </td>
    </tr> 


    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Spieldauer:</td>  
      <td class="form-edit form-edit-col2">
      
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
      <label>
      <td class="form-edit form-edit-col1">Orchesterbesetzung:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Orchesterbesetzung" value="'.$satz->Orchesterbesetzung.'" size="120" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">
    <textarea name="Bemerkung" rows=1 cols=100 maxlength="500" oninput="changeBackgroundColor(this)">'.htmlentities($satz->Bemerkung).'</textarea> (max. 500 Zeichen)
    </td>
    </label>
  </tr>

    <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="update" value="Speichern">

    </td>
    </tr> 

    <input type="hidden" name="ID" value="' . $satz->ID . '">
    <input type="hidden" name="option" value="update"> 
    <input type="hidden" name="title" value="Satz">      

    </form>


    ';
    ?> 

    <tr> 
    <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
    <input type="radio" id="opt_Schwierigkeitsgrad" name="target_form" value="Schwierigkeitsgrad" onclick="changeIframeSrc('subform1', 'edit_satz_schwierigkeitsgrade.php?SatzID=<?php echo $satz->ID; ?>');" checked>
    <label for="opt_Schwierigkeitsgrad">Schwierigkeitsgrad</label><br>
    <input type="radio" id="opt_Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_satz_lookups.php?SatzID=<?php echo $satz->ID; ?>');">
    <label for="opt_Besonderheiten">Besonderheiten</label><br>
    <input type="radio" id="opt_Erprobt" name="target_form" value="Erprobt" onclick="changeIframeSrc('subform1', 'edit_satz_erprobte.php?SatzID=<?php echo $satz->ID; ?>');">
    <label for="opt_Erprobt">Erprobt</label>
    <br/>
    <input type="radio" id="opt_Schueler" name="target_form" value="Schueler" onclick="changeIframeSrc('subform1', 'edit_satz_schuelers.php?SatzID=<?php echo $satz->ID; ?>');">
    <label for="opt_Schueler">Schüler</label>

    </td> 
    <td class="form-edit form-edit-col2">
      <iframe src="edit_satz_schwierigkeitsgrade.php?SatzID=<?php echo $satz->ID; ?>&source=iframe" height="300" id="subform1" name="Info" class="form-iframe-var2"></iframe>
    </td>
    </tr> 

    </table> 

    <?php 

    $info->print_link_delete_row2($satz->table_name, $satz->ID, $satz->Title, false); 


    echo '<p> 
    <form action="edit_satz.php" method="post">
        <input type="hidden" name="ID" value="' . $satz->ID. '">
        <input type="hidden" name="option" value="copy">      
        <input type="hidden" name="title" value="Satz"> 
        <input type="submit" name="senden" value="Satz kopieren">             
    </form>
  </p> '; 


} 
else {
    $info->print_user_error(); 
}



include('foot.php');

?>


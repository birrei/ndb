<?php 
include_once("classes/class.satz.php"); 
include_once("classes/class.abschnitt.php"); 
include_once("classes/class.htmlinfo.php"); 

// wird im Unterformular "Abschnitte" unter "Satz" geöffnet 

$option=$_REQUEST["option"]; 

$html= new HTML_Info(); 

$abschnitt = new Abschnitt(); 

switch($option) {

  case 'edit': 
    $abschnitt->ID =  $_REQUEST["ID"]; 
    $abschnitt->load_row();  
    $SatzID=$abschnitt->SatzID; 

  break; 

  case 'update': // aus "edit_satz_schuelers.php" > "Bearbeiten"
    
    $abschnitt->ID =  $_REQUEST["ID"]; 
    $abschnitt->update_row(
        $_REQUEST["Name"], 
        $_REQUEST["Bemerkung"], 
        $_REQUEST["SatzID"] 
    ); 
    $abschnitt->load_row(); 
    header('Location: edit_satz_abschnitte.php?SatzID='.$abschnitt->SatzID);
  break; 


  case 'insert': // aus "edit_satz_schuelers.php" > "Hinzufügen"
    $SatzID= $_REQUEST["SatzID"]; 
    $abschnitt->insert_row($SatzID); 
    $abschnitt->load_row(); 

  break;

  case "delete_1": 
    // $ID = $_REQUEST["ID"]; 
    // $schueler_satz=new SchuelerSatz(); 
    // $schueler_satz->ID=$ID; 
    // $schueler_satz->load_row(); 
    // $SatzID=$schueler_satz->SatzID; 
    // $SchuelerID=$schueler_satz->SchuelerID; 
    // $StatusID=$schueler_satz->StatusID;        
    // $DatumVon=$schueler_satz->DatumVon; 
    // $DatumBis=$schueler_satz->DatumBis;  
    // $Bemerkung=$schueler_satz->Bemerkung;   
    
    // $option='delete_2'; 
    // $nurAktiv=false;

  break; 

  // case 'delete_2': 
  //   $ID = $_REQUEST["ID"]; 
  //   $schueler_satz=new SchuelerSatz(); 
  //   $schueler_satz->ID=$ID; 
  //   $schueler_satz->load_row(); 
  //   $SatzID= $schueler_satz->SatzID; 
  //   $schueler_satz->delete(); 
        
  //   header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

  //   exit;

  //   break;

  // case 'update1':   // insert new row 
  //   $SatzID= $_POST["SatzID"]; 
  //   $SchuelerID= $_POST["SchuelerID"];    
  //   $StatusID= $_POST["StatusID"];         
  //   $DatumVon= $_POST["DatumVon"];     
  //   $DatumBis= $_POST["DatumBis"];     
  //   $Bemerkung= $_POST["Bemerkung"];     

  //   $schueler_satz=new SchuelerSatz(); 
  //   $schueler_satz->update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
  //   header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

  //   exit;
  //   break;

  // case 'update2':   // update existing row 
  //   $ID = $_POST["ID"];    
  //   $SatzID= $_POST["SatzID"]; 
  //   $SchuelerID= $_POST["SchuelerID"];    
  //   $StatusID= $_POST["StatusID"];        
  //   $DatumVon= $_POST["DatumVon"];     
  //   $DatumBis= $_POST["DatumBis"];     
  //   $Bemerkung= $_POST["Bemerkung"];  

  //   $schueler_satz=new SchuelerSatz(); 
  //   $schueler_satz->ID = $ID; 
  //   $schueler_satz->update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
  //   header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

  //   exit;

  break;

}

include_once('head_raw.php');

// if ($option=='delete_2') {
//   $html->print_form_confirm('edit_satz_schueler.php', $ID,$option,'Löschung'); 
// }
?> 
<form action="#" method="POST">
<table class="eingabe2">
<tr>    
  <td class="eingabe2 eingabe2_1">Name: </td>    
  <td class="eingabe2 eingabe2_2"><input type="text" name="Name" size="100" value="<?php echo $abschnitt->Name;  ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 
<tr>    
  <td class="eingabe2 eingabe2_1">Bemerkung: </td>    
  <td class="eingabe2 eingabe2_2"><input type="text" name="Bemerkung" size="100" value="<?php echo $abschnitt->Bemerkung; ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>
  <td class="eingabe2 eingabe2_1"></td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

 <input type="hidden" name="ID" value="<?php echo $abschnitt->ID; ?>"> 
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="option" value="update">

</form>

</table>

<?php 

include_once('foot_raw.php');

?>

<?php 
include_once('classes/class.schueler_satz.php');
include_once('classes/class.schueler.php');
include_once('classes/class.status.php');
include_once("classes/class.satz.php"); 
include_once("classes/class.htmlinfo.php"); 

$option=$_REQUEST["option"]; 

$html= new HTML_Info(); 

$ID=null; 
$SatzID=null;
$SchuelerID=null; 
$StatusID=''; 
$DatumVon=null; 
$DatumBis=null; 
$Bemerkung=''; 

$nurAktiv=true; // In Auswahlliste Schüler nur schueler.Aktiv=1 anzeigen 

switch($option) {

  case 'insert': // aus "edit_satz_schuelers.php" > "Hinzufügen"
    $SatzID= $_REQUEST["SatzID"]; 
    $option='update1';  

  break;

  case 'edit': // aus "edit_satz_schuelers.php" > "Bearbeiten"
    $ID = $_REQUEST["ID"]; 
    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID=$ID; 
    $schueler_satz->load_row(); 
    $SatzID=$schueler_satz->SatzID; 
    $SchuelerID=$schueler_satz->SchuelerID; 
    $StatusID=$schueler_satz->StatusID;     
    $DatumVon=$schueler_satz->DatumVon; 
    $DatumBis=$schueler_satz->DatumBis;
    $Bemerkung=$schueler_satz->Bemerkung;   
    $option='update2'; 
    $nurAktiv=false;     

  break; 


  case "delete_1": 
    $ID = $_REQUEST["ID"]; 
    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID=$ID; 
    $schueler_satz->load_row(); 
    $SatzID=$schueler_satz->SatzID; 
    $SchuelerID=$schueler_satz->SchuelerID; 
    $StatusID=$schueler_satz->StatusID;        
    $DatumVon=$schueler_satz->DatumVon; 
    $DatumBis=$schueler_satz->DatumBis;  
    $Bemerkung=$schueler_satz->Bemerkung;   
    
    $option='delete_2'; 
    $nurAktiv=false;

  break; 

  case 'delete_2': 
    $ID = $_REQUEST["ID"]; 
    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID=$ID; 
    $schueler_satz->load_row(); 
    $SatzID= $schueler_satz->SatzID; 
    $schueler_satz->delete(); 
        
    header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

    exit;

    break;

  case 'update1':   // insert new row 
    $SatzID= $_POST["SatzID"]; 
    $SchuelerID= $_POST["SchuelerID"];    
    $StatusID= $_POST["StatusID"];         
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     
    $Bemerkung= $_POST["Bemerkung"];     

    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
    header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

    exit;
    break;

  case 'update2':   // update existing row 
    $ID = $_POST["ID"];    
    $SatzID= $_POST["SatzID"]; 
    $SchuelerID= $_POST["SchuelerID"];    
    $StatusID= $_POST["StatusID"];        
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     
    $Bemerkung= $_POST["Bemerkung"];  

    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID = $ID; 
    $schueler_satz->update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
    header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

    exit;

  break;

}

include_once('head_raw.php');

if ($option=='delete_2') {
  $html->print_form_confirm('edit_satz_schueler.php', $ID,$option,'Löschung'); 
}
?> 
<form action="#" method="POST">
<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Schüler: </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $schueler = new Schueler(); 
      $schueler->Ref='Satz'; 
      $schueler->print_select($SchuelerID,$SatzID, '', $nurAktiv);       
      $html->print_link_edit('schueler',$SchuelerID,true);   
      $html->print_link_table('v_schueler','sortcol=Name',$schueler->Titles,true,'');    
      $html->print_link_insert($schueler->table_name,$schueler->Title,true);
    ?>
  </td>
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1">Status:</td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $status = new Status(); 
      $status->print_select($StatusID);       
      $html->print_link_edit($status->table_name,$StatusID,true);         
      $html->print_link_table($status->table_name,'sortcol=Name',$status->Titles,true,'');    
      $html->print_link_insert($status->table_name,$status->Title,true);
    ?>
  </td>
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


<tr>    
  <td class="eingabe2 eingabe2_1">Datum von: </td>  
  <td class="eingabe2 eingabe2_2"> <input type="date" name="DatumVon" value="<?php echo $DatumVon ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>    
  <td class="eingabe2 eingabe2_1">Datum bis: </td>    
  <td class="eingabe2 eingabe2_2"> <input type="date" name="DatumBis" value="<?php echo $DatumBis ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>    
  <td class="eingabe2 eingabe2_1">Bemerkung: </td>    
  <td class="eingabe2 eingabe2_2"><input type="text" name="Bemerkung" size="70" value="<?php echo $Bemerkung ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>
  <td class="eingabe2 eingabe2_1"></td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"><?php $html->print_link_backToList('edit_satz_schuelers.php?SatzID='.$SatzID); ?></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

 <input type="hidden" name="ID" value="<?php echo $ID; ?>"> 
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="option" value="<?php echo $option; ?>">

</form>


<tr>    
  <td class="eingabe2 eingabe2_1"></td>    
  <td class="eingabe2 eingabe2_2">
      <form action="#" method="post">
      <input type="hidden" name="ID" value="<?php echo $ID; ?>">
      <input type="hidden" name="option" value="delete_1">      
      <input type="submit" name="senden" value="Löschen">             
      </form>
  </td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

</table>

<?php 

include_once('foot_raw.php');

?>

<?php 
include_once('classes/class.schueler_satz.php');
include_once('classes/class.schueler.php');
include_once("classes/class.satz.php"); 
include_once("classes/class.status.php"); 
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


switch($option) {

  case 'edit': // aus "edit_schueler_saetze.php" > "Bearbeiten"
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
    if($schueler_satz->is_deletable()) {
      $html->print_form_delete_confirm(basename(__FILE__), 'Verknüpfung', $schueler_satz->ID, '');   
    }     
      
        
     break; 

  case 'delete_2': // after confirm 
    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID= $_REQUEST["ID"]; 
    $schueler_satz->load_row(); 
    $SchuelerID= $schueler_satz->SchuelerID; 
    $schueler_satz->delete(); 
          
    header('Location: edit_schueler_saetze.php?SchuelerID='.$SchuelerID);
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
    
    header('Location: edit_schueler_saetze.php?SchuelerID='.$SchuelerID);
    exit;

  break;

}

include_once('head_raw.php');

?> 

<form action="" method="post">
<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Satz:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 

    $satz=new Satz(); 
    $satz->ID = $SatzID; 
    echo $satz->getInfo(); 

      ?>
  </td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      $html->print_link_edit('satz', $satz->ID, $satz->Title, true); 
    ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1">Status:</td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $status = new Status(); 
      $status ->print_select($StatusID);       

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
  <td class="eingabe2 eingabe2_1">Bemerkung:</td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Bemerkung" value="<?php echo htmlentities($Bemerkung); ?>" size="70" oninput="changeBackgroundColor(this)">
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> 
  </td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
    <?php
      $html->print_link_backToList('edit_schueler_saetze.php?SchuelerID='.$SchuelerID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


<input type="hidden" name="ID" value="<?php echo $ID; ?>">  
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="SchuelerID" value="<?php echo $SchuelerID; ?>">  
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

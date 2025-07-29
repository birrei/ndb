<?php 
include('classes/class.schueler_material.php');
include('classes/class.schueler.php');
include('classes/class.status.php');
include("classes/class.material.php"); 
include("cl_html_info.php"); 

$option=$_REQUEST["option"]; 

$html= new HtmlInfo(); 

$ID=null; 
$MaterialID=null;
$SchuelerID=null; 
$StatusID=''; 
$DatumVon=null; 
$DatumBis=null; 
$Bemerkung=''; 
$nurAktiv=true; // In Auswahlliste Schüler nur schueler.Aktiv=1 anzeigen 

switch($option) {

  case 'insert': // aus "edit_material_schuelers.php" > "Hinzufügen"
    $MaterialID= $_REQUEST["MaterialID"]; 
    $option='update1';  

    break;

  case 'edit': // aus "edit_material_schuelers.php" > "Bearbeiten"
    $ID = $_REQUEST["ID"]; 
    $schueler_material=new SchuelerMaterial(); 
    $schueler_material->ID=$ID; 
    $schueler_material->load_row(); 
    $MaterialID=$schueler_material->MaterialID; 
    $SchuelerID=$schueler_material->SchuelerID; 
    $StatusID=$schueler_material->StatusID;     
    $DatumVon=$schueler_material->DatumVon; 
    $DatumBis=$schueler_material->DatumBis;
    $Bemerkung=$schueler_material->Bemerkung;   
    $option='update2'; 
    $nurAktiv=false;  

    break; 


  case 'update1':   // insert new row 
    $MaterialID= $_POST["MaterialID"]; 
    $SchuelerID= $_POST["SchuelerID"];    
    $StatusID= $_POST["StatusID"];         
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     
    $Bemerkung= $_POST["Bemerkung"];     

    $schueler_material=new SchuelerMaterial(); 
    $schueler_material->update_row($SchuelerID, $MaterialID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
    header('Location: edit_material_schuelers.php?MaterialID='.$MaterialID);
    exit;

    break; 

  case 'update2':   // update existing row 
    $ID = $_POST["ID"];    
    $MaterialID= $_POST["MaterialID"]; 
    $SchuelerID= $_POST["SchuelerID"];    
    $StatusID= $_POST["StatusID"];        
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     
    $Bemerkung= $_POST["Bemerkung"];  

    $schueler_material=new SchuelerMaterial(); 
    $schueler_material->ID = $ID; 
    $schueler_material->update_row($SchuelerID, $MaterialID, $DatumVon, $DatumBis, $Bemerkung, $StatusID); 
    
    header('Location: edit_material_schuelers.php?MaterialID='.$MaterialID);
    exit;

    break;  

  case "delete_1": 
    $ID = $_REQUEST["ID"]; 
    $schueler_material=new SchuelerMaterial(); 
    $schueler_material->ID=$ID; 
    $schueler_material->load_row(); 
    $MaterialID=$schueler_material->MaterialID; 
    $SchuelerID=$schueler_material->SchuelerID; 
    $StatusID=$schueler_material->StatusID;        
    $DatumVon=$schueler_material->DatumVon; 
    $DatumBis=$schueler_material->DatumBis;  
    $Bemerkung=$schueler_material->Bemerkung;   
    
    $option='delete_2'; 
    $nurAktiv=false;  
    
    break; 

  case 'delete_2': 
    $ID = $_REQUEST["ID"]; 
    $schueler_material=new SchuelerMaterial(); 
    $schueler_material->ID=$ID; 
    $schueler_material->load_row(); 
    $MaterialID= $schueler_material->MaterialID; 
    $schueler_material->delete(); 
        
    header('Location: edit_material_schuelers.php?MaterialID='.$MaterialID);
    exit;

    break;
}
include('head_raw.php');

if ($option=='delete_2') {
  $html->print_form_confirm('edit_material_schueler.php', $ID,$option,'Löschung'); 
}

?> 
<form action="#" method="post">
<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Schüler:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $schueler = new Schueler(); 
      $schueler->Ref='Material'; 
      // $schueler ->print_select('',$SchuelerID); 
      $schueler->print_select($SchuelerID,$MaterialID);      
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
  <td class="eingabe2 eingabe2_2">
    <?php
      $html->print_link_backToList('edit_material_schuelers.php?MaterialID='.$MaterialID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

 <input type="hidden" name="ID" value="<?php echo $ID; ?>"> 
 <input type="hidden" name="MaterialID" value="<?php echo $MaterialID; ?>"> 
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

include('foot_raw.php');

?>

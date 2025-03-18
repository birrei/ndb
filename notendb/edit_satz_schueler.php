
<?php 
include('head_raw.php');
include('cl_schueler_satz.php');
include('cl_schueler.php');
include("cl_satz.php"); 
include("cl_html_info.php"); 


$option=$_REQUEST["option"]; 

$html= new HtmlInfo(); 

$ID=null; 
$SatzID=null;
$SchuelerID=null; 
$DatumVon=null; 
$DatumBis=null; 

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
    $DatumVon=$schueler_satz->DatumVon; 
    $DatumBis=$schueler_satz->DatumBis;  
    $option='update2'; 

  break; 


  case "delete": 
    $ID = $_REQUEST["ID"]; 
    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID=$ID; 
    $schueler_satz->load_row(); 
    $SatzID=$schueler_satz->SatzID; 
    $SchuelerID=$schueler_satz->SchuelerID; 
    $DatumVon=$schueler_satz->DatumVon; 
    $DatumBis=$schueler_satz->DatumBis;  

    $option='delete_2'; 

    $html->print_form_confirm('edit_satz_schueler.php', $ID,$option,'Löschung'); 


  break; 

  case 'delete_2': 
    $ID = $_REQUEST["ID"]; 
    $SatzID = $_REQUEST["SatzID"];     
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
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     

    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->update($SchuelerID, $SatzID, $DatumVon, $DatumBis); 
    
    header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

    exit;

  case 'update2':   // update existing row 
    $ID = $_POST["ID"];    
    $SatzID= $_POST["SatzID"]; 
    $SchuelerID= $_POST["SchuelerID"];     
    $DatumVon= $_POST["DatumVon"];     
    $DatumBis= $_POST["DatumBis"];     

    $schueler_satz=new SchuelerSatz(); 
    $schueler_satz->ID = $ID; 
    $schueler_satz->update($SchuelerID, $SatzID, $DatumVon, $DatumBis); 
    
    header('Location: edit_satz_schuelers.php?SatzID='.$SatzID);

    exit;

  break;

}


?> 

<form action="edit_satz_schueler.php" method="POST">
<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Schüler:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $schueler = new Schueler(); 
      $schueler->Ref='Satz'; 
      $schueler ->print_select($SchuelerID,$SatzID);       
      ?>
  <?php 
      $html->option_linktext=1; 
      $html->print_link_table('v_schueler','sortcol=Name',$schueler->Titles,true,'');    
      $html->print_link_insert($schueler->table_name,$schueler->Title,true);

    ?>
  </td>
  <td class="eingabe2 eingabe2_3">

  </td>    
</tr>

<tr>    
  <td class="form-edit form-edit-col2">Datum von: </td>
  <td class="eingabe2 eingabe2_1"> <input type="date" name="DatumVon" value="<?php echo $DatumVon ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>    
  <td class="form-edit form-edit-col2">Datum bis: </td>
  <td class="eingabe2 eingabe2_1"> <input type="date" name="DatumBis" value="<?php echo $DatumBis ?>" oninput="changeBackgroundColor(this)"></td>
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
      $html->print_link_backToList('edit_satz_schuelers.php?SatzID='.$SatzID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 
 <input type="hidden" name="ID" value="<?php echo $ID; ?>"> 
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="option" value="<?php echo $option; ?>">

</form>



<?php 

include('foot_raw.php');

?>

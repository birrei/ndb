
<?php 
include('head_raw.php');
include('cl_schueler_satz.php');
include('cl_schueler.php');
include("cl_satz.php"); 

include("cl_html_info.php"); 

/** Unter-Formular Typ update only 
 *  option immer gesetzt 
 *  schueler_satz.ID immer vorhanden 
 * 
*/


$info= new HtmlInfo(); 

$schuelersatz = new SchuelerSatz();
$schuelersatz->ID=$_REQUEST["ID"];
$schuelersatz->load_row(); 
$show_data=true;       
$satz=new Satz(); 
$satz->ID = $schuelersatz->SatzID; 
$satz->load_row(); 
include_once("cl_musikstueck.php"); 
$musikstueck =new Musikstueck(); 
$musikstueck->ID = $satz->MusikstueckID; 
$musikstueck->load_row(); 
include_once("cl_sammlung.php"); 
$sammlung =new Sammlung(); 
$sammlung->ID = $musikstueck->SammlungID; 
$sammlung->load_row();     


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {

    case 'update': 
      $schuelersatz->update_row(
        $_POST["SatzID"],        
        $_POST["SchuelerID"],
        $_POST["Bemerkung"]
        );   
        
      }
    
  }

?> 

<form action="" method="post">

<table class="eingabe2">

<tr>
  <td class="eingabe2 eingabe2_1">Satz:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
    echo $sammlung->Name.'<br>'; 
    echo $musikstueck->Nummer. ' '. $musikstueck->Name. ' ' .$satz->Nr. ' '. $satz->Name;
  
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      $info->option_linktext=1; 
      $info->print_link_edit('satz', $satz->ID, $satz->Title, true); 
    ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1">Bemerkung:</td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Bemerkung" value="<?php echo htmlentities($schuelersatz->Bemerkung); ?>" size="70" oninput="changeBackgroundColor(this)">
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
      $info->print_link_backToList('edit_schueler_saetze.php?SchuelerID='.$schuelersatz->SchuelerID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="ID" value="<?php echo $schuelersatz->ID; ?>">  
 <input type="hidden" name="SatzID" value="<?php echo $schuelersatz->SatzID; ?>"> 
 <input type="hidden" name="SchuelerID" value="<?php echo $schuelersatz->SchuelerID; ?>">  
 <input type="hidden" name="option" value="update">

</form>



<?php 

include('foot_raw.php');

?>

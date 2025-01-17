
<?php 
include('head_raw.php');
include('cl_schueler_satz.php');
include('cl_schueler.php');
include("cl_satz.php"); 
include("cl_html_info.php"); 


$schuelersatz = new SchuelerSatz();
// $schuelersatz->SatzID = $_GET["SatzID"]; 

$info= new HtmlInfo(); 

$show_data=false; // Formular enthält Daten (nach AUfruf eines Datensatzes) oder nicht (wenn option=insert, also noch neu )

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schuelersatz->ID=$_GET["ID"];
      if ($schuelersatz->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert':       
      $schuelersatz->SatzID = $_GET["SatzID"];         
      break; 
    
    case 'update': 
      $show_data=true;  
      if ($_POST["ID"]=='') {
          // einfügen/updaten 
          $schuelersatz->SatzID = $_REQUEST["SatzID"];         
          $schuelersatz->insert_row();   
          $schuelersatz->update_row(
            $_POST["SatzID"],        
            $_POST["SchuelerID"],
            $_POST["Bemerkung"]
          );          
        }
        else {
          // updaten 
          $schuelersatz->ID = $_REQUEST["ID"];  
          $schuelersatz->update_row(
            $_POST["SatzID"],        
            $_POST["SchuelerID"],
            $_POST["Bemerkung"]
          );         

        }
      break; 
  }
}

?> 

<form action="" method="post">

<table class="eingabe2">

<tr>
  <td class="eingabe2 eingabe2_1">Schüler:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $schueler = new Schueler(); 
      if ( $show_data) {
        $schueler ->print_select($schuelersatz->SchuelerID); // datensatz geöffnet 
      } else {
        $schueler ->print_select('',$_GET["SatzID"]); // (noch) ohne Datensatz 
      }
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      $info->option_linktext=1; 
      $info->print_link_table('schueler','sortcol=Name','Schüler',true,'');  
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
      $info->print_link_backToList('edit_satz_schuelers.php?SatzID='.$schuelersatz->SatzID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="SatzID" value="<?php echo $schuelersatz->SatzID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $schuelersatz->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>



<?php 

include('foot_raw.php');

?>

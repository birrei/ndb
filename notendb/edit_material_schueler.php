
<?php 
include('head_raw.php');
include('cl_schueler_material.php');
include('cl_schueler.php');
include("cl_material.php"); 
include("cl_html_info.php"); 

$schuelermaterial = new SchuelerMaterial();

$info= new HtmlInfo(); 

$show_data=false;

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schuelermaterial->ID=$_GET["ID"];
      if ($schuelermaterial->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert':       
      $schuelermaterial->MaterialID = $_GET["MaterialID"];         
      break; 
    
    case 'update': 
      $show_data=true;  
      if ($_POST["ID"]=='') {
          // einfügen/updaten 
          $schuelermaterial->MaterialID = $_REQUEST["MaterialID"];         
          $schuelermaterial->insert_row();   
          $schuelermaterial->update_row(
            $_POST["MaterialID"],        
            $_POST["SchuelerID"],
            $_POST["Bemerkung"]
          );          
        }
        else {
          // updaten 
          $schuelermaterial->ID = $_REQUEST["ID"];  
          $schuelermaterial->update_row(
            $_POST["MaterialID"],        
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
      $schueler->Ref='Material'; 
      if ( $show_data) {
        $schueler ->print_select($schuelermaterial->SchuelerID); // datenmaterial geöffnet 
      } else {
        $schueler ->print_select('',$_GET["MaterialID"]); // (noch) ohne Datenmaterial 
      }
      ?>
    <?php 
      $info->option_linktext=1; 
      
      $info->print_link_edit($schueler->table_name, $schuelermaterial->SchuelerID,$schueler->Title, true); 
      $info->print_link_table($schueler->table_name,'sortcol=Name',$schueler->Titles,true,'');    
      $info->print_link_insert($schueler->table_name,$schueler->Title,true);

    ?>      
  </td>  


<tr>
  <td class="eingabe2 eingabe2_1">Bemerkung:</td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Bemerkung" value="<?php echo htmlentities($schuelermaterial->Bemerkung); ?>" size="100" oninput="changeBackgroundColor(this)">
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
      $info->print_link_backToList('edit_material_schuelers.php?MaterialID='.$schuelermaterial->MaterialID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="MaterialID" value="<?php echo $schuelermaterial->MaterialID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $schuelermaterial->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>



<?php 

include('foot_raw.php');

?>

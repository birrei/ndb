
<?php 
include('head_raw.php');
include('cl_schueler_material.php');
include('cl_schueler.php');
include("cl_material.php"); 

include("cl_html_info.php"); 


$schuelermaterial = new SchuelerMaterial();
$schuelermaterial->Parent = 'Schueler'; 


$info= new HtmlInfo(); 

$ID=''; 
$SchuelerID='';
$MaterialID=''; 

$show_data=false; // konzept nicht weiterverfolgen XXX 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schuelermaterial->ID=$_GET["ID"];
      $schuelermaterial->load_row(); 
      $ID= $schuelermaterial->ID; 

      break; 

    case 'insert': // Quelle "Hinzufügen" (ohne aktive Anlage)
      $schuelermaterial->SchuelerID= $_GET["SchuelerID"];           
      break; 
    
    case 'update': 
      $show_data=true;  
      if ($_POST["ID"]=='') {      
        $schuelermaterial->insert_row($_REQUEST["SchuelerID"]);           
      }
       else {
        $schuelermaterial->ID  = $_REQUEST["ID"];  
      }
      $schuelermaterial->update_row(
        $_POST["SchuelerID"],
        $_POST["MaterialID"],        
        $_POST["Bemerkung"]   
        );
      break; 
  }
}


?> 

<form action="" method="post">

<table class="eingabe2">

<tr>
  <td class="eingabe2 eingabe2_1">Material:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      
      $material = new Material(); 
      $material->ID= $schuelermaterial->MaterialID; 

      if ( $_REQUEST["option"] =='insert') {
        $material ->print_select('',$_GET["SchuelerID"]); //         
      } else {
        $material ->print_select($schuelermaterial->MaterialID, $schuelermaterial->SchuelerID); // 
      }
     
      // $info->print_link_edit('material', $schuelermaterial->MaterialID, $material->Title, true); 

      $info->print_link_edit($material->table_name, $schuelermaterial->MaterialID,$material->Title, true); 
      $info->print_link_table('v_material','sortcol=Name',$material->Titles,true,'');    
      $info->print_link_insert($material->table_name,$material->Title,true);

      
    ?>
  </td>  

</tr>

<tr>
  <td class="eingabe2 eingabe2_1">Bemerkung:</td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Bemerkung" value="<?php echo htmlentities($schuelermaterial->Bemerkung); ?>" size="70" oninput="changeBackgroundColor(this)">
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
      $info->print_link_backToList('edit_schueler_materials.php?SchuelerID='.$schuelermaterial->SchuelerID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="ID" value="<?php echo $schuelermaterial->ID;; ?>">  
 <input type="hidden" name="SchuelerID" value="<?php echo $schuelermaterial->SchuelerID; ?>">  
 <input type="hidden" name="option" value="update">

</form>



<?php 

include('foot_raw.php');

?>

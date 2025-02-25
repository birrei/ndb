
<?php 
include('head_raw.php');
include('cl_schueler_material.php');
include('cl_schueler.php');
include("cl_material.php"); 

include("cl_html_info.php"); 


$schueler = new Schueler(); 
$schueler->ID=$_GET["SchuelerID"]; 

$info= new HtmlInfo(); 


// if (isset($_REQUEST["option"])) {
//   switch($_REQUEST["option"]) {
//     case 'edit': // über "Bearbeiten"-Link
//       $schuelermaterial->ID=$_GET["ID"];
//       $schuelermaterial->load_row(); 
//       $ID= $schuelermaterial->ID; 

//       break; 

//     case 'insert': // Quelle "Hinzufügen" (ohne aktive Anlage)
//       $schuelermaterial->SchuelerID= $_GET["SchuelerID"];           
//       break; 
    
//     case 'update': 
//       $show_data=true;  
//       if ($_POST["ID"]=='') {      
//         $schuelermaterial->insert_row($_REQUEST["SchuelerID"]);           
//       }
//        else {
//         $schuelermaterial->ID  = $_REQUEST["ID"];  
//       }
//       $schuelermaterial->update_row(
//         $_POST["SchuelerID"],
//         $_POST["MaterialID"],        
//         $_POST["Bemerkung"]   
//         );
//       break; 
//   }
// }


?> 

<form action="edit_schueler_materials.php" method="get">

<table class="eingabe2">

<tr>
  <td class="eingabe2 eingabe2_1">Material:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      
      $material = new Material(); 
      $material ->print_select('',$_GET["SchuelerID"]); //     

      // if ( $_REQUEST["option"] =='insert') {
    
      // } else {
      //   $material ->print_select($schuelermaterial->MaterialID, $schuelermaterial->SchuelerID); // 
      // }
     
      // $info->print_link_edit('material', $schuelermaterial->MaterialID, $material->Title, true); 

      // $info->print_link_edit($material->table_name, $schuelermaterial->MaterialID,$material->Title, true); 
      $info->print_link_table('v_material','sortcol=Name',$material->Titles,true,'');    
      $info->print_link_insert($material->table_name,$material->Title,true);

      
    ?>
  </td>  

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
      $info->print_link_backToList('edit_schueler_materials.php?SchuelerID='.$schueler->ID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 
 
 <input type="hidden" name="SchuelerID" value="<?php echo $schueler->ID; ?>">  
 <input type="hidden" name="option" value="insert">

</form>



<?php 

include('foot_raw.php');

?>

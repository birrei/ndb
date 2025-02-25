
<?php 
include('head_raw.php');
include('cl_schueler_material.php');
include('cl_schueler.php');
include("cl_material.php"); 
include("cl_html_info.php"); 


$material = new Material(); 
$material->ID= $_GET["MaterialID"]; 

$info= new HtmlInfo(); 

?> 

<form action="edit_material_schuelers.php" method="get">

<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Schüler:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 

      $schueler = new Schueler(); 
      $schueler->Ref='Material'; 
      $schueler ->print_select('',$_GET["MaterialID"]); 

      ?>
    <?php 
      $info->option_linktext=1; 
      
      // $info->print_link_edit($schueler->table_name, $schuelermaterial->SchuelerID,$schueler->Title, true); 
      $info->print_link_table($schueler->table_name,'sortcol=Name',$schueler->Titles,true,'');    
      $info->print_link_insert($schueler->table_name,$schueler->Title,true);

    ?>      
  </td>  

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
        $info->print_link_backToList('edit_material_schuelers.php?MaterialID='.$material->ID); 
      ?>
    </td>  
    <td class="eingabe2 eingabe2_3"></td>    
  </tr>
</table>

 </table> 

 <input type="hidden" name="MaterialID" value="<?php echo $material->ID; ?>"> 
 <input type="hidden" name="option" value="insert">

</form>



<?php 

include('foot_raw.php');

?>

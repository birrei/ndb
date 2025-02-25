
<?php 
include('head_raw.php');
// include('cl_schueler_satz.php');
include('cl_schueler.php');
include("cl_satz.php"); 
include("cl_html_info.php"); 


$satz= new Satz(); 
$satz->ID=$_GET["SatzID"]; 

$info= new HtmlInfo(); 

?> 

<form action="edit_satz_schuelers.php" method="get">

<table class="eingabe2">

<tr>
  <td class="eingabe2 eingabe2_1">Schüler:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $schueler = new Schueler(); 
      $schueler->Ref='Satz'; 
      $schueler ->print_select('',$_GET["SatzID"]); 
      ?>

  <?php 
      $info->option_linktext=1; 
      $info->print_link_table($schueler->table_name,'sortcol=Name',$schueler->Titles,true,'');    
      $info->print_link_insert($schueler->table_name,$schueler->Title,true);

    ?>
  </td>
  <td class="eingabe2 eingabe2_3">

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
      $info->print_link_backToList('edit_satz_schuelers.php?SatzID='.$satz->ID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="SatzID" value="<?php echo $satz->ID; ?>"> 
 <input type="hidden" name="option" value="insert">

</form>



<?php 

include('foot_raw.php');

?>

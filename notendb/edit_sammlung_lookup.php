
<?php 
include('head_raw.php');
include('classes/class.lookuptype.php');
include("cl_html_info.php"); 

$info = new HtmlInfo(); 

$LookupTypeID=''; 

if (isset($_POST["LookupTypeID"])) {
  $LookupTypeID= $_POST["LookupTypeID"]; 
}
?> 
<table class="eingabe2">
<form action="" method="post">

<!----------------  Zeile 1 ------------------------->
<tr>
  <td class="eingabe2 eingabe2_1"><i>Typ (Filter):</i></td>
  <td class="eingabe2 eingabe2_2">    
    <?php                 
    $lookuptyp = new Lookuptype(); 
    $lookuptyp->Relation = 'sammlung'; 
    $lookuptyp->print_preselect($LookupTypeID); 
    if ($LookupTypeID!='') { 
      $info->print_link_edit('lookup_type',$LookupTypeID,'Besonderheit-Typ',true); 
    }
    ?>
    </td>  

    <td class="eingabe2 eingabe2_3"> 
    <?php 
 
    // $info->option_linktext=1; 
    $info->print_link_table('lookup_type','sortcol=Name','Besonderheit-Typen',true,''); ;  
    ?>    
    </td>
</tr>
<input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
</form>

<form action="edit_sammlung_lookups.php" method="get">

<tr>
  <td class="eingabe2 eingabe2_1">Besonderheit:</td>
  <td class="eingabe2 eingabe2_2">
  <?php 
          include_once("classes/class.lookup.php");         
          $lookup = new Lookup(); 
          $lookup->LookupTypeRelation='sammlung';
          if ($LookupTypeID!='') {  
            $lookup->print_select2($LookupTypeID, $_GET["SammlungID"]); 
          } else {
            $lookup->print_select('',  $_GET["SammlungID"]); 
          }
    ?>
  </td>
  
  <td class="eingabe2 eingabe2_3"> 
    <?php 
     // $info->option_linktext=1;         
    $info->print_link_table('v_lookup','sortcol=Name','Besonderheiten',true,'&show_filter');  
    ?>    
    </td>  
</tr>


<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
  <?php
    $info->print_link_reload();  
  ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>  

</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
  <?php
    $info->print_link_backToList('edit_sammlung_lookups.php?SammlungID='.$_GET["SammlungID"]);       
  ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>  

</tr>

<input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>


</table> 





<?php
include('foot_raw.php');

?>

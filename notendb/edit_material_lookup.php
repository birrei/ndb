
<?php 
include_once('head_raw.php');
include_once('classes/class.lookuptype.php');
include_once("classes/class.htmlinfo.php"); 
include_once("classes/class.lookup.php");    

$info = new HTML_Info(); 

$MaterialID=$_GET["MaterialID"]; 

$LookupTypeID=isset($_REQUEST["LookupTypeID"])?$_REQUEST["LookupTypeID"]:'';

?> 
<table class="eingabe2">
<form action="" method="post">

<!----------------  Zeile 1 ------------------------->
<tr>
  <td class="eingabe2 eingabe2_1"><i>Typ (Filter):</i></td>
  <td class="eingabe2 eingabe2_2">    
    <?php                 
    $lookuptyp = new Lookuptype(); 
    $lookuptyp->Relation = 'material'; 
    $lookuptyp->print_preselect($LookupTypeID); 
    if ($LookupTypeID!='') { 
      $info->print_link_edit('lookup_type',$LookupTypeID,'Besonderheit-Typ',true); 
    }
    ?>
    </td>  

    <td class="eingabe2 eingabe2_3"> 
    <?php 
    $info->print_link_table('v_lookup_type','sortcol=Name','Besonderheit-Typen',true,''); ;  
    ?>    
    </td>
</tr>
<input type="hidden" name="MaterialID" value="<?php echo $MaterialID; ?>"> 
</form>

<form action="edit_material_lookups.php" method="get">
<tr>
  <td class="eingabe2 eingabe2_1">Besonderheit:</td>
  <td class="eingabe2 eingabe2_2">
  <?php 
      $lookup = new Lookup(); 
      $lookup->LookupTypeRelation='material';
      $lookup->LookupTypeID=$LookupTypeID; 
      $lookup->ReferenceID=$MaterialID; 
      $lookup->print_select(); 

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



<input type="hidden" name="MaterialID" value="<?php echo $MaterialID; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>


</table> 





<?php
include_once('foot_raw.php');

?>


<?php 
include_once('head_raw.php');
include_once('classes/class.lookuptype.php');
include_once("classes/class.htmlinfo.php"); 
include_once("classes/class.lookup.php");     

$info = new HTML_Info(); 

$SchuelerID=$_GET["SchuelerID"]; 

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
    $lookuptyp->Relation = 'schueler'; 
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
<input type="hidden" name="SchuelerID" value="<?php echo $_GET["SchuelerID"]; ?>"> 
</form>

<form action="edit_schueler_lookups.php" method="get">

<!----------------  Zeile 2 ------------------------->
<tr>
  <td class="eingabe2 eingabe2_1">Besonderheit:</td>
  <td class="eingabe2 eingabe2_2">
  <?php 
      $lookup = new Lookup(); 
      $lookup->LookupTypeRelation='schueler';
      $lookup->LookupTypeID=$LookupTypeID; 
      $lookup->ReferenceID=$SchuelerID; 
      $lookup->print_select(); 
    ?>
  </td>
  
  <td class="eingabe2 eingabe2_3"> 
    <?php 
      $info->print_link_table2('besonderheiten', true);     
    ?>    
    </td>  
</tr>

<!----------------  Zeile 3 ------------------------->


<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>



<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
  <?php  
    // $info->print_link_backToList('edit_schueler_lookups.php?SchuelerID='.$_GET["SchuelerID"]);       
  ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>  

</tr>


<input type="hidden" name="SchuelerID" value="<?php echo $_GET["SchuelerID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>


</table> 





<?php
include_once('foot_raw.php');

?>

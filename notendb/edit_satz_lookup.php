
<?php 
include_once('head_raw.php');
include_once('classes/class.lookuptype.php');
include_once("classes/class.htmlinfo.php"); 

$info = new HTML_Info(); 

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
    $lookuptyp->Relation = 'satz'; 
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
<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
</form>

<form action="edit_satz_lookups.php" method="get">

<!----------------  Zeile 2 ------------------------->
<tr>
  <td class="eingabe2 eingabe2_1">Besonderheit:</td>
  <td class="eingabe2 eingabe2_2">
  <?php 
          include_once("classes/class.lookup.php");         
          $lookup = new Lookup(); 
          $lookup->LookupTypeRelation='satz';
          if ($LookupTypeID!='') {  
            $lookup->print_select2($LookupTypeID, $_GET["SatzID"]); 
          } else {
            $lookup->print_select('',  $_GET["SatzID"]); 
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

<!----------------  Zeile 2 ------------------------->


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
    $info->print_link_backToList('edit_satz_lookups.php?SatzID='.$_GET["SatzID"]);       
  ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>  

</tr>


<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>


</table> 





<?php
include_once('foot_raw.php');

?>

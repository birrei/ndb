
<?php 
include('head_raw.php');
include('cl_lookuptype.php');
include("cl_html_info.php"); 

$info = new HtmlInfo(); 

$LookupTypeID=''; 

if (isset($_POST["LookupTypeID"])) {
  $LookupTypeID= $_POST["LookupTypeID"]; 
}
?> 

<!-- 2 Formulare: Die Auswahl im ersten Formular bewirkt das Neu-Laden der Seite --> 
<table class="eingabe2">
<form action="" method="post">
<tr>
  <td class="eingabe2"><i>Typ:</i></td>
  <td class="eingabe2">    
    <?php                 
    $lookuptyp = new Lookuptype(); 
    $lookuptyp->Relation = 'satz'; 
    $lookuptyp->print_preselect($LookupTypeID); 
    if ($LookupTypeID!='') { 
      $info->print_link_edit('lookup_type',$LookupTypeID,'Besonderheit-Typ',true); 
    }
    ?>
    </td>  
</tr>
<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 

</form>

<form action="edit_satz_lookups.php" method="get">
<tr>
  <td class="eingabe2"> Besonderheit: </td>
  <td class="eingabe2">
  <?php 
          include_once("cl_lookup.php");         
          $lookup = new Lookup(); 
          $lookup->LookupTypeRelation='satz';
          if ($LookupTypeID!='') {  
            $lookup->print_select2($LookupTypeID, $_GET["SatzID"]); // XXX 

          } else {
            $lookup->print_select('',  $_GET["SatzID"]); 
          }
    ?>
  </td>  
</tr>

<tr>
  <td class="eingabe2"></td>
  <td class="eingabe2"><input class="btnSave" type="submit" value="Speichern"></td>  
</tr>

<tr>
  <td class="eingabe2"></td>
  <td class="eingabe2"><br />
  <?php

  $info->option_linktext=1; 
  $info->print_link_table('lookup_type','sortcol=Name','Besonderheit-Typen',true,'');     

  ?>    
    <td>  
</tr>


<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>


</table> 


<?php


   

include('foot_raw.php');

?>


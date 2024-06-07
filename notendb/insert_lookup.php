
<?php 
include('head.php');

include('cl_lookuptype.php');

$LookupTypeID=''; 

if (isset($_POST["LookupTypeID"])) {
  $LookupTypeID= $_POST["LookupTypeID"]; 
}


?> 
<h1>Besonderheit erfassen</h1> 

<form action="" method="post">
<table class="eingabe">
<tr>    
  <label>
  <td class="eingabe">Typ: </td>      
     <td class="eingabe"><?php 
                  
      $lookuptyp = new Lookuptype(); 
      $lookuptyp->print_preselect($LookupTypeID); 

      ?>
        (Auswahl filtert Übersichtstabelle)</td>
   </label>
</tr>
</form>


<form action="edit_lookup.php" method="get">
  <tr>    
    <label>
    <td class="eingabe">Name: </td>  
    <td class="eingabe"><input type="text" name="Name" size="100" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
  </tr> 
  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
  </tr>
</table> 
<input type="hidden" name="option" value="insert">
<input type="hidden" name="title" value="Besonderheit"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
</form>
<hr />
<?php
include_once('cl_lookup.php');
$lookup=new Lookup(); 
$lookup->print_table($LookupTypeID);   


include('foot.php');

?>

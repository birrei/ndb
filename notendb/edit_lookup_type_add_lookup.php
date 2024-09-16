
<?php 
include('head_raw.php');
?>

<form action="edit_lookup_type_list_lookups.php" method="get">
<table class="eingabe"> 
    
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="insert">
<input type="hidden" name="title" value="Besonderheit">       
<input type="hidden" name="LookupTypeID" value="<?php echo $_GET["LookupTypeID"]; ?>">

</form>


<?php 

include('foot_raw.php');

?>


<?php 
include('head_raw.php');
?>

<form action="edit_lookup_type_list_lookups.php" method="get">
<table class="form-edit"> 
    
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

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

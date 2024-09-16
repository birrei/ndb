
<?php 
include('head_raw.php');
?> 
<form action="edit_musikstueck_list_verwendungszwecke.php" method="get">
<table class="eingabe"> 
   <tr>    
    <label>
    <td class="eingabe">
        <?php 
          include_once("cl_verwendungszweck.php");
          $verwendungszweck = new Verwendungszweck(); 
          $verwendungszweck->print_select('',$_GET["MusikstueckID"]); 
         ?>
    </td>
    </tr>
    </label>
</tr>
<tr> 
    <td class="eingabe"><input class="btnSave" type="submit" value="Speichern"></td>
</tr>
</table> 
<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="MusikstueckID" value="<?php echo $_GET["MusikstueckID"]; ?>"> 
</form>

<?php
include('foot_raw.php');
?>

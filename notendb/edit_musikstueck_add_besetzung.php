
<?php 
include('head_raw.php');

/* XXX noch abfangen: falls alle Besetzungen zugeordnet sind, soll eine Info erfolgen und das u.a. Formular nicht mehr angezeigt werden. */ 

?> 
<form action="edit_musikstueck_list_besetzungen.php" method="get">
<table class="eingabe"> 
   <tr>    
    <label>
    <td class="eingabe">
        <?php 
          include_once("cl_besetzung.php");
          $besetzung=new Besetzung(); 
          $besetzung->print_select('', $_GET["MusikstueckID"]); 
        ?>
    </td>
    </tr>

    </label>
</tr>
  <input type="hidden" name="MusikstueckID" value="<?php echo $_GET["MusikstueckID"]; ?>"> 
   <tr> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
<input type="hidden" name="option" value="insert">
</form>

<?php

include('foot_raw.php');

?>

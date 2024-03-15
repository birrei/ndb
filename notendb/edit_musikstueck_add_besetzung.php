
<?php 
include('head_raw.php');
include("cl_besetzung.php");
// include("cl_html_info.php");

$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}

?> 
<form action="edit_musikstueck_add_besetzung.php" method="post">
<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Besetzung:</td>  
    <td class="eingabe">
        <?php 
            $besetzung=new Besetzung(); 
            $besetzung->print_select(); 
        ?>
    </td>
    </tr>

    </label>
</tr>
  <input type="hidden" name="MusikstueckID" value="<?php echo $MusikstueckID; ?>"> 
   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php

echo '<p> <a href="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$MusikstueckID.'">[Erfassung beenden]</a></p>'; 

include_once("cl_musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$MusikstueckID; 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $musikstueck->add_besetzung($_POST["BesetzungID"]); 
}
$musikstueck->print_table_besetzungen();   

include('foot_raw.php');

?>

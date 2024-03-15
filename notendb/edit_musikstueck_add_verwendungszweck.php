
<?php 
include('head_raw.php');
include("cl_verwendungszweck.php");

$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}

?> 
<form action="edit_musikstueck_add_verwendungszweck.php" method="post">
<table class="eingabe"> 
   <tr>    
    <label>
    <td class="eingabe">Verwendungszweck:</td>  
    <td class="eingabe">
        <!-- Auswahlliste verwendungszweck  --> 
        <?php 
            $verwendungszweck = new Verwendungszweck(); 
            $verwendungszweck->print_select(); 
         ?>
    </td>
    </tr>
    </label>
</tr>
<tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
<input type="hidden" name="MusikstueckID" value="<?php echo $MusikstueckID; ?>"> 

</form>

<?php
echo '<p> <a href="edit_musikstueck_list_verwendungszwecke.php?MusikstueckID='.$MusikstueckID.'">[Erfassung beenden]</a></p>'; 


include_once("cl_musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$MusikstueckID; 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $musikstueck->add_verwendungszweck($_POST["VerwendungszweckID"]); 
}
$musikstueck->print_table_verwendungszwecke();   

include('foot_raw.php');

?>

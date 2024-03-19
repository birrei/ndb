
<?php 
include('head_raw.php');
include("cl_strichart.php");

$SatzID=''; 
if (isset($_GET["SatzID"])) {
  $SatzID= $_GET["SatzID"];
}
if (isset($_POST["SatzID"])) {
  $SatzID= $_POST["SatzID"];
}
?> 

<form action="edit_satz_add_strichart.php" method="post">

<table class="eingabe"> 
<tr>    
  <label>
  <td class="eingabe">Strichart:</td>  
     <td class="eingabe">
         <?php 
          $stricharten = new Strichart(); 
          $stricharten->print_select(); 
    ?>
     </td>
     </label>
      </tr>

     <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
    

    <tr> 
     <td class="eingabe"></td> 
     <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 </form>

<?php

echo '<p> <a href="edit_satz_list_stricharten.php?SatzID='.$SatzID.'">[Erfassung beendenden]</a></p>'; 

include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$SatzID; 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $satz->add_strichart($_POST["StrichartID"]); 
}

$satz->print_table_sticharten();   

include('foot_raw.php');

?>

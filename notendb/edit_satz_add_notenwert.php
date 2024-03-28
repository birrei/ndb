
<?php 
include('head_raw.php');


$SatzID= $_GET["SatzID"];

// $SatzID=''; 
// if (isset($_GET["SatzID"])) {
//  
// }
// if (isset($_POST["SatzID"])) {
//   $SatzID= $_POST["SatzID"];
// }
?> 

<form action="edit_satz_list_notenwerte.php" method="get">

<table class="eingabe"> 
<tr>    
  <label>
  <td class="eingabe">Notenwert:</td>  
     <td class="eingabe">
         <?php 
          include_once("cl_notenwert.php");         
          $notenwerte = new Notenwert(); 
          $notenwerte->print_select(); 
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

// echo '<p> <a href="edit_satz_list_notenwerte.php?SatzID='.$SatzID.'">[Erfassung beendenden]</a></p>'; 

// include_once("cl_satz.php");

// $satz=new Satz();
// $satz->ID=$SatzID; 

// if ("POST" == $_SERVER["REQUEST_METHOD"]) {
//   $satz->add_notenwert($_POST["NotenwertID"]); 
// }

// $satz->print_table_notenwerte();   

include('foot_raw.php');

?>

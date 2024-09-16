
<?php 
include('head_raw.php');
?> 
<form action="edit_satz_list_schwierigkeitsgrade.php" method="get">
<p>   </label> 
      Instrument: 
         <?php 
          include_once("cl_instrument.php");         
          $instrument = new Instrument(); 
          $instrument->print_select('',  $_GET["SatzID"]); 
    ?>
   </label>    
 
  <label>

        Schwierigkeitsgrad: 
         <?php 
          include_once("cl_schwierigkeitsgrad.php");         
          $schwierigkeitsgrad = new Schwierigkeitsgrad(); 
          $schwierigkeitsgrad->print_select('',  $_GET["SatzID"]); 
    ?>
   </label>    


 <input class="btnSave" type="submit" value="Speichern">

 <input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php
include('foot_raw.php');

?>

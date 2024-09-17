
<?php 
include('head_raw.php');
include("cl_html_info.php"); 
?> 
<form action="edit_satz_schwierigkeitsgrade.php" method="get">
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
$info = new HtmlInfo(); 
$info->option_linktext=1; 
$info->print_link_table('instrument','sortcol=Name','Instrumente',true,'');  
print '<p>'; 
$info->print_link_table('schwierigkeitsgrad','sortcol=Name','Schwierigkeitsgrade',true,''); 
print '</p>';     

include('foot_raw.php');

?>

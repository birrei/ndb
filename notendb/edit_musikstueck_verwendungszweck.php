
<?php 
include('head_raw.php');
include('cl_html_info.php');
$info=new HtmlInfo(); 
?> 


<form action="edit_musikstueck_verwendungszwecke.php" method="get">


<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Verwendungszweck: </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      include_once("classes/class.verwendungszweck.php");
      $verwendungszweck = new Verwendungszweck(); 
      $verwendungszweck->print_select('',$_GET["MusikstueckID"]); 
    ?>
</td>  
  <td class="eingabe2 eingabe2_3">
    <?php      
      // $info->option_linktext=1; 
      $info->print_link_table('verwendungszweck','sortcol=Name','Verwendungszwecke',true,'');       
    ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"> <input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      // $info->option_linktext=1; 
      $info->print_link_insert('verwendungszweck','Verwendungszweck', true);  
      ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
  <?php 
    $info->print_link_reload(); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
  <?php 
    $info->print_link_backToList('edit_musikstueck_verwendungszwecke.php?MusikstueckID='.$_GET["MusikstueckID"]); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


</table>


<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="MusikstueckID" value="<?php echo $_GET["MusikstueckID"]; ?>"> 


</form>





<?php

include('foot_raw.php');
?>

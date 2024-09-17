
<?php 
include('head_raw.php');
include('cl_html_info.php');
?> 
<form action="edit_musikstueck_verwendungszwecke.php" method="get" style="float:left; margin:5px">
<label>
<?php 
    include_once("cl_verwendungszweck.php");
    $verwendungszweck = new Verwendungszweck(); 
    $verwendungszweck->print_select('',$_GET["MusikstueckID"]); 
?>
</label>
<input class="btnSave" type="submit" value="Speichern">
<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="MusikstueckID" value="<?php echo $_GET["MusikstueckID"]; ?>"> 

<?php 
$info=new HtmlInfo(); 
$info->option_linktext=1; 
$info->print_link_table('verwendungszweck','sortcol=Name','Verwendungszwecke',true,'');   
$info->print_link_insert('verwendungszweck','verwendungszwecke', true);   
?>
</form>

<?php

include('foot_raw.php');
?>

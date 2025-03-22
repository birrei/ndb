
<?php 
include('head_raw.php');
include('cl_html_info.php');

$info=new HtmlInfo(); 
?> 

<form action="edit_musikstueck_besetzungen.php" method="get">
<label>
  <?php 
    include_once("cl_besetzung.php");
    $besetzung=new Besetzung(); 
    $besetzung->print_select('', $_GET["MusikstueckID"]); 
  ?>
</label>

<input type="hidden" name="MusikstueckID" value="<?php echo $_GET["MusikstueckID"]; ?>"> 
<input type="hidden" name="option" value="insert">
<input class="btnSave" type="submit" value="Speichern">
<?php 
$info->print_link_reload(); 
$info->print_link('edit_musikstueck_besetzungen.php?MusikstueckID='.$_GET["MusikstueckID"], 'zurück zu Liste'); 

?>
</form>

<p> 
<?php
  // $info->option_linktext=1; 
  $info->print_link_table('besetzung','sortcol=Name','Besetzungen',true,'');     
  $info->print_link_insert('besetzung','Besetzungen', true);  
?>

</p> 

<?php 

include('foot_raw.php');

?>

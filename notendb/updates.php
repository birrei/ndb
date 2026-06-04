<?php 
$PageTitle='Sammelupdates'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");

// echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$form_selected=''; 
$form_sended=''; 
$info=new HTML_Info(); 


echo '<h3>Sammelupdates</h3>'; 

if (isset($_POST["form-selected"])) {
  $form_selected=$_POST["form-selected"]; 
}
if (isset($_POST["form-sended"])) {
  $form_sended=$_POST["form-sended"]; 
}

// echo '<p>Ausgewähltes Formular: '.$form_selected; // Test 
// echo '<p>Gesendetes Formular: '.$form_sended; // Test 

echo '<pre>';  
if (isset($_POST["form-sended"])){
    // print_r($_POST); 
    switch($_POST["form-sended"]) {

      case 'noten-schueler-status': 
        if (!empty($_POST["StatusID_src"]) & !empty($_POST["StatusID_tgt"])) 
            {
            include_once('classes/class.schueler_satz.php');                     
            $StatusID_src=$_POST["StatusID_src"]; 
            $StatusID_tgt=$_POST["StatusID_tgt"]; 
            $schueler_satz=new SchuelerSatz; 
            $schueler_satz->changeStatusAll($StatusID_src, $StatusID_tgt); 
        } 
        break; 
    
        }

    }

echo '</pre>';  
?>
<form action="" method="post" name="select-task">   
<p> Aufgabe auswählen: 
<select id="form-selected" name="form-selected" onchange="this.form.submit()">
  <option value="">Formular auswählen ... </option>
  <option value="noten-schueler-status" <?php echo ($form_selected=='noten-schueler-status'?'selected':''); ?>>Status Schüler/Noten-Verknüpfung aktualisieren</option>                


</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {

    case 'noten-schueler-status': 
      $StatusID_src=''; 
      $StatusID_tgt=''; 
      ?>
      <h3>Status Schüler/Noten-Verknüpfung aktualisieren </h3>
      <form action="" method="post" name="noten-schueler-status">
      <?php
        include_once('classes/class.status.php');                     

        echo 'Status alt: '; 
        $auswahl_src = new Status(); 
        $auswahl_src->print_select2('StatusID_src', $StatusID_src); 

        echo 'Status neu: ';         
        $auswahl_tgt = new Status(); 
        $auswahl_tgt->print_select2('StatusID_tgt', $StatusID_tgt); 

        ?>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="noten-schueler-status">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
      </form>
      <?php

      break; 


  }
  

}

?>

<!--- ****************************************************************************** --> 

<hr >


<?php 

end: 

include_once('foot.php');
?>


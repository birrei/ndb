<?php 
$PageTitle='Schüler Sammelupdates'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.schueler.php");

// echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$form_selected=''; 
$form_sended=''; 
$info=new HTML_Info(); 

if (isset($_REQUEST["SchuelerID"])) {
  $SchuelerID=$_REQUEST["SchuelerID"]; 
} else 
{
  echo '<p>Die Seite muss über das Schüler-Formular geöffnet werden. </p>'; 
  goto end; 
}

echo '<h3>Sammel-Updates zu Schüler ID: '.$SchuelerID.'</h3>'; 

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

      case 'schueler-uebungen-kopieren': 
        if (!empty($_POST["SchuelerID_ref"]) & !empty($_POST["Datum_ref"]) & !empty($_POST["Datum"])  ) 
            {
            $SchuelerID=$_POST["SchuelerID"]; 
            
            $schueler = new Schueler(); 
            $schueler->ID = $SchuelerID; 
            if(!$schueler->Uebungstag_exists($_POST["Datum"])) {
              $info->print_user_error('Das Datum "'.$_POST["Datum"].'" ist kein gültiger Übungstag für den Schüler. ');            
              goto ausgang_fehler; 
            }
            $schueler->copy_uebungen_from_schueler($_POST["SchuelerID_ref"], $_POST["Datum_ref"],$_POST["Datum"] ); 
        }
      
      break; 
      
  }
}

ausgang_fehler: 

echo '</pre>';  
?>
<form action="" method="post" name="select-task">   
<p> Aufgabe auswählen: 
<select id="form-selected" name="form-selected" onchange="this.form.submit()">
  <option value="">Formular auswählen ... </option>
  <option value="schueler-uebungen-kopieren" <?php echo ($form_selected=='schueler-uebungen-kopieren'?'selected':''); ?>>Schüler: Übungen von anderem Schüler kopieren</option>               
  <input type="hidden" name="SchuelerID" value="<?php echo $SchuelerID; ?>">  
</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {

    case 'schueler-uebungen-kopieren': 

      ?>
      <h3>Schüler: Übungen von anderem Schüler kopieren</h3>
      <form action="" method="post" name="schueler-uebungen-kopieren">

      <?php
        echo 'Schüler, von dem kopiert werden soll: '; 
        $schueler_ref = new Schueler(); 
        $schueler_ref->print_select2('','SchuelerID_ref'); 
      ?>

      <br> <br>Datum der Übungen, die kopiert werden sollen: <input type="date" name="Datum_ref" >
      <br> <br>Neues Datum für kopierte Übungen: <input type="date" name="Datum" >
      <br> <br>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="schueler-uebungen-kopieren">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>"> 
      <input type="hidden" name="SchuelerID" value="<?php echo $SchuelerID; ?>">

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


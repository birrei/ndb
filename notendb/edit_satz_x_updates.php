<?php 
$PageTitle='Sammelupdates Satz'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.schueler.php");
include_once("classes/class.uebungtyp.php");
 include_once('classes/class.satz.php');   

// echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$form_selected=''; 
$form_sended=''; 
$info=new HTML_Info(); 

if (isset($_REQUEST["SatzID"])) {
  $SatzID=$_REQUEST["SatzID"]; 
} else 
{
  echo '<p>Die Seite muss über ein Satz-Formular geöffnet werden. </p>'; 
  goto end; 
}

echo '<h3>Sammel-Updates zu Satz ID: '.$SatzID.'</h3>'; 

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
    // print_r($_POST); // test 
    switch($_POST["form-sended"]) {
      case 'uebungen-aus-abschnitten': 
        $satz = new Satz(); 
        $satz->ID=$_POST["SatzID"]; 
        $satz->insert_uebungen_from_abschnitte($_POST["UebungtypID"]); 
        $info->print_info($satz->Infotext, $satz->Infotype);         
        break; 
    }
}
echo '</pre>';  
?>
<form action="" method="post" name="select-task">   
<p> Aufgabe auswählen: 
<select id="form-selected" name="form-selected" onchange="this.form.submit()">
  <option value="">Formular auswählen ... </option>
  <option value="uebungen-aus-abschnitten" <?php echo ($form_selected=='uebungen-aus-abschnitten'?'selected':''); ?>>Übungsentwürfe aus Abschnitten erstellen</option> 
  
  <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>">  
</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {

    case 'uebungen-aus-abschnitten': 

      ?>
      <h3>Übungsentwürfe aus Abschnitten erstellen</h3>
      <p>Für alle mit dem Satz verknüpften Schüler werden jeweils Übungs-Entwürfe aus den dem Satz zugeordneten Abschnitten erstellt.</p>

      <form action="" method="post" name="uebungen-aus-abschnitten">
      
      <?php
        echo 'Übungstyp: '; 
        $uebungstyp = new UebungTyp(); 
        $uebungstyp->print_preselect(); 
      ?>

      <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>">

      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="uebungen-aus-abschnitten">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
      </form>
      <?php

      break; 


  }
  

}

?>

<hr >


<?php 

end: 

include_once('foot.php');
?>


<?php 
include('head.php');
echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$SammlungID=''; 
$BesetzungID=''; 
$VerwendungszweckID=''; 

$form_selected=''; 
$form_sended=''; 

if (isset($_POST["form-selected"])) {
  $form_selected=$_POST["form-selected"]; 
}
if (isset($_POST["form-sended"])) {
  $form_sended=$_POST["form-sended"]; 
}

// echo '<p>Ausgewähltes Formular: '.$form_selected; // Test 
// echo '<p>Gesendetes Formular: '.$form_sended; // Test 

/* Aktionen abhängig vom sendenden Formular: */
echo '<pre>';  
if (isset($_POST["form-sended"])){

    // print_r($_POST); 
    switch($_POST["form-sended"]) {
        case 'sammlung-besetzung': 
            if (!empty($_POST["SammlungID"]) & !empty($_POST["BesetzungID"])) {
                include_once('cl_sammlung.php');                     
                $SammlungID=$_POST["SammlungID"]; 
                $BesetzungID=$_POST["BesetzungID"];                 
                $sammlung = new Sammlung(); 
                $sammlung->ID=$SammlungID; 
                
                if (isset($_POST["sammlung_delete_besetzung"])) {
                    $sammlung->delete_besetzung($BesetzungID);
                }
                else {                                
                    $sammlung->add_besetzung($BesetzungID);
                }
            }
            break; 
        case 'sammlung-verwendungszweck': 
                if (!empty($_POST["SammlungID"]) & !empty($_POST["VerwendungszweckID"])) {
                    include_once('cl_sammlung.php');                     
                    $SammlungID=$_POST["SammlungID"]; 
                    $VerwendungszweckID=$_POST["VerwendungszweckID"];                 
                    $sammlung = new Sammlung(); 
                    $sammlung->ID=$SammlungID; 
                    // $sammlung->add_verwendungszweck($VerwendungszweckID);
                    if (isset($_POST["sammlung_delete_verwendungszweck"])) {          
                        $sammlung->delete_verwendungszweck($VerwendungszweckID);
                    }
                    else {                                
                        $sammlung->add_verwendungszweck($VerwendungszweckID);
                    }
                           
                }
                break; 
        case 'sammlung-kopieren': 
            if (!empty($_POST["SammlungID"])) {
                include_once('cl_sammlung.php');                     
                $SammlungID=$_POST["SammlungID"];             
                $sammlung = new Sammlung(); 
                $sammlung->ID=$SammlungID; 

                $include_musikstuecke=(isset($_POST["include_musikstuecke"])?true:false);
                $include_verwendungszwecke=(isset($_POST["include_verwendungszwecke"])?true:false);
                $include_besetzung=(isset($_POST["include_besetzungen"])?true:false);
                $include_saetze=(isset($_POST["include_saetze"])?true:false);
                $include_satz_schwierigkeitgrad=(isset($_POST["include_schwierigkeitsgrade"])?true:false);      
                $include_satz_lookup=(isset($_POST["include_satz_lookups"])?true:false);

                $sammlung->copy(        
                        $include_musikstuecke
                        , $include_verwendungszwecke
                        , $include_besetzung
                        , $include_saetze  
                        , $include_satz_schwierigkeitgrad        
                        , $include_satz_lookup    
                  );
            }
            break;                 
    }
}
echo '</pre>';  
?>
<form action="" method="post" name="select-task">   
<p> Dataclearing-Task auswählen: 
<select id="form-selected" name="form-selected" onchange="this.form.submit()">
  <option value="">Formular auswählen ... </option>
  <option value="sammlung-kopieren" <?php echo ($form_selected=='sammlung-kopieren'?'selected':''); ?>>Sammlung kopieren</option>
  <option value="sammlung-verwendungszweck" <?php echo ($form_selected=='sammlung-verwendungszweck'?'selected':''); ?>>Sammlung: Verwendungszweck hinzufügen</option>                
  <option value="sammlung-besetzung" <?php echo ($form_selected=='sammlung-besetzung'?'selected':''); ?>>Sammlung: Besetzung hinzufügen</option>   
</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {
    case 'sammlung-kopieren': 
      ?>
      <h2> Sammlung kopieren </h2>
      <form action="" method="post" name="sammlung-kopieren">    

      <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label><br />
      <!-- noch XXX: besser: Checkbox-Gruppen  --> 
      <input type="checkbox" name="include_musikstuecke" value="true" checked><label for="include_musikstuecke">Musikstücke einschließen</label><br>
      <input type="checkbox" name="include_verwendungszwecke" checked><label for="include_verwendungszwecke">Verwendungszwecke einschließen</label><br>
      <input type="checkbox" name="include_besetzungen" checked><label for="include_besetzungen">Besetzungen einschließen</label><br>
      <input type="checkbox" name="include_saetze" checked><label for="include_saetze">Sätze einschließen</label><br>
      <input type="checkbox" name="include_schwierigkeitsgrade" checked><label for="include_schwierigkeitsgrade">Schwierigkeitsgrade einschließen</label><br>
      <input type="checkbox" name="include_satz_lookups" checked><label for="include_satz_lookups">Satz Besonderheiten einschließen</label><br>

      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-kopieren">             
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">   

      </form>

      <?php 
    break; 
    case 'sammlung-besetzung': 
      ?>

        <h2> Sammlung: Besetzung ergänzen / entfernen </h2>
        Bei Musikstücken einer Sammlung wird eine definierte Besetzung zugeordnet / entfernt 

        <form action="" method="post" name="sammlung-besetzung">

        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
        <label> BesetzungID: <input type="text" name="BesetzungID" size="5" ></label>
        <input type="checkbox" name="sammlung_delete_besetzung"><label for="sammlung_delete_besetzung">entfernen</label> 
        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-besetzung">  
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           


        </form>
      <?php 
    break; 
    case 'sammlung-verwendungszweck': 
      ?>
      <h2>Sammlung: Verwendungszweck ergänzen / entfernen </h2>
        Bei allen Musikstücken einer Sammlung wird ein definierter Verwendungszweck zugeordnet / entfernt 

        <!-- sammlung-insert-verwendungszweck -->   
        <form action="" method="post" name="sammlung-verwendungszweck">
        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
        <label> VerwendungszweckID: <input type="text" name="VerwendungszweckID" size="5" ></label>
        <input type="checkbox" name="sammlung_delete_verwendungszweck"><label for="sammlung_delete_verwendungszweck">entfernen</label> 

        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-verwendungszweck">    
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">                    

      </form>


      <?php       
    break;     
  }
  

}

?>




<!--- ****************************************************************************** --> 



    <hr >

<!--- ****************************************************************************** --> 




<?php 
include('foot.php');
?>


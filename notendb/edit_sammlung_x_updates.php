<?php 
$PageTitle='Sammelupdates'; 

include_once('head.php');
// echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$form_selected=''; 
$form_sended=''; 

if (isset($_REQUEST["SammlungID"])) {
  $SammlungID=$_REQUEST["SammlungID"]; 
} else 
{
  echo '<p>Die Seite muss über ein Sammlung-Formular geöffnet werden. </p>'; 
  goto end; 
}

echo '<h3>Sammel-Updates zu Sammlung ID: '.$SammlungID.'</h3>'; 

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
      case 'sammlung-musikstueck-order': 
        if (!empty($_POST["SammlungID"]) & !empty($_POST["ab_musikstueck_nr"])) 
            {
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $ab_musikstueck_nr=$_POST["ab_musikstueck_nr"];                   
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->musikstuecke_move_order($ab_musikstueck_nr); 

        }

      break; 
      
      case 'sammlung-erprobt': 
        if (!empty($_POST["SammlungID"]) & !empty($_POST["ErprobtID"])) 
            {
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $ErprobtID=$_POST["ErprobtID"];                              
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->add_erprobt($ErprobtID); 

        }
        break;  

      case 'sammlung-schwierigkeitsgrad': 
        if (!empty($_POST["SammlungID"]) 
          & !empty($_POST["InstrumentID"])
          & !empty($_POST["SchwierigkeitsgradID"]) ) 
            {
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $InstrumentID=$_POST["InstrumentID"];  
            $SchwierigkeitsgradID=$_POST["SchwierigkeitsgradID"];                               
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->add_schwierigkeitsgrad($InstrumentID,$SchwierigkeitsgradID); 
     
        }
        break;       
      case 'sammlung-besetzung': 
            if (!empty($_POST["SammlungID"]) & !empty($_POST["BesetzungID"])) {
                include_once('classes/class.sammlung.php');                     
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
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $VerwendungszweckID=$_POST["VerwendungszweckID"];     
            $MaterialtypID=$_POST["MaterialtypID"];                           
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            // $sammlung->add_verwendungszweck($VerwendungszweckID);
            if (isset($_POST["sammlung_delete_verwendungszweck"])) {          
                $sammlung->delete_verwendungszweck($VerwendungszweckID);
            }
            else {                                
                $sammlung->add_verwendungszweck($VerwendungszweckID, $MaterialtypID);
            }
                    
        }
        break; 
 
      case 'sammlung-komponist': 
        if (!empty($_POST["SammlungID"]) & !empty($_POST["KomponistID"])) {
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $KomponistID=$_POST["KomponistID"];                 
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->add_komponist($KomponistID);                     
        }
        break;

      case 'sammlung-epoche': 
        if (!empty($_POST["SammlungID"]) & !empty($_POST["EpocheID"])) {
            include_once('classes/class.sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $EpocheID=$_POST["EpocheID"];                 
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->add_epoche($EpocheID);                     
        }
        break;
                      
      
      case 'sammlung-bearbeiter': 
          if (!empty($_POST["SammlungID"]) & !empty($_POST["Bearbeiter"])) {
              include_once('classes/class.sammlung.php');                     
              $SammlungID=$_POST["SammlungID"]; 
              $Bearbeiter=$_POST["Bearbeiter"];                 
              $sammlung = new Sammlung(); 
              $sammlung->ID=$SammlungID; 
              $sammlung->add_bearbeiter($Bearbeiter);                     
          }
          break; 
          
      case 'sammlung-satz-besonderheit': 
        
          if (!empty($_POST["SammlungID"]) & !empty($_POST["LookupID"])) {     
              include_once('classes/class.sammlung.php');                     
              $SammlungID=$_POST["SammlungID"]; 
              $LookupID=$_POST["LookupID"];                 
              $sammlung = new Sammlung(); 
              $sammlung->ID=$SammlungID; 
              $sammlung->add_satz_lookup($LookupID);  
              echo '<p>Updates wurden abgeschlossen.</p>';                    
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
  <option value="sammlung-verwendungszweck" <?php echo ($form_selected=='sammlung-verwendungszweck'?'selected':''); ?>>Sammlung: Verwendungszweck hinzufügen</option>                
  <option value="sammlung-besetzung" <?php echo ($form_selected=='sammlung-besetzung'?'selected':''); ?>>Sammlung: Besetzung hinzufügen</option>   
  <option value="sammlung-schwierigkeitsgrad" <?php echo ($form_selected=='sammlung-schwierigkeitsgrad'?'selected':''); ?>>Sammlung: Schwierigkeitsgrad hinzufügen</option>   
  <option value="sammlung-komponist" <?php echo ($form_selected=='sammlung-komponist'?'selected':''); ?>>Sammlung: Komponist hinzufügen</option>   
  <option value="sammlung-epoche" <?php echo ($form_selected=='sammlung-epoche'?'selected':''); ?>>Sammlung: Epoche hinzufügen</option>   
  <option value="sammlung-bearbeiter" <?php echo ($form_selected=='sammlung-bearbeiter'?'selected':''); ?>>Sammlung: Bearbeiter hinzufügen</option>   
  <option value="sammlung-erprobt" <?php echo ($form_selected=='sammlung-erprobt'?'selected':''); ?>>Sammlung: Erprobt-Eintrag hinzufügen</option>   
  <option value="sammlung-satz-besonderheit" <?php echo ($form_selected=='sammlung-satz-besonderheit'?'selected':''); ?>>Sammlung: Besonderheit (zu Satz) hinzufügen</option>   
  <option value="sammlung-epoche" <?php echo ($form_selected=='sammlung-epoche'?'selected':''); ?>>Sammlung: Epoche hinzufügen</option>   
  <option value="sammlung-musikstueck-order" <?php echo ($form_selected=='sammlung-musikstueck-order'?'selected':''); ?>>Sammlung: Reihenfolge Musikstücke schieben</option>   
  
  
  <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">  
</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {


    case 'sammlung-musikstueck-order': 

      ?>
      <h3> Sammlung: Reihenfolge Musikstücke verschieben</h3>
      <form action="" method="post" name="sammlung-musikstueck-order">
      <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">

      <p> Verschieben ab Musikstück Nummer: 
        <input type="text" name="ab_musikstueck_nr" autofocus="autofocus">
      </p>

      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-musikstueck-order">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
      </form>
      <?php

      break; 


    case 'sammlung-satz-besonderheit': 

      ?>
      <h3> Sammlung: Besonderheit ergänzen </h3>
      <form action="" method="post" name="sammlung-satz-besonderheit">
      <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
      <?php
        include_once('classes/class.lookup.php'); 
        $auswahl = new Lookup(); 
        $auswahl->LookupTypeRelation='Satz'; 
        $auswahl->print_select('', $auswahl->Title,'Besonderheit Satz'); 
        ?>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-satz-besonderheit">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
      </form>
      <?php

      break; 

    case 'sammlung-bearbeiter': 

      ?>
      <h3> Sammlung: Bearbeiter ergänzen </h3>
      <form action="" method="post" name="sammlung-bearbeiter">
      <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
      <label> Bearbeiter: <input type="text" name="Bearbeiter" size="25" ></label>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-bearbeiter">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           

      </form>

      <?php

      break; 

    case 'sammlung-komponist': 

      ?>
      <h3> Sammlung: Komponist ergänzen </h3>
      <form action="" method="post" name="sammlung-komponist">
      <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
      <?php
        include_once('classes/class.komponist.php'); 
        $auswahl = new Komponist(); 
        $auswahl->print_select('', $auswahl->Title); 
        ?>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-komponist">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
      </form>
      <?php

      break; 

    case 'sammlung-besetzung': 
      ?>

        <h3> Sammlung: Besetzung ergänzen / entfernen </h3>

        <form action="" method="post" name="sammlung-besetzung">
        <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
        <?php
        include_once('classes/class.besetzung.php'); 
        $auswahl = new Besetzung(); 
        $auswahl->print_select('', '',$auswahl->Title);  // XXX Beschriftung  
        ?>
        <input type="checkbox" name="sammlung_delete_besetzung"><label for="sammlung_delete_besetzung">entfernen</label> 
        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-besetzung">  
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           


        </form>
      <?php 
      break; 
    case 'sammlung-verwendungszweck': 
      ?>
      <h3>Sammlung: Verwendungszweck ergänzen / entfernen </h3>

        <!-- sammlung-insert-verwendungszweck -->   
        <form action="" method="post" name="sammlung-verwendungszweck">
        <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
        <?php
        include_once('classes/class.verwendungszweck.php'); 
        $auswahl = new Verwendungszweck(); 
        $auswahl->print_select('','', $auswahl->Title);  // XXX Beschriftung  

        include_once('classes/class.materialtyp.php'); 
        $materialtyp = new Materialtyp(); 
        echo ' nur anwenden auf: '; 
        $materialtyp->print_select('', $materialtyp->Title);  // XXX Beschriftung  

        ?>


        <input type="checkbox" name="sammlung_delete_verwendungszweck"><label for="sammlung_delete_verwendungszweck">entfernen</label> 

        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-verwendungszweck">    
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">                    

      </form>


      <?php       
      break;  
      
      case 'sammlung-epoche': 

        ?>
        <h3> Sammlung: Epoche ergänzen </h3>
        <form action="" method="post" name="sammlung-epoche">
        <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
        <?php
          include_once('classes/class.epoche.php'); 
          $auswahl = new Epoche(); 
          $auswahl->print_select('', $auswahl->Title); 
          ?>
        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-epoche">  
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           
        </form>
        <?php
  
        break; 
        
    
    case 'sammlung-schwierigkeitsgrad': 
      ?>
      <h3>Sammlung: Schwierigkeitsgrad ergänzen  </h3>
        <!-- sammlung-insert-verwendungszweck XXX Auswahlbox ergänzen ! -->   
        <form action="" method="post" name="sammlung-schwierigkeitsgrad">
        <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
        <label> InstrumentID: <input type="text" name="InstrumentID" size="5" ></label>
        <label> SchwierigkeitsgradID: <input type="text" name="SchwierigkeitsgradID" size="5" ></label>
        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-schwierigkeitsgrad">    
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">                    

      </form>

      <?php       
      break;         
  
    case 'sammlung-erprobt': 
      ?>
      <h3>Sammlung: Erprobt-Eintrag ergänzen  </h3>
        <form action="" method="post" name="sammlung-erprobt">
        <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">
        <?php
        include_once('classes/class.erprobt.php'); 
        $auswahl = new Erprobt(); 
        $auswahl->print_select('', $auswahl->Title);  
        ?>

        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-erprobt">    
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


<?php 
$PageTitle='Sammelupdates'; 

include('head.php');
// echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$form_selected=''; 
$form_sended=''; 

$SammlungID=$_REQUEST["SammlungID"]; 

echo '<h3>SammlungID: '.$SammlungID.'</h3>'; 


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

      case 'sammlung-erprobt': 
        if (!empty($_POST["SammlungID"]) & !empty($_POST["ErprobtID"])) 
            {
            include_once('cl_sammlung.php');                     
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
            include_once('cl_sammlung.php');                     
            $SammlungID=$_POST["SammlungID"]; 
            $InstrumentID=$_POST["InstrumentID"];  
            $SchwierigkeitsgradID=$_POST["SchwierigkeitsgradID"];                               
            $sammlung = new Sammlung(); 
            $sammlung->ID=$SammlungID; 
            $sammlung->add_schwierigkeitsgrad($InstrumentID,$SchwierigkeitsgradID); 
            
            // if (isset($_POST["sammlung_delete_besetzung"])) {
            //     $sammlung->delete_besetzung($BesetzungID);
            // }
            // else {                                
            //     $sammlung->add_besetzung($BesetzungID);
            // }
        }
        break;       
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
        case 'sammlung-komponist': 
              if (!empty($_POST["SammlungID"]) & !empty($_POST["KomponistID"])) {
                  include_once('cl_sammlung.php');                     
                  $SammlungID=$_POST["SammlungID"]; 
                  $KomponistID=$_POST["KomponistID"];                 
                  $sammlung = new Sammlung(); 
                  $sammlung->ID=$SammlungID; 
                  $sammlung->add_komponist($KomponistID);                     
              }
              break;
              
        case 'sammlung-bearbeiter': 
          if (!empty($_POST["SammlungID"]) & !empty($_POST["Bearbeiter"])) {
              include_once('cl_sammlung.php');                     
              $SammlungID=$_POST["SammlungID"]; 
              $Bearbeiter=$_POST["Bearbeiter"];                 
              $sammlung = new Sammlung(); 
              $sammlung->ID=$SammlungID; 
              $sammlung->add_bearbeiter($Bearbeiter);                     
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
  <option value="sammlung-kopieren" <?php echo ($form_selected=='sammlung-kopieren'?'selected':''); ?>>Sammlung kopieren</option>
  <option value="sammlung-verwendungszweck" <?php echo ($form_selected=='sammlung-verwendungszweck'?'selected':''); ?>>Sammlung: Verwendungszweck hinzufügen</option>                
  <option value="sammlung-besetzung" <?php echo ($form_selected=='sammlung-besetzung'?'selected':''); ?>>Sammlung: Besetzung hinzufügen</option>   
  <option value="sammlung-schwierigkeitsgrad" <?php echo ($form_selected=='sammlung-schwierigkeitsgrad'?'selected':''); ?>>Sammlung: Schwierigkeitsgrad hinzufügen</option>   
  <option value="sammlung-komponist" <?php echo ($form_selected=='sammlung-komponist'?'selected':''); ?>>Sammlung: Komponist hinzufügen</option>   
  <option value="sammlung-bearbeiter" <?php echo ($form_selected=='sammlung-bearbeiter'?'selected':''); ?>>Sammlung: Bearbeiter hinzufügen</option>   
  <option value="sammlung-erprobt" <?php echo ($form_selected=='sammlung-erprobt'?'selected':''); ?>>Sammlung: Erprobt-Eintrag hinzufügen</option>   
  <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>">  
</select>

</p>
</form>

<?php

if ($form_selected!='') {
  switch ($form_selected) {

    case 'sammlung-bearbeiter': 

      ?>
      <h2> Sammlung: Bearbeiter ergänzen </h2>

      <form action="" method="post" name="sammlung-bearbeiter">

      <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
      <label> Bearbeiter: <input type="text" name="Bearbeiter" size="25" ></label>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-bearbeiter">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           

      </form>

      <?php

      break; 

    case 'sammlung-komponist': 

      ?>
      <h2> Sammlung: Komponist ergänzen </h2>

      <form action="" method="post" name="sammlung-komponist">

      <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
      <?php
        include_once('cl_komponist.php'); 
        $auswahl = new Komponist(); // XXX Beschriftung  
        $auswahl->print_select(); 
        ?>
      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-sended" value="sammlung-komponist">  
      <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">           


      </form>


      <?php

      break; 

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

        <form action="" method="post" name="sammlung-besetzung">

        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
        <?php
        include_once('cl_besetzung.php'); 
        $auswahl = new Besetzung(); 
        $auswahl->print_select();  // XXX Beschriftung  
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
      <h2>Sammlung: Verwendungszweck ergänzen / entfernen </h2>

        <!-- sammlung-insert-verwendungszweck -->   
        <form action="" method="post" name="sammlung-verwendungszweck">
        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
        <?php
        include_once('cl_verwendungszweck.php'); 
        $auswahl = new Verwendungszweck(); 
        $auswahl->print_select();  // XXX Beschriftung  
        ?>
        <input type="checkbox" name="sammlung_delete_verwendungszweck"><label for="sammlung_delete_verwendungszweck">entfernen</label> 

        <input class="btnSave" type="submit" name="submit" value="ausführen">    
        <input type="hidden" name="form-sended" value="sammlung-verwendungszweck">    
        <input type="hidden" name="form-selected" value="<?php echo $form_selected; ?>">                    

      </form>


      <?php       
    break;   
    
    case 'sammlung-schwierigkeitsgrad': 
      ?>
      <h2>Sammlung: Schwierigkeitsgrad ergänzen  </h2>
        <!-- sammlung-insert-verwendungszweck -->   
        <form action="" method="post" name="sammlung-schwierigkeitsgrad">
        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
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
      <h2>Sammlung: Erprobt-Eintrag ergänzen  </h2>
        <form action="" method="post" name="sammlung-erprobt">
        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
        <?php
        include_once('cl_erprobt.php'); 
        $auswahl = new Erprobt(); 
        $auswahl->print_select();  // XXX Beschriftung  
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

<!--- ****************************************************************************** --> 




<?php 
include('foot.php');
?>


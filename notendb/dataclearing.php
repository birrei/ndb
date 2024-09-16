<?php 
include('head.php');
echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$SammlungID=''; 
$BesetzungID=''; 
$VerwendungszweckID=''; 

echo '<pre>';  
if (isset($_POST["form-name"])){
    print_r($_POST); 
    switch($_POST["form-name"]) {
        case 'sammlung-besetzung': 
            if (!empty($_POST["SammlungID"]) & !empty($_POST["BesetzungID"])) {
                include_once('cl_sammlung.php');                     
                $SammlungID=$_POST["SammlungID"]; 
                $BesetzungID=$_POST["BesetzungID"];                 
                $sammlung = new Sammlung(); 
                $sammlung->ID=$SammlungID; 
                
                if (isset($_POST["sammlung_delete_besetzung"])) {
                  echo 'Auswahl: Besetzung entfernen';                   
                    $sammlung->delete_besetzung($BesetzungID);
                }
                else {                                
                  echo 'Auswahl: Besetzung hinzufügen'; 
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
                      echo 'Auswahl: verwendungszweck entfernen';                   
                        $sammlung->delete_verwendungszweck($VerwendungszweckID);
                    }
                    else {                                
                      echo 'Auswahl: verwendungszweck hinzufügen'; 
                        $sammlung->add_verwendungszweck($VerwendungszweckID);
                    }
                           
                }
                break; 
        case 'Sammlung kopieren': 
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
      <input type="hidden" name="form-name" value="Sammlung kopieren">             

    </form>

    <hr >
<!--- ****************************************************************************** --> 



  <h2> Sammlung: Besetzung ergänzen / entfernen </h2>
    Bei Musikstücken einer Sammlung wird eine definierte Besetzung zugeordnet / entfernt 

    <form action="" method="post" name="sammlung-besetzung">

  <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
  <label> BesetzungID: <input type="text" name="BesetzungID" size="5" ></label>

  <input type="hidden" name="form-name" value="sammlung-besetzung">   
  <input type="checkbox" name="sammlung_delete_besetzung"><label for="sammlung_delete_besetzung">entfernen</label> 
  <input class="btnSave" type="submit" name="submit" value="ausführen">    

    </form>

    <hr >

<!--- ****************************************************************************** --> 

<h2>Sammlung: Verwendungszweck ergänzen / entfernen </h2>
Bei allen Musikstücken einer Sammlung wird ein definierter Verwendungszweck zugeordnet / entfernt 

  <!-- sammlung-insert-verwendungszweck -->   
  <form action="" method="post" name="sammlung-verwendungszweck">

      <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
      <label> VerwendungszweckID: <input type="text" name="VerwendungszweckID" size="5" ></label>
      <input type="checkbox" name="sammlung_delete_verwendungszweck"><label for="sammlung_delete_verwendungszweck">entfernen</label> 

      <input class="btnSave" type="submit" name="submit" value="ausführen">    
      <input type="hidden" name="form-name" value="sammlung-verwendungszweck">             

    </form>




<?php 
include('foot.php');
?>


<?php 
include('head.php');
echo '<p><a href="dataclearing.php">Seite neu laden</a>'; 

$SammlungID=''; 
$BesetzungID=''; 
$VerwendungszweckID=''; 

echo '<pre>';  
if (isset($_POST["form-name"])){
    // print_r($_POST); 
    switch($_POST["form-name"]) {
        case 'Sammlung: Besetzung ergänzen': 
            if (!empty($_POST["SammlungID"]) & !empty($_POST["BesetzungID"])) {
                include_once('cl_sammlung.php');                     
                $SammlungID=$_POST["SammlungID"]; 
                $BesetzungID=$_POST["BesetzungID"];                 
                $sammlung = new Sammlung(); 
                $sammlung->ID=$SammlungID; 
                $sammlung->add_besetzung($BesetzungID);

    
            }
            break; 
        case 'Sammlung: Verwendungszweck ergänzen': 
                if (!empty($_POST["SammlungID"]) & !empty($_POST["VerwendungszweckID"])) {
                    include_once('cl_sammlung.php');                     
                    $SammlungID=$_POST["SammlungID"]; 
                    $VerwendungszweckID=$_POST["VerwendungszweckID"];                 
                    $sammlung = new Sammlung(); 
                    $sammlung->ID=$SammlungID; 
                    $sammlung->add_verwendungszweck($VerwendungszweckID);
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

<table> 
  <!--sammlung-kopieren"-->   
  <form action="" method="post" name="sammlung-kopieren">
    <tr>    
      <td class="eingabe"><b>Sammlung kopieren </b><br />
    </td>  
      <td class="eingabe">
        <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label><br />
<!-- noch XXX: besser: Checkbox-Gruppen  --> 
        <input type="checkbox" name="include_musikstuecke" value="true" checked><label for="include_musikstuecke">Musikstücke einschließen</label><br>
        <input type="checkbox" name="include_verwendungszwecke" checked><label for="include_verwendungszwecke">Verwendungszwecke einschließen</label><br>
        <input type="checkbox" name="include_besetzungen" checked><label for="include_besetzungen">Besetzungen einschließen</label><br>
        <input type="checkbox" name="include_saetze" checked><label for="include_saetze">Sätze einschließen</label><br>
        <input type="checkbox" name="include_schwierigkeitsgrade" checked><label for="include_schwierigkeitsgrade">Schwierigkeitsgrade einschließen</label><br>
        <input type="checkbox" name="include_satz_lookups" checked><label for="include_satz_lookups">Satz Besonderheiten einschließen</label><br>

      </td> 
      <td class="eingabe">
          <input type="submit" name="submit" value="ausführen">    
          <input type="hidden" name="form-name" value="Sammlung kopieren">             
      </td>

    </tr> 
    </form>


  <!-- sammlung-insert-besetzung -->   

  <form action="" method="post" name="sammlung-insert-besetzung">
    <tr>    
      <td class="eingabe"><b>Sammlung: Besetzung ergänzen </b><br />
        Allen Musikstücken einer Sammlung wird eine definierte Besetzung zugeordnet
    </td>  
      <td class="eingabe">
             <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
             <label> BesetzungID: <input type="text" name="BesetzungID" size="5" ></label>
      </td> 
      <td class="eingabe">
          <input type="submit" name="submit" value="ausführen">    
          <input type="hidden" name="form-name" value="Sammlung: Besetzung ergänzen">             
      </td>

    </tr> 
    </form>


  <!-- sammlung-insert-verwendungszweck -->   
  <form action="" method="post" name="sammlung-insert-verwendungszweck">
    <tr>    
      <td class="eingabe"><b>Sammlung: Verwendungszweck ergänzen </b><br />
        Allen Musikstücken einer Sammlung wird ein definierter Verwendungszweck zugeordnet 
    </td>  
      <td class="eingabe">
             <label> SammlungID: <input type="text" name="SammlungID" value="<?php echo $SammlungID; ?>" size="5" ></label>
             <label> VerwendungszweckID: <input type="text" name="VerwendungszweckID" size="5" ></label>
      </td> 
      <td class="eingabe">
          <input type="submit" name="submit" value="ausführen">    
          <input type="hidden" name="form-name" value="Sammlung: Verwendungszweck ergänzen">             
      </td>

    </tr> 
    </form>




    </table>



<?php 
include('foot.php');
?>


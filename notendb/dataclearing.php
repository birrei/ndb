<?php 
include('head.php');

$SammlungID=''; 
$BesetzungID=''; 
$VerwendungszweckID=''; 

echo '<pre>';  
if (isset($_POST["form-name"])){
    print_r($_POST); 
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
    }
}
echo '</pre>';  

?>
<a href="dataclearing.php">leeren</a>

<table> 

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


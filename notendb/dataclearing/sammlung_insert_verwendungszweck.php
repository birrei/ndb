
<?php 
include('../head_raw.php');
include('../cl_sammlung.php'); 

if (isset($_POST["exec"])){
  if (!empty($_POST["SammlungID"]) & !empty($_POST["VerwendungszweckID"])) {
    // echo 'SammlungID: '.$_POST["SammlungID"].'<br>'; 
    // echo 'VerwendungszweckID: '.$_POST["VerwendungszweckID"].'<br>';   
    $sammlung = new Sammlung(); 
    $sammlung->ID=$_POST["SammlungID"]; 
    $sammlung->add_verwendungszweck($_POST["VerwendungszweckID"]);
    
  }
}

?>

  <form action="" method="post">
  <table class="eingabe"> 
    <tr>    
      <label>
      <td class="eingabe"><b>Sammlung ID</b></td>  
      <td class="eingabe"><input type="text" name="SammlungID" size="10" ></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe"><b>Verwendungszweck ID</b></td>  
      <td class="eingabe"><input type="text" name="VerwendungszweckID" size="10" ></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input class="btnSave" type="submit" name="exec" value="exec">     
    </td>
    </tr> 
  
    </table>
</form>

<?php

include('../foot_raw.php');

?>

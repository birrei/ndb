
<?php 
include('head_raw.php');
include('cl_satz_erprobt.php');
include("cl_html_info.php");

$satz_erprobt=new SatzErprobt(); 

if (isset($_GET["ID"])) {
  $satz_erprobt->ID= $_GET["ID"]; 
  $satz_erprobt->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_satz_erprobt.php" method="post">
      <p><b>Folgender SatzErprobt wird gelöscht: </b><br/>
      ID: '.$satz_erprobt->ID.'  
      , ErprobtID:  '.$satz_erprobt->ErprobtID.'
      , Jahr: '.$satz_erprobt->Jahr.' 
      , Bemerkung: '.$satz_erprobt->Bemerkung.'  <br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $satz_erprobt->ID . '">
      <input type="hidden" name="title" value="SatzErprobt löschen">        
      </form>
      </p> 
      <p> <a href="edit_satz_list_erprobte.php?SatzID='. $satz_erprobt->SatzID . '&title=SatzErprobt">Zurück Zur Liste</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $satz_erprobt->ID=$_POST["ID"]; 
  $satz_erprobt->load_row();   
  $satz_erprobt->delete();      
  echo '<p> <a href="edit_satz_list_erprobte.php?SatzID='. $satz_erprobt->SatzID . '&title=SatzErprobt">Zur Liste</a></p>'; 
                    
}


include('foot_raw.php');

?>


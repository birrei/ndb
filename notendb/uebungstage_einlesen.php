<?php 

$PageTitle='Übungstage einlesen'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.kalender.php");

echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 

$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');   

if(isset($_REQUEST["insert"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->insert_rows($SchuljahrID); 
}

if(isset($_REQUEST["delete"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->delete_rows($SchuljahrID); 
}

echo '<p>Hinweis: Übungstage können nur ingelesen bzw. gelöscht werden, sofern für das gewählte Schuljahr die Eigenschaft "Eingelesen = Nein" gesetzt ist. 
  <a href="edit_schuljahr.php?ID='.$SchuljahrID.'" target="_blank">Schuljahr öffnen </a>
</p>'; 



/* Schuljahr auswählen */
echo '<form action="" method="get">'.PHP_EOL;       
$schuljahr= new Schuljahr(); 
echo 'Schuljahr: '.PHP_EOL; 
$schuljahr->print_preselect($SchuljahrID, '', true); 
// echo '<br><br>'; 
echo '</form>';           

echo '<p>
    <a href="show_table4.php?ansicht=uebungstage&SchuljahrID='.$SchuljahrID.'" target="_blank">Übungstage anzeigen </a> 
    
    </p>'; 
echo '<br><br>';

echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="submit" class="btnSave" name="insert" value="Übungstage einlesen">';
echo '</form>';           

echo '<br><br>';
echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="submit" class="btnSave" name="delete" value="Übungstage löschen">';
echo '</form>';           








    
      // $conn = new DBConnection(); 
      // $db=$conn->db; 

      // $select = $db->prepare($query); 
        
      // try {
      //   $select->execute(); 
      //   include_once("classes/class.htmltable.php");      
      //   $html = new HTML_Table($select); 
      //   $html->add_link_edit= false;
      //   // $html->edit_link_table=$table_edit; 
      //   // $html->edit_link_open_newpage = true; 
      //   // $html->add_link_show=$add_link_show;   
      //   $html->show_row_count=true; 
      //   $html->print_table2(); 
      // }
      // catch (PDOException $e) {
      //   $info = new HTML_Info();      
      //   $info->print_user_error(); 
      //   $info->print_error($select, $e); 
      // }        
          

?>


<hr >


<?php 

end: 

include_once('foot.php');
?>


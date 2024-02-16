<?php
include('head.php'); 
include("dbconnect_pdo.php");
include("snippets.php");



/* Tabelle ausgeben lassen (<table>...</table>)  */ 

    // $query = 'select * from satz';
    // // $query = 'select ID, Name, Nummer from musikstueck order by ID desc'; 
    // // $query = 'select ID, Name from besetzung';

    // $stmt = $db->query($query); // statement-Objekt 

    // // $html=get_html_table($stmt); 
    // // echo $html; 

    // $html2=get_html_table($stmt, 'satz'); 
    // echo $html2; 



/**************** erledigt **/

    // $query = 'select ID, Name, Nummer from musikstueck where SammlungID=11'; 
    // $stmt = $db->query($query); // statement-Objket 
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $count_cols=$stmt->columnCount(); 

    // echo '<table>';
    // // header 
    // echo '<thead>';
    // echo '<tr>'. PHP_EOL;

    // for($i = 0; $i < $count_cols; ++$i) {
    //     $colmeta=$stmt->getColumnMeta($i); // assoz. array 
    //     echo '<th>'.$colmeta['name'].'</th>';    
    // }
    // echo '</tr>'. PHP_EOL;
    // // header 
    // foreach ($result as $row) {
    //     echo '<tr>'. PHP_EOL;
    //     foreach ($row as $cell){
    //             echo '<td>'.$cell.'</td>'. PHP_EOL; 
    //     }
    //     echo '</tr>'. PHP_EOL;
    // }
    // echo '</table>';



/* Löschen (verworfen) */ 

    // if ($_POST["option"] == 'delete')
    //   {
    //     // Datensatz löschen      
    //     $delete = $db->prepare("delete from `sammlung` where `ID`=:ID");  
        
    //     try {
    //       $delete->execute([':ID' => $_POST["ID"]]); 
    //       echo '<p>Der Datensatz wurde gelöscht.</p>';
    //     }
    //     catch (PDOException $e) {
    //       echo '<p>Der Datensatz konnte nicht gelöscht werden.<br />'.$e->getMessage().'</p>';
    //     }
    //   }


?>

<!--
<p><a href="edit_sammlung_sub_musikstuecke.php?table='.$table.'&sortorder=desc">

<iframe src="edit_sammlung_sub_musikstuecke.php?SammlungID=11" width="900" height="400" name="musikstuecke">

</iframe>

    -->

<?php



include('foot.php');
?>


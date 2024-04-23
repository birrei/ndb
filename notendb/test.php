<?php
include('head.php'); 

 ?>
<script type="text/javascript">  
function set_seconds() {  
    var txt_min = document.getElementById("input_minutes").value;
    var int_sec = 0; 
    /* 
       zwei Eingabe-möglichkeiten sollen zugelassen sein: 
        - Eine Ganzzahl bzw. ein in eine Ganzzahl umwandelbarer Wert  
        - Ein Minuten/Sekunden-Angabe im Format "mm:ss" 

    */

    if (!isNaN(txt_min)) {
        sec=Math.floor(txt_min*60);
    } 
    else {
        sec = 0; // für ormat mm:ss, nur zulassen bei vorh. Werten vor und nach ":"
        const arr_values=txt_min.split(":"); 
        // document.getElementById("test2").innerHTML=arr_values.length; 
        if (arr_values.length = 2) {
            // min_tmp=arr_values[0]; 
            // sec_tmp=arr_values[1];    
            if (arr_values[0]!="" & arr_values[1]!="") {
                if (!isNaN(arr_values[0]) & !isNaN(arr_values[1]) ) {
                    min_tmp=parseInt(arr_values[0]); 
                    sec_tmp=parseInt(arr_values[1]);                     
                    sec = (min_tmp*60) + sec_tmp;  
                } 
            }
            document.getElementById("test").innerHTML=arr_values[0]; 
            document.getElementById("test2").innerHTML=arr_values[1]; 
        }       
    }
    document.getElementById("input_seconds").value=sec;  
}
</script> 


<p> 
Minuten: <input type="text" id="input_minutes" size="10" oninput="set_seconds();">
Sekunden: <input type="text" id="input_seconds" size="10">

<p id="test"></p>
<p id="test2"></p>

 <?php 
 
    // include('cl_musikstueck.php'); 
    // include('cl_sammlung.php'); 
    // include('cl_dir.php'); 

/* Test: Name der aktuellen DAtei ausgeben  */
        // echo basename($_SERVER['PHP_SELF']); 


    // $table='v_sammlung'; 

    // $table_edit=(substr($table,0,2)=='v_'?substr($table,2, strlen($table)-2):$table); // "v_" vorne abschneiden 


    // // $table_edit = substr($table,2, strlen($table)-2); // 
  
    // echo '<p>'.$table_edit; 


    //   // echo '<pre>'.$query.'</pre>'; // Test 


/* Klassen testen */

    // include_once('cl_verlag.php'); 
    // $verlag = new Verlag(); 
    // $verlag->insert_row('ganz neuer Verlag'); 
    // $verlag->print_table(); 
    


    // include_once('cl_komponist.php'); 
    // $komponist = new Komponist(); 
    // $komponist->print_select(); 
    // $komponist->print_select(5); 
    // $komponist->insert_row('Eugen', 'Tester','', '', ''); 
    // $komponist->print_table();  


    // $sammlung = new Sammlung(); 
    // $sammlung->print_table(); 



    // $ms = new Musikstueck(); 
    // // $ms->set_rowdata(122); // Daten für eine ID 
    // // $ms->print_rowdata_demo(); // Daten für diese ID ausgeben
    // $ms->print_tabledata(25); 
    // $ms->print_tabledata(26); 




// Verwendung Klasse "Musikstück" 
    // $m = new Musikstueck();
    // $m->insert_row(38, 5, 'fünf'); 
    // echo '<p>ID:'.$m->ID; 
    // echo '<p>Nummer:'.$m->Nummer;     
    // echo '<p>Name: '.$m->Name; 
    // // echo '<p>'.$m->ErrorInfo; 


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




include('foot.php');
?>


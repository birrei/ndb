<?php 

// function get_html_select($options = [], $keyname='') {
//     // https://werner-zenk.de/php/auswahlliste_aus_dem_inhalt_einer_db-spalte_erstellen.php
//     // Auswahlliste aus dem Inhalt von zwei DB-Spalten erstellen
//     $html = '';
//     if (sizeof($options) > 0) {
//     $html = '<select name="'.$keyname.'">' . PHP_EOL;
//     foreach($options as $key => $title) {
//         $html .= ' <option value="' . $key . '">' . $title . '</option>'. PHP_EOL;
//         }
//     $html .= '</select>';
//     }
//     return $html;
//     }
 
function get_html_select2($options = [], $keyname='',$key_selected='', $add_null_option=true) {
    // key_selected ist bei edit_*.php- Formularen befüllt, bei insert_*.php leer 
    $html = '';
    if (sizeof($options) > 0) {
    $html = '<select name="'.$keyname.'" required>' . PHP_EOL;
    if($add_null_option) {
        $html .= '<option value="" '.($key_selected=='' ? 'selected' : ''). '></option>'. PHP_EOL;
    }
    
    foreach($options as $key => $title) {
        $html .= ' <option value="' . $key . '" '.($key_selected==$key ? 'selected' : ''). '>' . $title . '</option>'. PHP_EOL;
        }
    $html .= '</select>';
    }
    return $html;

}
function get_html_table($stmt, $edit_table_name='', $edit_newpage=false) {
    /* 
    Falls $edit_table_name (<> '') übergeben wird, 
       muss die zugrundeliegende Abfrage eine Spalte "ID" für diese Tabelle enthalten. 
    falls $edit_newpage=true, wird dem Bearbeitungs-Link ein target="_blank" hinzugefügt 


    */ 
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count_cols=$stmt->columnCount(); 
    $count_rows = count($result); 
    
    $html = '';

    if ($count_cols > 0 & $count_rows > 0)
    {
        $html .= '<table>';
        // header 
        $html .= '<thead>';
        $html .= '<tr>'. PHP_EOL;
        for($i = 0; $i < $count_cols; ++$i) {
            $colmeta=$stmt->getColumnMeta($i); // assoz. array 
            $html .= '<th>'.$colmeta['name'].'</th>';    
        }
        if ($edit_table_name!='') {
            $html .= '<th>Aktion</th>'. PHP_EOL;                     
        }         
        $html .=  '</tr>'. PHP_EOL;

        // daten 
        if  ($count_rows > 0) {
            foreach ($result as $row) {
                $html .= '<tr>'. PHP_EOL;
                foreach ($row as $cell){
                    $html .= '<td>'.$cell.'</td>'. PHP_EOL; 
                }
                if ($edit_table_name!='') {
                    $html .= '<td><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].'" ' . ($edit_newpage!='' ?'target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;                     
                }                
                $html .= '</tr>'. PHP_EOL;
            } 
        }
        $html .= '</table>'; 
    }
    else {
        $html .= '<p>Keine Daten vorhanden.</p> '; 
    }
    return $html;
}


  
?>
<?php 
 
function get_html_select2($options = [], $keyname='',$key_selected='', $add_null_option=true) {
/* 
    // Einfache Auswahlbox 
    // key_selected ist bei edit_*.php- Formularen befüllt, bei insert_*.php leer 
*/
    $html = '';
    $row_count=sizeof($options); 
    if ($row_count > 0) {
        // $html = '<select name="'.$keyname.'" required '.($multiple? ' multiple ' : '').'>' . PHP_EOL;
        $html = '<select name="'.$keyname.'">' . PHP_EOL;    
        if($add_null_option) {
            $html .= '<option value="" '.($key_selected=='' ? 'selected' : ''). '></option>'. PHP_EOL;
        }
        foreach($options as $key => $title) {
            $html .= ' <option value="' . $key . '"'.($key_selected==$key ? ' selected' : ''). '>' . $title . '</option>'. PHP_EOL;
            }
        $html .= '</select>';
    }
    return $html;
}
function get_html_select_multi($id, $options = [], $keyname='',$options_selected = []) {
    $html = '';
    $row_count=sizeof($options); 
    if ($row_count > 0) {
        $html = '<select id='.$id.' name="'.$keyname.'" multiple size="'.$row_count.'">' . PHP_EOL;     
        foreach($options as $key => $title) {
            $html .= ' <option value="' . $key .'" '.(in_array($key,$options_selected)?' selected':'').'>' . $title . '</option>'. PHP_EOL;
         }
        $html .= '</select>';
    }
    $html .='<br/><input type="button" id="btnReset_'.$id.'" value="Reset Filter" onclick="Reset_'.$id.'();" />  
    <script type="text/javascript">  
        function Reset_'.$id.'() {  
            var dropDown = document.getElementById("'.$id.'");  
            dropDown.selectedIndex = -1;  
        }  
    </script>';

    return $html;
}
function get_html_table($stmt, $edit_table_name='', $edit_newpage=false) {
    /* 
    * $edit_table_name <> '': die zugrundeliegende Abfrage muss Spalte "ID" für Tabelle enthalten 
    * edit_newpage=true:  dem Bearbeitungs-Link wird ein target="_blank" hinzugefügt 
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

function get_html_user_action_info($table_name, $action_name, $stmt_row_count=0,$ID=0){
    /* info zu einer neuen / aktualieserten / gelöschten ID einer Tabelle */ 
    $html=''; 

    $html.= '<p>Es wurden '.$stmt_row_count. ' Zeile(n) in Tabelle '.ucfirst($table_name) ; 
    switch ($action_name){
        case 'insert': 
            $html.= ' eingefügt.';  
            break; 
        case 'update': 
            $html.= ' aktualisiert.';  
            break;      
        case 'delete': 
            $html.= ' gelöscht.';  
            break;      
    }
    if ($ID > 0 ) {
        $html.= ' (ID '.$ID.')'; 
    }
    $html.= '</p>'; 
    return $html; 
}
function get_html_editlink($table_name, $ID, $edit_newpage=false){
    return '<p><a href="edit_'.$table_name.'.php?ID=' . $ID . '" ' . ($edit_newpage!='' ?'target="_blank"':''). '>[Tabelle '.ucfirst($table_name).' ID '.$ID.' bearbeiten]</a></p>';  
}

function get_html_showtablelink($table_name){
     return '<p><a href="show_table2.php?table=' . $table_name . '">[Tabelle '.ucfirst($table_name).' anzeigen]</a></p>';  
}
// function get_html_insertlink($table_name, $newpage=false){
//     return '<a href="insert_'.$table_name.'.php" ' . ($newpage!='' ?'target="_blank"':''). '>['.ucfirst($table_name).' erfassen]</a>';  
// }
function get_html_error_info($stmt, PDOException $e) {
    $html='<p style="color: red;">'; 
    $html.=$e->getMessage(); 
    $html.='<br>';     
    $html.='</p>'; 
    $stmt->debugDumpParams();  // ausgabe-Methode, kein Text 
    return $html;     
}
function get_html_user_error_info() {
    $html=''; 
    $html.='<p style="color: red;">Ein Fehler ist aufgetreten.</p>'; 
    return $html; 
}

  
?>
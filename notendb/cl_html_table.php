<?php 
class HtmlTable {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 
    public $show_table_link=false; // Tabellen-Namen als Link anzeigen 
    
    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows = count($this->result); 
    }
    
    function print_table($edit_table_name='', $edit_newpage=false) {
        /* 
        - $edit_table_name <> '': eine zusätzliche Spalte mit "Bearbeiten-Link" wird angezeigt. 
          Die zugrundeliegende Abfrage muss eine Spalte "ID" für diese Tabelle enthalten  
        - edit_newpage=true: dem Bearbeitungs-Link wird ein target="_blank" hinzugefügt
        - $show_del_link=true: eine zusätzliche Spalte mit Link für Löschfunktion wird angezeigt 
        - $del_form: Zielformular, wo das Löschen ausgeführt werden soll.  
        */ 
        
        $html = '';

        if ($this->count_cols > 0 & $this->count_rows > 0)
        {
            $html = '<table>';
            // header 
            $html .= '<thead>';
            $html .= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
                $html .= '<th>'.$colmeta['name'].'</th>';    
            }
            if ($edit_table_name!='') {
                $html .= '<th>Aktion</th>'. PHP_EOL;                     
            }         
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';
            // zeilen  
            if  ($this->count_rows > 0) {
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $cell){
                        if ($this->show_table_link) { 
                            // z.B. 1-spaltige Tabelle aus "show tables" 
                            $html .= '<td><a href="show_table2.php?table='.$cell.'">'.$cell.'</a></td>';
                        }
                        else {                        
                            $html .= '<td>'.$cell.'</td>'. PHP_EOL; 
                        }
                    }
                    if ($edit_table_name!='') {
                        $html .= '<td><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;                     
                    }                 
                    $html .= '</tr>'. PHP_EOL;
                } 
            }
            $html .= '</table>'; 
        }
        else {
           //  $html .= '<p>Keine Daten vorhanden.</p> '; 
        }
        echo $html;
    }

    function print_table_with_del_link(
                    $target_file
                , $parent_id_key
                , $parent_id_vaue
                ) {
        /* für Unterformulare mit Asoc-Tabellen, ohne Bearbeitungslink, mit Lösch-Link, 
            $target_form = Link auf php-datei mit mindestens "ID" Get-Parameter 
            Löschung bezieht sich auf ID der Asoc-Tabelle 
        */ 
        
        $html = '';

        if ($this->count_cols > 0 & $this->count_rows > 0)
        {
            $html .= '<table>';
            // header 
            $html .= '<thead>';
            $html .= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
                $html .= '<th>'.$colmeta['name'].'</th>';    
            }
            $html .= '<th>Aktion</th>'. PHP_EOL;                     
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';
            // zeilen  
            if  ($this->count_rows > 0) {
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $cell){
                        $html .= '<td>'.$cell.'</td>'. PHP_EOL; 
                    }
                    $html .= '<td><a href="'.$target_file.'?'.$parent_id_key.'='.$parent_id_vaue.'&ID='.$row["ID"].'&option=delete">Löschen</a></td>'. PHP_EOL;                
                    $html .= '</tr>'. PHP_EOL;
                } 
            }
            $html .= '</table>'; 
        }
        else {
           //  $html .= '<p>Keine Daten vorhanden.</p> '; 
        }
        echo $html;
    }

 }


?>
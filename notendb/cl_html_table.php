<?php 
class HtmlTable {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 
    
    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows = count($this->result); 
        // echo '<p>cl_html_table.php wurde initialisiert.'; 
    }
    
    function print_table($edit_table_name='', $edit_newpage=false) {
        /* 
        - $edit_table_name <> '': eine zusätliche Spalte mit "Bearbeiten-Link" wird angeziegt. 
          Die zugrundeliegende Abfrage muss eine Spalte "ID" für diese Tabelle enthalten  
        - edit_newpage=true: dem Bearbeitungs-Link wird ein target="_blank" hinzugefügt 
        */ 
        // echo '<br>count_cols: '.$this->count_cols; 
        // echo '<br>count_rows: '.$this->count_rows; 

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
        echo $html;
    }
 }


?>
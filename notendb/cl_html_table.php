<?php 
class HtmlTable {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 

    public $add_link_show=false; // falls eine "show_*.php" für ein Tabelle vorgesehen ist (akt. show_abfrage.php)
    public $add_link_delete=false; // 

    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows = count($this->result); 
    }
    
    function print_table($edit_table_name='', $edit_newpage=false, $edit_link='', $edit_title='') {
        /* 
        - $edit_table_name <> '': eine zusätzliche Spalte mit "Bearbeiten-Link" wird angezeigt. 
            Der Bearbeiten- Link wird nach folgender Systematik ausgegeben: edit_<$edit_table_name>.php?ID=<ID> 
        - $edit_newpage=true: dem Bearbeitungs-Link wird ein target="_blank" hinzugefügt
        - $edit_link <> '': Alternative für $edit_table_name (edit_table_name muss dann leer sein). 
            Verwendung für die Fälle, in denen  die Bearbeiten-Link - Systematik per $edit_table_name nicht geeignet ist.
            für Tabellen-Anzeigen in iframes und mind. 1 mitgelieferten Basis-Parameter (Beispiel: edit_sammlung_list_links.php) 
        */ 
        $html = '';

        if ($this->count_cols > 0 & $this->count_rows > 0)
        {
            $html = '<table class="resultset">';
            // header 
            $html .= '<thead>';
            $html .= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
                $html .= '<th class="resultset">'.$colmeta['name'].'</th>';    
            }
            if ($edit_table_name!='' or  $edit_link!='') {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }              
            if ($this->add_link_show) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }
            if ($this->add_link_delete) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }                       
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';
            // zeilen  
            if  ($this->count_rows > 0) {
                $html .= '<tbody>';                
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $key=>$cell){
                        // echo $key; 
                        if ($key=="URL") {
                            $html .= '<td class="resultset"><a href="'.$cell.'" target="_blank">'.$cell.'</a></td>'. PHP_EOL; 
                        } else {                     
                            $html .= '<td class="resultset">'.$cell.'</td>'. PHP_EOL; 
                        }
                    }

                    if ($edit_link!='') {
                        $html .= '<td class="resultset"><a href="'.$edit_link.'&ID='.$row["ID"].'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;                     
                    } elseif 
                    ($edit_table_name!='') {
                        $html .= '<td class="resultset"><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].($edit_title!=''?'&title='.$edit_title:'').'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;
                        // $html .= '<td><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;
                    } 
                    if ($this->add_link_show)  {
                        $html .= '<td class="resultset"><a href="show_'.$edit_table_name.'.php?ID='.$row["ID"].($edit_title!=''?'&title='.$edit_title:'').'"'. ($edit_newpage?' target="_blank"':''). '>Anzeigen</a></td>'. PHP_EOL;
                    }
                    if ($this->add_link_delete)  {
                        $html .= '<td class="resultset"><a href="delete_'.$edit_table_name.'.php?ID='.$row["ID"].($edit_title!=''?'&title='.$edit_title:'').'"'. ($edit_newpage?' target="_blank"':''). '>Löschen</a></td>'. PHP_EOL;
                    }                       
                    $html .= '</tr>'. PHP_EOL;
                } 
                $html .= '</tbody>';   
            }
            $html .= '</table>'; 
        }
        else {
           $html .= '<p>Keine Daten vorhanden.</p> '; 
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
            $html .= '<table class="resultset">';
            // header 
            $html .= '<thead>';
            $html .= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
                $html .= '<th class="resultset">'.$colmeta['name'].'</th>';    
            }
            $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';
            // zeilen  
            if  ($this->count_rows > 0) {
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $cell){
                        $html .= '<td class="resultset">'.$cell.'</td>'. PHP_EOL; 
                    }
                    $html .= '<td class="resultset"><a href="'.$target_file.'?'.$parent_id_key.'='.$parent_id_vaue.'&ID='.$row["ID"].'&option=delete">Löschen</a></td>'. PHP_EOL;                
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


    function print_table_tablelist() {
        /* 
        Verwendung in list_tables.php
        einspaltige Tabelle mit Objekt-Namen, die als Link ausgegeben werden  
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
       
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';
            // zeilen  
            if  ($this->count_rows > 0) {
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $key=>$cell){
                        // echo $key; 
                        $html .= '<td><a href="show_table2.php?table='.$cell.'">'.$cell.'</a></td>';                        

                    }
                    // if ($edit_table_name!='') {
                    //     $html .= '<td><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].($edit_title!=''?'&title='.$edit_title:'').'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;
                    //     // $html .= '<td><a href="edit_'.$edit_table_name.'.php?ID='.$row["ID"].'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;
                    // } 
                    // elseif   ($edit_link!='') {
                    //     $html .= '<td><a href="'.$edit_link.'&ID='.$row["ID"].'"'. ($edit_newpage?' target="_blank"':''). '>Bearbeiten</a></td>'. PHP_EOL;                     
                    // }  
                    
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
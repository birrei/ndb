<?php 
class HTML_Table {
    public $stmt;    
    public $result; 
    public $count_cols; 
    public $count_rows; 

    public $add_link_edit=true; // Spalte mit "Bearbeiten"-Link anzeigen  
    public $edit_link_table=''; // Tabelle, die bearbeitet werden soll 
    public $edit_link_title=''; // Anzeige-Titel für die über den Link geöffnete Seite 
    public $edit_link_filename=''; // alternative für Standard- "edit_*.php". $edit_link_table dann leer lassen! 
    public $edit_link_open_newpage=false; 
    public $edit_link_target_iframe=false; // Bearbeiten-Screen in iframe 

    public $add_link_edit2=false; // 
    public $edit2_link_filename=''; // 
    public $edit2_link_colname=''; 
    public $edit2_link_title=''; 

    public $add_link_delete=false; // Löschen- Spalte anzeigen 
    public $del_link_table=''; // Tabelle, aus der gelöscht werden soll  
    public $del_link_filename=''; //  alternative für Standard- "delete.php". $del_link_table dann leer lassen! 
    public $del_link_title=''; 
    public $del_link_open_newpage=false;
    public $del_link_parent_key='';
    public $del_link_parent_id='';
    public $del_link_count_params=1; // Anzahl Child-IDs, die im Link sichtar sein sollen 
    // XXX? public $del_option = 1; //

    public $add_link_show=false; // falls eine "show_*.php" für ein Tabelle vorgesehen ist (akt. show_abfrage.php)
    public $add_param_name; // für $add_link_show=true: "&Name=(wert im Name-Feld der Datenzeile)" ergänzen 

    public $show_missing_data_message=true; 
    public $show_row_count=false; 
    public $in_iframe=false; 

    public $table_width='100%'; // 

    function __construct($stmt) {
        $this->stmt = $stmt; 
        $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count_cols=$stmt->columnCount(); 
        $this->count_rows=$stmt->rowCount(); 
        // echo '<pre> Anzahl Zeilen: '.$this->count_rows.'</pre>'; // Test 
        // echo '<pre> Anzahl Spalten: '.$this->count_cols.'</pre>'; // Test 
    }
    
    
    function print_table2() {
 /* Verbesserung von print_table, ab jetzt diese verwenden! XXX  */
        $html = ''. PHP_EOL;

        if ($this->count_cols > 0 & $this->count_rows > 0)
        {
            $html.= '<style>

            td, th {
                text-align: left;
                vertical-align: top; 
            }

            table.resultset {
                border: 1px solid black;
                border-collapse: collapse; 
                font-size: 10pt;  
                margin: 0px; 
                padding: 0px;
                width: '.$this->table_width.';         
            }
            th.resultset {
                border: 1px solid black;
                background-color: lightgrey;    
                padding: 1px;       
            }
            td.resultset {
                border: 1px solid black;    
                padding: 2px;   
            }
            } 
            </style>'. PHP_EOL;             
            $html.= '<table class="resultset">'. PHP_EOL;
            $html.= '<thead>'. PHP_EOL;
            $html.= '<tr>'. PHP_EOL;
            for($i = 0; $i < $this->count_cols; ++$i) {
                $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
                $html .= '<th class="resultset">'.$colmeta['name'].'</th>'. PHP_EOL;    
            }
            if ($this->add_link_edit) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }            
            if ($this->add_link_delete) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }                       
            if ($this->add_link_show) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }
            if ($this->add_link_edit2) {
                $html .= '<th class="resultset">Aktion</th>'. PHP_EOL;                     
            }
                          
              
            $html .=  '</tr>'. PHP_EOL;
            $html .= '</thead>';

            if  ($this->count_rows > 0) {
                $html .= '<tbody>';                
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    foreach ($row as $key=>$cell){
                        if ($key=="URL") {
                            $html .= '<td class="resultset"><a href="'.$cell.'" target="_blank">'.$cell.'</a></td>'. PHP_EOL; 
                        }
                        elseif( substr($key, 0,5)=='Datum'){
                            $html .= '<td class="resultset">'.$this->getFormattedDate($cell).'</td>'. PHP_EOL; 
                        } else {                     
                            $html .= '<td class="resultset">'.$cell.'</td>'. PHP_EOL; 
                        }
                    }
                    if ($this->add_link_edit) {
                        if ($this->edit_link_filename!='') {
                            $html .= '<td class="resultset"><a href="'.$this->edit_link_filename.'?ID='.$row["ID"].'&option=edit';
                            $html .= ($this->edit_link_target_iframe?'&source=iframe':''); 
                            $html .= '"';                             
                            $html .= ($this->edit_link_open_newpage?' target="_blank"':'');                            
                            $html .= ' tabindex="-1">Bearbeiten</a></td>'. PHP_EOL;                     
                           // $html .= '<td class="resultset"><a href="'.$this->edit_link_filename.'?ID='.$row["ID"].'&option=edit"'. ($this->edit_link_open_newpage?' target="_blank"':''). ' tabindex="-1">Bearbeiten</a></td>'. PHP_EOL;                     

                        }
                        if ($this->edit_link_table!='') {
                            $html .= '<td class="resultset"><a href="edit_'.$this->edit_link_table.'.php?ID='.$row["ID"].'&option=edit'; 
                            $html .= ($this->edit_link_target_iframe?'&source=iframe':''); 
                            // XXX $html .= ($this->edit_link_title!=''?'&title='.$this->edit_link_title:'');  
                            $html .= '"';     
                            $html .= ($this->edit_link_open_newpage?' target="_blank"':'');
                            $html .= ' tabindex="-1">Bearbeiten</a></td>'. PHP_EOL;                                                                                 
                            
                            // $html .= '<td class="resultset"><a href="edit_'.$this->edit_link_table.'.php?ID='.$row["ID"].'&option=edit'.($this->edit_link_title!=''?'&title='.$this->edit_link_title:'').'"'. ($this->edit_link_open_newpage?' target="_blank"':''). ' tabindex="-1">Bearbeiten</a></td>'. PHP_EOL;

                        }                                        
                    }
                    if ($this->add_link_edit2) {
                        $html .= '<td class="resultset"><a href="'.$this->edit2_link_filename.'?ID='.$row[$this->edit2_link_colname].'&option=edit&title='.$this->edit2_link_title.'" target="_blank" tabindex="-1">'.$this->edit2_link_title.' bearbeiten</a></td>'. PHP_EOL;                                          
                    }
                    if ($this->add_link_show)  {
                        $html .= '<td class="resultset"><a href="show_'.$this->edit_link_table.'.php?ID='.$row["ID"].($this->edit_link_title!=''?'&title='.$this->edit_link_title:'').'&Name='.$row["Name"].'"'. ($this->edit_link_open_newpage?' target="_blank"':''). '>Anzeigen</a></td>'. PHP_EOL;                                     
                    }
                    if ($this->add_link_delete) {
                        if ($this->del_link_filename!='') {
                            switch($this->del_link_count_params) {
                                case 1: // 1 ChildID 
                                    $html .= '<td class="resultset"><a href="'.$this->del_link_filename.'?'.$this->del_link_parent_key.'='.$this->del_link_parent_id.'&ID='.$row["ID"].'&option=delete" tabindex="-1">Löschen</a></td>'. PHP_EOL;                     
                                break; 
              
                                case 2: // 2 Child-IDs 
                                    $html .= '<td class="resultset"><a href="'.$this->del_link_filename.'?'.$this->del_link_parent_key.'='.$this->del_link_parent_id.'&ID='.$row["ID"].'&ID2='.$row["ID2"].'&option=delete" tabindex="-1">Löschen</a></td>'. PHP_EOL;                     
                                break; 

                            }
                            // Standard-Verwendung: Verknüpfungs-Tabellen, schnelle Löschung
                            // im Link sind ParentID (z.B: SatzID) sowie Child-ID (zB. InstrumentID) definiert  

                        }
                        if ($this->del_link_table!='') {
                            // Standard-Verwendung: Löschung mit Bestätigungs-Dialog in delete.php
                            $html .= '<td class="resultset"><a href="delete.php?table='.$this->del_link_table.'&ID='.$row["ID"].($this->del_link_title!=''?'&title='.$this->del_link_title:'').'"'. ($this->del_link_open_newpage?' target="_blank"':'').' tabindex="-1">Löschen</a></td>'. PHP_EOL;  
                        }                                        
                    }                    
                    //    
                    $html .= '</tr>'. PHP_EOL;
                } 
                $html .= '</tbody>'. PHP_EOL;   
            }
            $html .= '</table>'. PHP_EOL; 
            $html .= ($this->show_row_count?'<pre>'.$this->count_rows.' Zeilen betroffen</pre>':''); 


        }
        else {
               // $html .= ($this->show_missing_data_message?'<pre>Keine Daten vorhanden.</pre>':''); 
               $html .= ($this->show_row_count?'<pre>'.$this->count_rows.' Zeilen betroffen</pre>':'');                
        }
        echo $html;
    }



    
    function print_table_checklist($checkbox_name) {
        /* $stmt: Tabelle Spalten ID, Name */
        $html = ''. PHP_EOL;

        if ($this->count_cols > 0 & $this->count_rows > 0){
            $html.= '<table class="checkboxtable">'. PHP_EOL;

            if  ($this->count_rows > 0) {
                $html .= '<tbody>';                
                foreach ($this->result as $row) {
                    $html .= '<tr>'. PHP_EOL;
                    $html .= '      <td class="checkboxtable"><label><input type="checkbox" name="'.$checkbox_name.'[]" value="'.$row["ID"].'"> '.$row["Name"].' </label> </td>'. PHP_EOL; 
                    $html .= '</tr>'. PHP_EOL;
                } 
                $html .= '</tbody>'. PHP_EOL;   
            }
            $html .= '</table>'. PHP_EOL; 
    
        }
        echo $html;
    }
       

    function datum_umwandeln($datum_string) {
        // Gemini ... 
        // Erstelle ein DateTime-Objekt aus dem Eingabe-String
        $datum_objekt = DateTime::createFromFormat('Y-m-d', $datum_string);
    
        // Überprüfe, ob das Datum erfolgreich erstellt wurde
        if ($datum_objekt) {
            // Formatiere das Datum in das gewünschte Format 'TT.MM.JJJJ'
            return $datum_objekt->format('d.m.Y');
        } else {
            // Gib einen Fehler zurück, wenn das Datum ungültig ist
            return "Ungültiges Datumsformat";
        }
    }

    function getFormattedDate($date_in) {
        //  return $date_in; 
        if (gettype($date_in) == 'NULL') {
            return $date_in; 
        } else {
            $date = new DateTimeImmutable($date_in);
            return $date->format('d.m.Y');
        }
    }

    
//     function print_table_tablelist() {
//         /* 
//         Verwendung in list_tables.php
//         einspaltige Tabelle mit Objekt-Namen, die als Link ausgegeben werden  
//         */
 
//         $html = '';

//         if ($this->count_cols > 0 & $this->count_rows > 0)
//         {
//             $html = '<table>';
//             // header 
//             $html .= '<thead>';
//             $html .= '<tr>'. PHP_EOL;
//             for($i = 0; $i < $this->count_cols; ++$i) {
//                 $colmeta=$this->stmt->getColumnMeta($i); // assoz. array 
//                 $html .= '<th>'.$colmeta['name'].'</th>';    
//             }
       
//             $html .=  '</tr>'. PHP_EOL;
//             $html .= '</thead>';
//             // zeilen  
//             if  ($this->count_rows > 0) {
//                 foreach ($this->result as $row) {
//                     $html .= '<tr>'. PHP_EOL;
//                     foreach ($row as $key=>$cell){
//                         // echo $key; 
//                         $html .= '<td><a href="show_table2.php?table='.$cell.'">'.$cell.'</a></td>';                        

//                     }
                    
//                     $html .= '</tr>'. PHP_EOL;
//                 } 
//             }
//             $html .= '</table>'; 
//         }
//         else {
//            $html .= '<p>Keine Daten vorhanden.</p> '; 
//         }
//         echo $html;
//     }


 }


?>
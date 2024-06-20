<?php 
class HtmlInfo {
    public $html;
    public $info_datetime;     
    
    function __construct() {
        $this->html = ''; 
        $this->info_datetime = date("d.m.Y H:i:s", time());
    }
   
    function print_user_error() {
        $this->html='<p style="color: red;">Ein Fehler ist aufgetreten.</p>'; 
        echo $this->html; 
    }

    function print_error($stmt, PDOException $e) {
        $this->html='<p style="color: red;">'; 
        $this->html.=$e->getMessage(); 
        $this->html.='</p>'; 
        // $stmt->debugDumpParams();  // ausgabe-Methode, kein Text 
        echo $this->html;     // produktiv auskommentieren! 
    }
    
    function print_action_info($ID, $action_name){
        $this->html.= '<p style="color: blue;">'; 
        $this->html.=$this->info_datetime;                
        $this->html.= ' - ID '.$ID.' ';  

        switch ($action_name){
            case 'view': 
                $this->html.= ' wird angezeigt.'; 
                // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($edit_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
                break;             
            case 'insert': 
                $this->html.= ' wurde erfasst.'; 
                // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($edit_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
                break; 
            case 'update': 
                $this->html.= ' wurde aktualisiert.';  
                // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '">[Zeile bearbeiten]</a></p>';  
                break;      
            case 'delete': 
                $this->html.= ' wurde gelöscht.';  
                break;      
        }
 
        $this->html.= '</p>';        
        echo $this->html; 
    }

    function print_close_form_info() {
        $this->html='<p style="color: blue;">Nach Abschluss der Bearbeitung Fenster per STRG + W schließen</p>'; 
        echo $this->html; 
    }

    function print_table_link($table_name, $sortcol='Name', $sortorder='ASC')  {
        echo '<p><a href="show_table2.php?table='.$table_name.'&sortcol='.$sortcol.'&sortorder='.$sortorder.'" target="_blank">Tabelle anzeigen</a> (es öffnet sich ein neues Fenster)</p>'; 
    } 

}
?>
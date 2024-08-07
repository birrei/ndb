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
                // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($open_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
                break;             
            case 'insert': 
                $this->html.= ' wurde erfasst.'; 
                // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($open_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
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
        // echo $this->html; // XXX Ausgabe evt. nicht wirklich hilfeich, weiter beboachten 
        echo ''; 
    }

    function print_close_form_info() {
        $this->html='<p style="color: blue;">Nach Abschluss der Bearbeitung Fenster per STRG + W schließen</p>'; 
        echo $this->html; 
    }

    // function print_table_link($table_name, $sortcol='Name', $sortorder='ASC')  {
    //     echo '<p><a href="show_table2.php?table='.$table_name.'&sortcol='.$sortcol.'&sortorder='.$sortorder.'" target="_blank">Tabelle anzeigen</a> (es öffnet sich ein neues Fenster)</p>'; 
    // } 

    function print_link_table($target_table, $sortinfo, $target_title, $show_newtab=false, $additional_params='', $suffix='') {
        echo '<a href="show_table2.php?table='.$target_table.'&'.$sortinfo.'&title='.$target_title.($additional_params!=''?$additional_params:'').'"'.($show_newtab?' target="_blank"':'').' tabindex="-1">Alle '.$target_title.' anzeigen</a>'.($suffix!=''?$suffix:'');

    }

/* Standard-Verlinkungen */

    function print_link_edit($target_table,$ID, $target_title, $newpage=true, $suffix='') {
        echo '<a href="edit_'.$target_table.'.php?ID='.$ID.'&title='.$target_title.'&option=edit"'.($newpage?' target="_blank"':'').' tabindex="-1">'.$target_title.' bearbeiten</a>'.($suffix!=''?$suffix:'');
    }

    function print_link_insert($target_table, $target_title, $newpage=true, $suffix='') {
        echo '<a href="edit_'.$target_table.'.php?title='.$target_title.'&option=insert"'.($newpage?' target="_blank"':'').' tabindex="-1">'.$target_title.' neu erfassen</a>'.($suffix!=''?$suffix:'');
    }

    function print_link_delete_row($target_table, $ID, $target_title, $newpage=true, $suffix='') {
        echo '<a href="delete_'.$target_table.'.php?ID='.$ID.'&title='.$target_title.' löschen"'.($newpage?' target="_blank"':'').' tabindex="-1">'.$target_title.' löschen</a>'.($suffix!=''?$suffix:'');
    }


/* Seiten-Überschriften */   

    function print_screen_header($header_text, $suffix='') {
        echo '<span style="font-size:15pt;font-weight:bold;padding-top: 10px">'.$header_text.($suffix!=''?$suffix:'').'</span>';

    }

}



?>
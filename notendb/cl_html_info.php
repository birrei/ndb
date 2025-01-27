<?php 
class HtmlInfo {
    public $html;
    public $info_datetime;
    public $option_linktext=0; // Ausführlichkeit Linktext. 0 = ohne Titel (z.B: "bearbeiten"), 1 = mit Titel (z.B. "Verwendungszweck bearbeiten")      
    public $use_paragraph=false; // true: "<p>..</p>" ergänzen 
    public $source=''; // mögl. Werte: iframe, table 

    function __construct() {
        $this->html = ''; 
        $this->info_datetime = date("d.m.Y H:i:s", time());
    }
   
    function print_user_error($text='') {
        if ($text!='') {
            $this->html='<p style="color: red;">'.$text.'</p>'; 
        } else {
            $this->html='<p style="color: red;">Ein Fehler ist aufgetreten.</p>'; 
        }

        echo $this->html; 
    }

    function print_info($info) {
        $this->html='<p style="font-family: Courier;">'; 
        $this->html.=$this->info_datetime.': '.$info;         
        $this->html.='</p>'.PHP_EOL; 
        echo $this->html;    
    }    
    function print_error($stmt, PDOException $e) {
        $this->html='<p style="color: red;">'; 
        $this->html.=$e->getMessage(); 
        $this->html.='</p>'; 
        // $stmt->debugDumpParams();  // ausgabe-Methode, kein Text 
        echo $this->html;     // produktiv auskommentieren! 
    }

    function print_close_form_info() {
        $this->html='<p style="color: blue;">Nach Abschluss der Bearbeitung Fenster per STRG + W schließen</p>'; 
        echo $this->html; 
    }

    function print_link_table($target_table, $sortinfo, $target_title, $show_newtab=false, $additional_params='', $suffix='') {
        /** Link auf Seite show_table2.php */
        switch($this->option_linktext) {
            case 0:
                echo '<a href="show_table2.php?table='.$target_table.'&'.$sortinfo.'&title='.$target_title.($additional_params!=''?$additional_params:'').'"'.($show_newtab?' target="_blank"':'').' tabindex="-1" class="form-link">Tabelle anzeigen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
                break; 

            case 1: 
                echo '<a href="show_table2.php?table='.$target_table.'&'.$sortinfo.'&title='.$target_title.($additional_params!=''?$additional_params:'').'"'.($show_newtab?' target="_blank"':'').' tabindex="-1" class="form-link">'.$target_title.' anzeigen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
                break; 
        }
    }

/* Standard-Verlinkungen */


    function print_link($link_url, $link_text) {
        echo ($this->use_paragraph?'<p>':'').'<a href="'.$link_url.'" tabindex="-1" class="form-link">'.$link_text.'</a>'.($this->use_paragraph?'</p>':''); 
    }
    function print_link_backToList($link_url) {
        echo ($this->use_paragraph?'<p>':'').'<a href="'.$link_url.'" tabindex="-1" class="form-link">Zurück zur Liste</a>'.($this->use_paragraph?'</p>':''); 
    }    
    

    function print_link_edit($target_table, $ID, $target_title, $newpage=true, $suffix='') {
        echo ($this->use_paragraph?'<p>':'')
            .'<a href="edit_'.$target_table.'.php?ID='.$ID
            .'&source='.$this->source
            .'&title='.$target_title.'&option=edit"'
            .($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">Bearbeiten</a>'
            .($suffix!=''?$suffix:'')
            .($this->use_paragraph?'</p>':'');
       
       // echo ($this->use_paragraph?'<p>':'').'<a href="edit_'.$target_table.'.php?ID='.$ID.'&title='.$target_title.'&option=edit"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">Bearbeiten</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
    }
    
    function print_link_edit2($target_table, $ID, $target_title, $newpage=true, $suffix='') {
        // für ev. 2. Version eines Bearbeitungsformualrs 
        // echo '<a href="edit_'.$target_table.'2.php?ID='.$ID.'&title='.$target_title.'&option=edit"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">'.$target_title.' bearbeiten</a>'.($suffix!=''?$suffix:'');
        echo ($this->use_paragraph?'<p>':'').'<a href="edit_'.$target_table.'2.php?ID='.$ID.'&title='.$target_title.'&option=edit"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">Abfrage-Text bearbeiten</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
    }


    function print_link_insert($target_table, $target_title, $newpage=true, $suffix='') {
        echo ($this->use_paragraph?'<p>':'').'<a href="edit_'.$target_table.'.php?title='.$target_title.'&option=insert"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">'.$target_title.' neu erfassen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
        // Nur "neu erfassen", ohne Titel-Bezeichnung 
        // echo '<a href="edit_'.$target_table.'.php?title='.$target_title.'&option=insert"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">Neu erfassen</a>'.($suffix!=''?$suffix:'');
    
    }

    function print_link_delete_row2($target_table, $ID, $target_title, $newpage=false, $suffix='') {
        $html=''; 
        $html.=($this->use_paragraph?'<p>':''); 
        // $html.='<a href="delete.php?table='.$target_table.'&ID='.$ID.'&title='.$target_title.' löschen"'; 
        $html.='<a href="delete.php?table='.$target_table.'&ID='.$ID; 
        $html.='&source='.$this->source;
        $html.='"'; 
        $html.=($newpage?' target="_blank"':''); 
        $html.= ' tabindex="-1" class="form-link">'.$target_title.' löschen</a>'; 
        $html.=($this->use_paragraph?'</p>':''); 
        echo $html; 

        // echo ($this->use_paragraph?'<p>':'')
        // .($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">'.$target_title.' löschen</a>'.($suffix!=''?$suffix:'').
        // ($this->use_paragraph?'</p>':'');

        // echo ($this->use_paragraph?'<p>':'').'<a href="delete.php?table='.$target_table.'&ID='.$ID.'&title='.$target_title.' löschen"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">'.$target_title.' löschen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
    
    }

    function print_link_reload() {
        echo ($this->use_paragraph?'<p>':'').'<a href="" tabindex="-1" class="form-link">Formular neu laden</a>'.($this->use_paragraph?'</p>':''); 
    }


/* Seiten-Überschriften */   

    function print_screen_header($header_text, $suffix='') {
        echo '<span style="font-size:15pt;font-weight:bold;padding-top: 10px;margin-right: 20px;">'.$header_text.($suffix!=''?$suffix:'').'</span>';

    }

    // function print_action_info($ID, $action_name){
    //     $this->html.= '<p style="color: blue;">'; 
    //     $this->html.=$this->info_datetime;                
    //     $this->html.= ' - ID '.$ID.' ';  

    //     switch ($action_name){
    //         case 'view': 
    //             $this->html.= ' wird angezeigt.'; 
    //             // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($edit_link_open_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
    //             break;             
    //         case 'insert': 
    //             $this->html.= ' wurde erfasst.'; 
    //             // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '"' . ($edit_link_open_newpage!='' ?' target="_blank"':''). '>[Zeile bearbeiten]</a></p>';  
    //             break; 
    //         case 'update': 
    //             $this->html.= ' wurde aktualisiert.';  
    //             // $html.=  '<a href="edit_'.$table_name.'.php?ID=' . $ID . '">[Zeile bearbeiten]</a></p>';  
    //             break;      
    //         case 'delete': 
    //             $this->html.= ' wurde gelöscht.';  
    //             break;      
    //     }
 
    //     $this->html.= '</p>';        
    //     // echo $this->html; // XXX Ausgabe evt. nicht wirklich hilfeich, weiter beboachten 
    //     echo ''; 
    // }    

}



?>
<?php 
class HTML_Info {
    public $html;
    public $info_datetime;
    public $option_linktext=0; // Ausführlichkeit Linktext. 0 = ohne Titel (z.B: "bearbeiten"), 1 = mit Titel (z.B. "Verwendungszweck bearbeiten")      
    public $use_paragraph=false; // true: "<p>..</p>" ergänzen 
    public $source=''; // mögl. Werte: iframe, table 

    function __construct() {
        $this->html = ''; 
        $this->info_datetime = date("d.m.Y H:i:s", time());
    }
   

    /* Standard-Verlinkungen */


    function print_link_table($target_table, $sortinfo, $target_title, $show_newtab=false, $additional_params='', $suffix='') {
        echo '<a href="show_table2.php?table='.$target_table.'&'.$sortinfo.'&title='.$target_title.($additional_params!=''?$additional_params:'').'"'.($show_newtab?' target="_blank"':'').' tabindex="-1" class="form-link">Daten anzeigen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
    }

    function print_link_table2($Ansicht, $show_newtab=false, $additional_params='', $suffix='') {
        echo '<a href="show_table4.php?ansicht='.$Ansicht.'" '.($show_newtab?' target="_blank"':'').' tabindex="-1" class="form-link">Daten anzeigen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
    }

    function print_link($link_url, $link_text) {
        echo ($this->use_paragraph?'<p>':'').'<a href="'.$link_url.'" tabindex="-1" class="form-link">'.$link_text.'</a>'.($this->use_paragraph?'</p>':''); 
    }
    
    function print_link_backToList($link_url) {
        echo ($this->use_paragraph?'<p>':'').'<a href="'.$link_url.'" tabindex="-1" class="form-link">Zurück zur Liste</a>'.($this->use_paragraph?'</p>':''); 
    }    

    function print_link_edit($target_table, $ID, $target_title='', $newpage=true, $suffix='') {
        // echo $target_title; XXX entfernen s
        echo ($this->use_paragraph?'<p>':'')
            .'<a href="edit_'.$target_table.'.php?ID='.$ID
            .'&source='.$this->source
            .'&option=edit"'
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
        echo ($this->use_paragraph?'<p>':'').'<a href="edit_'.$target_table.'.php?title='.$target_title.'&option=insert"'.($newpage?' target="_blank"':'').' tabindex="-1" class="form-link">neu erfassen</a>'.($suffix!=''?$suffix:'').($this->use_paragraph?'</p>':'');
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


    function print_link_overview($target_file, $target_params, $target_title, $use_paragraph=false) {
        echo ($use_paragraph?'<p>':'').'<a href="'.$target_file.'?'.$target_params.'" target="_blank" tabindex="-1" class="form-link">'.$target_title.'</a>'.($use_paragraph?'</p>':'');
    }        

/* Seiten-Überschriften */   

    function print_screen_header($header_text, $suffix='') {
        echo '<span style="font-size:15pt;font-weight:bold;padding-top: 10px;margin-right: 20px;">'.$header_text.($suffix!=''?$suffix:'').'</span>';
    }


 /* Info-Texte */   

    function print_info_copy ($item_name, $ID_ref, $ID_new, $target_filename) {
        /* INfo/Link, der nach einem Kopiervorgang angezeigt wird  */
        $html='<p class="info"> &#9432; Neue '.$item_name.' ID: '.$ID_new
        .' (kopiert von <a href="'.$target_filename.'.php?ID='
        .$ID_ref.'&option=edit&title='.$item_name.'" target="_blank">'.$item_name.' ID '.$ID_ref.'</a>)</p>'; 
        echo $html; 
    }

    function print_user_error($text='') {
        if ($text!='') {
            $this->html='<p style="color: red;">'.$text.'</p>'; 
        } else {
            $this->html='<p style="color: red;">Ein Fehler ist aufgetreten.</p>'; 
        }

        echo $this->html; 
    }

    function print_info($text) {
        echo '<p class="info">'.$text.'</p>'.PHP_EOL;   
    }
    
    function print_warning($text) {
        echo '<p class="warning">'.$text.'</p>'.PHP_EOL;   
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



/* Formulare */   


    function print_form_inline($option, $ID, $title, $action, $method='post') {
        // nur konkrete IDs, keine Ausgabe falls ID leer ist 
        if($ID!='') {
            echo '<form action="#" method="'.$method.'" style="display:inline;">
            <input type="hidden" name="ID" value="' . $ID. '">
            <input type="hidden" name="option" value="'.$option.'">      
            <input type="submit" name="senden" value="'.$title.' '.$action.'">             
            </form>
            '; 
        }

    }




    function print_form_confirm($filename,$ID, $option,$aktion, $text='') {

        
        echo 
        '<p>'.($text!=''?$text:'').'<br><form action="'.$filename.'" method="post">
        <input type="hidden" name="ID" value="' . $ID. '">
        <input type="hidden" name="option" value="'.$option.'">      
        <input type="submit" name="senden" value="'.$aktion.' bestätigen"  style="color:red">             
        </form>
        </p>
        '; 


    }

    function print_form_delete_confirm($filename, $Bezeichnung, $ID, $Name) {

        $tmpText='Soll '.$Bezeichnung.' ID '.$ID.' '; 
        $tmpText.=($Name!=''?', "'.$Name.'" ':' ');
        $tmpText.='wirklich gelöscht werden?'; 
        
        echo '<p style="color: red;">'.$tmpText.'<br>
        <form action="'.$filename.'" method="post">
        <input type="hidden" name="ID" value="' . $ID. '">
        <input type="hidden" name="option" value="delete_2">      
        <input type="submit" name="senden" value="Löschung bestätigen"  style="color:red">             
        </form>
        </p>
        '; 


    }    


}



?>
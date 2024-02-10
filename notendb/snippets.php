<?php 
function select($options = [], $keyname='') {
    // https://werner-zenk.de/php/auswahlliste_aus_dem_inhalt_einer_db-spalte_erstellen.php
    // Auswahlliste aus dem Inhalt von zwei DB-Spalten erstellen
    $html = '';
    if (sizeof($options) > 0) {
    $html = '<select name="'.$keyname.'">' . PHP_EOL;
    foreach($options as $key => $title) {
        $html .= ' <option value="' . $key . '">' . $title . '</option>'. PHP_EOL;
        }
    $html .= '</select>';
    }
    return $html;
    }
    
?>
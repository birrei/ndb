<?php
$PageTitle='Test Ferientage importieren'; 
include_once('head.php');
include_once('classes/class.htmlinfo.php');
include_once('classes/class.schuljahr.php');

// $Task=1;  // 'Ferien importieren'; 
$Task=2;  // 'Feiertage importieren'; 

$strSchuljahr='2026/2027'; 

$schuljahr = new Schuljahr(); 
$SchuljahrID= $schuljahr->getIDFromName($strSchuljahr); 

$ics_file=''; 

/************************************************** */

switch($Task) {
    case 1; // Ferientage 
        $ics_file='https://www.feiertage-deutschland.de/kalender-download/ics/schulferien-baden-wuerttemberg.ics'; 
        break; 
    case 2; // Feiertage 
        $ics_file='https://www.feiertage-deutschland.de/kalender-download/ics/feiertage-deutschland.ics'; // enthält scheinbar nur Feiertage, die ausserhalb von bundesweiten Ferienzeiten liegen 
        // $ics_file='https://ics.tools/Feiertage/baden-w%C3%BCrttemberg.ics'; // nur akt. Jahr, nicht brauchbar 
        break; 
}

echo 'ICS-Datei: '.$ics_file.'<br>'; 

$arr_ics_data = parseIcsFile($ics_file); // Datei auslesen. Ergebnis ist ein zweidimensionales Array. 

uasort($arr_ics_data, function ($a, $b) {
    return $a['start'] <=> $b['start'];
});

switch($Task) {
    case 1; 
        
        break; 
    case 2; 

       break; 
}



foreach ($arr_ics_data as $arr_eintrag) {
    // echo "<pre>";
    // print_r($arr_eintrag);
    // echo "</pre>";
    $Datum_ics = $arr_eintrag["start"];  
    $Datum = DateTime::createFromFormat('Ymd', $Datum_ics)->format('Y-m-d');
    $Bezeichnung = $arr_eintrag["title"]; 
    $Bundesland = $arr_eintrag["location"]; 

    echo '<br>Datum: '.$Datum.', Bezeichnung: '.$Bezeichnung.', Bundesland: '.$Bundesland; 

    // foreach ($arr_eintrag as $eintrag=>$info) {
    //         echo($eintrag.': '.$info.'<br>');    
       
    // }  
}



// echo "<pre>";
// print_r($arr_ics_data);
// echo "</pre>";


// uasort($arr_ics_data_akt, function ($a, $b) {
//     return $a['start'] <=> $b['start'];
// });


// echo "<pre>";
// print_r($arr_ics_data_akt);
// echo "</pre>";



// function getCalDataYear($arrIn, $strYear) {
//     $filter=$strYear; 
//     $arrOut = array_filter($arrIn, function($element) {
//         return str_starts_with($element['start'], $filter);
//     });
//     return $arrOut; 
// }


function parseIcsFile($filePath) {

    // https://share.google/aimode/uF1bymW34xL8Xnoso

    // das funktioniert nicht bei Online-Dateien? 
    // if (!file_exists($filePath)) {
    //     return "Datei nicht gefunden.";
    // }

    $content = file_get_contents($filePath);
    
    // Normalisiert Zeilenumbrüche (wichtig für ICS)
    $content = str_replace(array("\r\n", "\r"), "\n", $content);
    
    // Holt alle Event-Blöcke (BEGIN:VEVENT bis END:VEVENT)
    preg_match_all('/BEGIN:VEVENT(.*?)END:VEVENT/si', $content, $matches);
    
    $events = [];

    foreach ($matches[1] as $eventBlock) {
        $event = [];
        
        // Extrahiert die gängigsten Felder per Regex
        if (preg_match('/SUMMARY:(.*)$/m', $eventBlock, $summary)) {
            $event['title'] = trim($summary[1]);
        }
        if (preg_match('/DTSTART[;:][^:]*:(.*)$/m', $eventBlock, $dtstart)) {
            $event['start'] = trim($dtstart[1]);
        }
        if (preg_match('/DTEND[;:][^:]*:(.*)$/m', $eventBlock, $dtend)) {
            $event['end'] = trim($dtend[1]);
        }
        if (preg_match('/LOCATION:(.*)$/m', $eventBlock, $location)) {
            $event['location'] = trim($location[1]);
        }
        if (preg_match('/DESCRIPTION:(.*)$/m', $eventBlock, $description)) {
            $event['description'] = trim($description[1]);
        }

        $events[] = $event;
    }

    return $events;
}


// $ferien_data = file_get_contents($ferien_file);

// $lines  = explode("\n", $ferien_data);

// print_r($lines); 

// $columns = explode("\t", $lines[0]);

// // print_r($columns); 

// foreach ($columns as $column) {
//         echo $column; 
// }



//  $arr = array(1, 2, 3, 'tier1'=>'hund', 'tier2'=>'katze', 'tier3'=>'maus');
// // Diese foreach-Schleife gibt alle Werte des Arrays (jeweils mit Schlüssel) aus
// foreach ($arr as $key=>$val) {
//     echo("$key: $val, ");
// }


include_once('foot.php');
?>


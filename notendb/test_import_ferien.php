<?php
$PageTitle='Test Ferientage importieren'; 
include_once('head.php');
include_once('classes/class.htmlinfo.php');


// $icsData = parseICS($ferien_file);

// // Ausgabe der Ergebnisse
// echo "<pre>";
// print_r($icsData);
// echo "</pre>";


// $ferien_file='https://www.feiertage-deutschland.de/kalender-download/ics/schulferien-baden-wuerttemberg.ics'; 
// $feiertage_file='https://www.feiertage-deutschland.de/kalender-download/ics/feiertage-deutschland.ics'; 

// Beispiel-Aufruf:
// $icsDatei = 'kalender.ics'; // Pfad zu Ihrer ICS-Datei

$ferien_file='https://www.feiertage-deutschland.de/kalender-download/ics/schulferien-baden-wuerttemberg.ics'; 

$terminListe = parseIcsFile($ferien_file);

// Ausgabe der Daten
echo "<pre>";
print_r($terminListe);
echo "</pre>";


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


include_once('foot.php');
?>

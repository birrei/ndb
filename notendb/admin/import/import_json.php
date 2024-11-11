<?php 
include('../../head.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php"); 
include("../../cl_link.php"); 
?> 

<h3>Import Google Chrome Bookmarks </h3>    
<p>Aufgabe: Eine Reihe von Bookmarks (die sich alle in einem Ordner befinden) soll im JSON-Format exportiert 
  und anschließend in die Datenbank (Tabelle link_tmp) werden. Für den Json-Export wird das Chrome-Addin "JSON-XLS" verwendet.</p>
<ol>
<li> Chrome-Erweiterung  <a href="https://chromewebstore.google.com/detail/export-historybookmarks-t/dcoegfodcnjofhjfbhegcgjgapeichlf" 
target="_blank">JSON-XLS</a> installieren
</li>
<li>
Bookmarks als JSON- Datei exportieren
</li>
<li>
JSON-Datei öffnen und bereinigen: Nur gewünschte Bookmark-Elemente (ohne Sammel-Ordner) belassen. Prüfen: 
<br />* die Elemente sollten  alle die gleiche "parentId" (="id" des o.a. Sammel-Ordners) aufweisen 
<br />* Die Attribute "url" und "title" müssen vorhanden sein 
</li>
<li>
Datei umbenennen zu "data.json" und im Verz. "admin\import" ablegen 
</li>
<li>
Test: <a href="data.json" target="_blank">Datei anzeigen</a> (neues Browserfenster), Struktur prüfen 
</li>

<li>
Test: <a href="import_json.php?filename=data.json&option=show">Daten auslesen</a> (Anzeige s.u.), Struktur prüfen 
</li>

<li>
Falls OK: <a href="import_json.php?filename=data.json&option=import">Import starten</a> 
(Daten werden in Tabelle "link_tmp" eingelesen, der Inhalt der Tabelle wird unten angezeigt)
</li>

</ol>




<p> | </p>

<?php 

if (isset($_GET["filename"])) {
    if ($_GET["filename"]=='data.json') {

        $json = file_get_contents('data.json'); 

        // Check if the file was read successfully
        if ($json === false) {
          die('Error reading the JSON file');
        }

        // Decode the JSON file
        $json_data = json_decode($json, true); 

        // Check if the JSON was decoded successfully
        if ($json_data === null) {
            die('Error decoding the JSON file');
        }

        // Display data
        switch($_GET["option"]) {
            case "show": 
              echo "<pre>";
              print_r($json_data);
              echo "</pre>";
            break; 

            case "import": 
              $link = new Link(); 
              $link->truncate_link_tmp(); 
              for ($i = 0; $i < count($json_data); $i++) {
                  // echo $json_data[$i]["title"].'<br>'; // test 
                $link->insert_link_tmp($json_data[$i]["url"], $json_data[$i]["title"] ); 
              }
              $link->print_link_tmp(); 

            break; 

        }
    }
}



?> 

<?php 


include('../foot.php');

?>


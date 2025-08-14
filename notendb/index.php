<?php 
include_once('head.php');
?>

<style>
table.start, td.start {
  border-style: solid;
  border-color: lightgray;
  border-collapse: collapse;
  padding-right: 10px;  
  font-size: 13pt;  
   
}
h1 {
    background-color: lightblue; 
}
h3 {
    background-color: greenyellow; 
    margin-top: 0px; 
}
a {
  text-decoration: none; 
  color: black; /* Setzt die Linkfarbe auf blau */
}
a:hover {
  text-decoration: underline; 
  color: blue; /* Setzt die Linkfarbe auf blau */
}



</style>

<h1> Notendatenbank   </h1>

<table class="start">
<tr> 
    <td class="start"><h3>Daten</h3></td>
    <td class="start">
              <a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&show_filter">Sammlungen</a> (Sammlungen, Musikstücke, Sätze)<br>
              <!-- <a href="edit_sammlung.php?title=Sammlung&option=insert">Neu erfassen</a>  -->

              <a href="show_table2.php?table=v_material&sortcol=Name">Material</a> <br>    
            
            <a href="show_table2.php?table=v_schueler&sortcol=Name">Schüler</a> <br>  
            <a href="show_table2.php?table=v_uebung&sortcol=ID&sortorder=DESC">Übungen</a> <br>  
            </td>
           </tr>    




      <tr> <td class="start"> <h3>Stammdaten</h3></td> 
      <td class="start">
            <a href="show_table2.php?table=standort&sortcol=Name">Standorte</a> <br> 

      <a href="show_table2.php?table=verlag&sortcol=Name">Verlage</a> <br>  


              <a href="show_table2.php?table=v_komponist&sortcol=Name">Komponisten</a> <br> 
              <a href="show_table2.php?table=besetzung&sortcol=Name">Besetzungen</a> <br> 
              <a href="show_table2.php?table=verwendungszweck&sortcol=Name">Verwendungszwecke</a> <br> 
              <a href="show_table2.php?table=gattung&sortcol=Name">Gattungen</a> <br> 
              <a href="show_table2.php?table=epoche&sortcol=Name">Epochen</a> <br> 

            <a href="show_table2.php?table=erprobt&sortcol=Name">Erprobt-Eigenschaften</a> <br> 
            <a href="show_table2.php?table=schwierigkeitsgrad&sortcol=Name">Schwierigkeitsgrade</a> <br> 
            <a href="show_table2.php?table=instrument&sortcol=Name">Instrumente</a> <br> 
            <!-- <a href="show_table2.php?table=v_lookup&sortcol=LookupTypeName,Name">Besonderheiten</a> <br>  -->
            <a href="show_table2.php?table=v_besonderheiten&sortcol=Name">Besonderheiten</a> <br> 
            <!-- <a href="show_table2.php?table=lookup_type&sortcol=Name">Besonderheit Typen</a>  -->
            <a href="show_table2.php?table=v_besonderheittypen&sortcol=Name">Besonderheit Typen</a> <br> 
            <a href="show_table2.php?table=materialtyp&sortcol=Name">Materialtypen</a>  <br>           

            <a href="show_table2.php?table=status&sortcol=Name">Status Ausprägungen</a> (Status Schüler Satz/Material-Zuordnung)<br> 

            <a href="show_table2.php?table=uebungtyp&sortcol=Name">Übung Typen</a> <br> 
            <a href="show_table2.php?table=linktype&sortcol=Name">Link-Typen</a> <br> 
            <a href="show_table2.php?table=abfragetyp&sortcol=Name">Abfrage-Typen</a> <br>             

        </td>
      </tr>


      <tr> <td class="start"> <h3>Abfragen, Auswertungen</h3> </td> 
      <td class="start">
      <a href="show_table3.php">Verwendungszweck Planung</a> (Anzeige Gesamt - Spieldauer)  <br>
      <a href="show_table2.php?table=v2_info_Tempobezeichnungen&sortcol=Tempobezeichnung">Verwendete Tempobezeichnungen</a> <br> 
      <a href="show_table2.php?table=v2_info_Spieldauern&sortcol=Spieldauer">Verwendete Spieldauern</a> <br> 
      <a href="tests.php?title=Tests">Vordefinierte Tests</a>   <br> 
      <a href="show_table2.php?table=v_abfrage&sortcol=Name&add_link_show">Gespeicherte Abfragen</a> (z.B. Abfragen aus Suche)<br>                                     
      </td>
      
      </tr>        
          

      <tr> 
          <td class="start"> <h3>Repository</h3> </td> 
          <td class="start">    
            <a href="https://github.com/birrei/ndb/tree/main" tabindex="-1" target="_blank">GitHub Startseite</a><br> 
            <a href="https://github.com/birrei/ndb/blob/main/changelog.md" tabindex="-1" target="_blank">Changelog</a> (Beschreibung neuer Funktionen sowie Fehlerkorrekturen) <br>
            <a href="https://github.com/birrei/ndb/commits/main/" tabindex="-1" target="_blank">Commits</a> (Vollständige techn. Änderungs-Historie) <br>
            <a href="https://github.com/birrei/ndb/blob/main/notes.md" tabindex="-1" target="_blank">Notizen</a> (Sammlung von Erklärungen, die (noch) nicht auf der Hilfe-Seite zu finden sind) <br>
          </td>
      </tr>            


</table>

<?php 
include_once('foot.php');

 
?>


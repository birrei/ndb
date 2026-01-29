<?php
include_once('head.php');
?>

<style>
table.start, td.start {
  border-style: solid;
  border-color: lightgray;
  border-collapse: collapse;
  padding-right: 10px;
  font-size: 14pt;

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

<h1> Notendatenbank </h1>
<table class="start">
<tr>
    <td class="start"><h3>Daten</h3></td>
    <td class="start">
      <a href="show_table4.php?ansicht=sammlungen">Übersicht Sammlungen</a><br>
      <a href="show_table4.php?ansicht=schueler">Übersicht Schüler</a><br>
      <a href="show_table4.php?ansicht=uebungen&Datum=<?php echo date('Y-m-d');  ?>">Übersicht Übungen</a>
      <br>
      <!-- <a href="show_table2.php?table=v_uebung&sortcol=ID&sortorder=DESC">Übungen</a> <br>  Übersicht nicht verwenden, Übungen werden über Schüler-Formular verwaltet   -->
  </td>
</tr>

<tr> 
  <td class="start"> <h3>Stammdaten</h3></td>
  <td class="start">
    <a href="show_table2.php?table=v_standort&sortcol=Name">Standorte</a> <br>
    <a href="show_table2.php?table=v_verlag&sortcol=Name">Verlage</a> <br>
    <hr> 
    <a href="show_table2.php?table=v_komponist&sortcol=Name">Komponisten</a> <br>
    <a href="show_table2.php?table=v_besetzung&sortcol=Name">Besetzungen</a> <br>
    <a href="show_table2.php?table=v_verwendungszweck&sortcol=Name">Verwendungszwecke</a> <br>
    <a href="show_table2.php?table=v_gattung&sortcol=Name">Gattungen</a> <br>
    <a href="show_table2.php?table=v_epoche&sortcol=Name">Epochen</a> <br>
    <a href="show_table2.php?table=v_materialtyp&sortcol=Name">Materialtypen</a>  <br>    
    <hr> 

    <a href="show_table2.php?table=v_schwierigkeitsgrad&sortcol=Name">Schwierigkeitsgrade</a>, 
    <a href="show_table2.php?table=v_instrument&sortcol=Name">Instrumente</a> <br>
    <a href="show_table2.php?table=v_erprobt&sortcol=Name">Erprobt-Eigenschaften</a> <br>

    <hr> 
        
    <a href="show_table2.php?table=v_lookup&sortcol=LookupTypeName,Name">Besonderheiten</a>, <a href="show_table2.php?table=v_lookup_type&sortcol=Name">Besonderheit Typen</a> <br>

    <a href="show_table2.php?table=v_status&sortcol=Name">Status Ausprägungen</a> <i>(Status Schüler Satz/Material-Zuordnung)</i><br>

    <a href="show_table2.php?table=v_uebungtyp&sortcol=Name">Übung Typen</a> <br>
    <a href="show_table2.php?table=v_linktype&sortcol=Name">Link-Typen</a> <br>
    <a href="show_table2.php?table=v_abfragetyp&sortcol=Name">Abfrage-Typen</a> <br>
  </td>
</tr>


<tr> <td class="start"> <h3>Abfragen, Auswertungen</h3> </td>
  <td class="start">
    <a href="show_table3.php">Verwendungszweck Planung</a> <i>(Anzeige Gesamt - Spieldauer) </i> <br>
    <a href="show_table2.php?table=v2_info_Tempobezeichnungen&sortcol=Tempobezeichnung">Verwendete Tempobezeichnungen</a> <br>
    <a href="show_table2.php?table=v2_info_Spieldauern&sortcol=Spieldauer">Verwendete Spieldauern</a> <br>
    <a href="tests.php?title=Tests">Vordefinierte Tests</a>   <br>
    <a href="show_table2.php?table=v_abfrage&sortcol=Name&add_link_show">Gespeicherte Abfragen</a> <br>
  </td>
</tr>


<!-- <tr>
  <td class="start"> <h3>Repository</h3> </td>
  <td class="start">
    <a href="https://github.com/birrei/ndb/tree/main" tabindex="-1" target="_blank">GitHub Startseite</a><br>
    <a href="https://github.com/birrei/ndb/blob/main/changelog.md" tabindex="-1" target="_blank">Changelog</a> <i>(Beschreibung neuer Funktionen, Information zu beseitigten Fehlern) </i><br>
    <a href="https://github.com/birrei/ndb/commits/main/" tabindex="-1" target="_blank">Commits</a> <i>(vollständige techn. Änderungs-Historie)</i> <br>
    <a href="https://github.com/birrei/ndb/blob/main/notes.md" tabindex="-1" target="_blank">Notizen</a> <i>(Sammlung von Erklärungen, die (noch) nicht auf der Hilfe-Seite zu finden sind) </i><br>
  </td>
</tr> -->


</table>

<?php
include_once('foot.php');


?>


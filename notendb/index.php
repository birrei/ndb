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
      <!-- <a href="show_table4.php?ansicht=uebungen&Datum=<?php echo date('Y-m-d');  ?>">Übersicht Übungen</a> -->
      <a href="show_table4.php?ansicht=uebungen">Übersicht Übungen</a><br>
      <a href="show_table4.php?ansicht=uebungstage">Übersicht Übungstage</a>
      <br>
      <!-- <a href="show_table2.php?table=v_uebung&sortcol=ID&sortorder=DESC">Übungen</a> <br>  Übersicht nicht verwenden, Übungen werden über Schüler-Formular verwaltet   -->
  </td>
</tr>

<tr> 
  <td class="start"> <h3>Stammdaten</h3></td>
  <td class="start">
    <b>Zu Übungen:</b> 
    <a href="show_table2.php?table=v_uebungtyp&sortcol=Name">Übung Typen</a>, 
    <a href="show_table4.php?ansicht=bewertungen">Bewertungen</a>, 

      <a href="show_table4.php?ansicht=kalender">Kalender</a>, 
      <a href="show_table4.php?ansicht=schuljahre">Schuljahre</a> (inkl. Ferien + Feiertage), 
      <a href="show_table4.php?ansicht=schueler-kalender-vorlage">Schüler-Kalender Vorlage</a> (BETA)<br>

    <hr>
    <b>Zu Sammlungen:</b> <a href="show_table4.php?ansicht=standorte">Standorte</a>, 
    <a href="show_table4.php?ansicht=verlage">Verlage</a>, 
    <a href="show_table2.php?table=v_linktype&sortcol=Name">Link-Typen</a> <br>
    <hr> 
        <b>Zu Musikstücken:</b> 
        <a href="show_table4.php?ansicht=komponisten">Komponisten</a>, 
        <a href="show_table4.php?ansicht=besetzungen">Besetzungen</a>, 
        <a href="show_table4.php?ansicht=verwendungszwecke">Verwendungszwecke</a>, 
        <a href="show_table4.php?ansicht=gattungen">Gattungen</a>, 
        <a href="show_table4.php?ansicht=epochen">Epochen</a>, 
        <a href="show_table4.php?ansicht=materialtypen">Material-Typen</a>
        <hr> 

    <b>Zu Sätzen: </b><a href="show_table2.php?table=v_schwierigkeitsgrad&sortcol=Name">Schwierigkeitsgrade</a>, 
    <a href="show_table2.php?table=v_instrument&sortcol=Name">Instrumente</a>, 
    <a href="show_table2.php?table=v_erprobt&sortcol=Name">Erprobt-Eigenschaften</a> <br>

    <hr> 
       <b>Übergreifend: </b>  
      <a href="show_table4.php?ansicht=besonderheiten">Besonderheiten</a>, 
      <a href="show_table4.php?ansicht=lookuptypes">Besonderheit-Typen</a>, 
      <a href="show_table2.php?table=v_status&sortcol=Name">Status Ausprägungen</a> <i>(Status Schüler Satz/Noten-Zuordnung)</i>, 
      <!-- <a href="show_table2.php?table=v_abfragetyp&sortcol=Name">Abfrage-Typen</a> <br> -->
  </td>
</tr>

<tr> <td class="start"> <h3>Abfragen</h3> </td>
  <td class="start"> 
    <a href="show_table3.php">Verwendungszweck Planung</a> <i>(Anzeige Gesamt - Spieldauer) </i> <br>
    <a href="show_table4.php?ansicht=info-alle-spieldauern">Verwendete Spieldauern</a> <br>
    <a href="show_table4.php?ansicht=info-alle-tempobezeichnungen">Verwendete Tempobezeichnungen</a> <br>

  </td>
</tr>

<tr> <td class="start"> <h3>Standard-Tests</h3> </td>
  <td class="start"> 
    <a href="show_table4.php?ansicht=test-sammlungen-ohne-musikstueck">Sammlungen ohne Musikstück</a> <br>
    <a href="show_table4.php?ansicht=test-musikstuecke-ohne-satz">Musikstücke ohne Satz</a> <br>
    <a href="show_table4.php?ansicht=test-musikstuecke-ohne-besetzung">Musikstücke ohne Besetzung</a> <br>
    <a href="show_table4.php?ansicht=test-saetze-ohne-schwierigkeitsgrad">Sätze ohne Schwierigkeitsgrad</a> <br>

  </td>
</tr>

<tr> <td class="start"> <h3>Sonst</h3> </td>
  <td class="start">
    <a href="updates.php">Sammel-Updates</a> <br>   


  </td>
</tr>


</table>

<?php
include_once('foot.php');


?>


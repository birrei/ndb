<?php 

include('head.php');
?>

<h1> Notendatenbank   </h1> 

<h2> Heft-Daten </h2>

<table>
<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&title=Sammlung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php?title=Sammlung" target="_blank" >Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Musikstück</b></td>
    <td><a href="show_table2.php?table=v_musikstueck&sortcol=Name&title=Musikstück" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Sammlung</td>
</tr>

<tr>
    <td><b>Satz</b></td>
    <td><a href="show_table2.php?table=v_satz&sortcol=Name&title=Satz" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Musikstück</td>
</tr>

</table>

<h2> Stammdaten Sammlung </h2>

<table> 

<tr>
    <td><b>Verlage</b></td>
    <td><a href="show_table2.php?table=verlag&sortcol=Name&title=Verlag" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php?title=Verlag" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Standorte</b></td>
    <td><a href="show_table2.php?table=standort&sortcol=Name&title=Standort" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_standort.php?title=Standort" target="_blank">Neu erfassen</a></td>
</tr>

</table> 

<h2> Stammdaten Musikstück </h2>

<table> 
<tr>
    <td><b>Komponisten</b></td>
    <td><a href="show_table2.php?table=v_komponist&sortcol=Name&title=Komponist" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_komponist.php?title=Komponist" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besetzungen</b></td>
    <td><a href="show_table2.php?table=besetzung&sortcol=Name&title=Besetzung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_besetzung.php?title=Besetzung" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Verwendungszwecke</b></td>
    <td><a href="show_table2.php?table=verwendungszweck&sortcol=Name&title=Verwendungszweck" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verwendungszweck.php?title=Verwendungszweck" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Gattungen</b></td>
    <td><a href="show_table2.php?table=gattung&sortcol=Name&title=Gattung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_gattung.php?title=Gattung" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Epochen</b></td>
    <td><a href="show_table2.php?table=epoche&sortcol=Name&title=Epoche" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_epoche.php?title=Epoche" target="_blank">Neu erfassen</a></td>
</tr>

</table> 

<h2> Stammdaten Satz </h2>

<table> 

<tr>
    <td><b>Stricharten</b></td>
    <td><a href="show_table2.php?table=strichart&sortcol=Name&title=Strichart" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_strichart.php?title=Strichart" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Notenwerte</b></td>
    <td><a href="show_table2.php?table=notenwert&sortcol=Name&title=Notenwert" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_notenwert.php?title=Notenwert" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Erprobt</b></td>
    <td><a href="show_table2.php?table=erprobt&sortcol=Name&title=Erprobt" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_erprobt.php?title=Erprobt" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Schwierigkeitsgrad</b></td>
    <td><a href="show_table2.php?table=schwierigkeitsgrad&sortcol=Name&title=Schwierigkeitsgrad" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_schwierigkeitsgrad.php?title=Schwierigkeitsgrad" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Übung</b></td>
    <td><a href="show_table2.php?table=uebung&sortcol=Name&title=Übung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_uebung.php?title=Übung" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besonderheiten</b></td>
    <td><a href="show_table2.php?table=v_lookup&sortcol=Name&title=Besonderheit" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_lookup.php?title=Besonderheit" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Besonderheit Typen</b></td>
    <td><a href="show_table2.php?table=lookup_type&sortcol=Name&title=Besonderheit Typ" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_lookup_type.php?title=Besonderheit Typ" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Abfragen</b> (BETA) </td>
    <td><a href="show_table2.php?table=v_abfrage&sortcol=Name&title=Abfrage&add_link_show" target="_blank">Daten anzeigen</a></td>
    <td>
     <a href="insert_abfrage.php?title=Abfrage" target="_blank">Neu erfassen</a>
    </td>
</tr>

</table>

<?php 
include('foot.php');
?>


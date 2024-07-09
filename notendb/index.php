<?php 
include('head.php');
?>
<h1> Notendatenbank   </h1> 
<div class="start"> 
    <div class="start-box1"> 

        <h2> Heft-Daten </h2>
        <table class="start">
        <tr>
            <td class="start"><b>Sammlung</b></td>
            <td class="start"><a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&title=Sammlungen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_sammlung.php?title=Sammlung&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Musikstück</b></td>
            <td class="start"><a href="show_table2.php?table=v_musikstueck&sortcol=Name&title=Musikstücke">Daten anzeigen</a></td>
            <td class="start">Erfassung über Sammlung</td>
        </tr>
        <tr>
            <td class="start"><b>Satz</b></td>
            <td class="start"><a href="show_table2.php?table=v_satz&sortcol=Name&title=Sätze">Daten anzeigen</a></td>
            <td class="start">Erfassung über Musikstück</td>
        </tr>
        </table>
    </div>

    <div class="start-box2"> 
                
        <h2> Sammlung Stammdaten </h2>
        <table class="start"> 
        <tr>
            <td class="start"><b>Verlage</b></td>
            <td class="start"><a href="show_table2.php?table=verlag&sortcol=Name&title=Verlage">Daten anzeigen</a></td>
            <td class="start"><a href="edit_verlag.php?title=Verlag&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Standorte</b></td>
            <td class="start"><a href="show_table2.php?table=standort&sortcol=Name&title=Standorte">Daten anzeigen</a></td>
            <td class="start"><a href="edit_standort.php?title=Standort&option=insert">Neu erfassen</a></td>
        </tr>
        </table> 
    </div>

    <div class="start-box3"> 

        <h2>  Musikstück Stammdaten</h2>
        <table class="start"> 
        <tr>
            <td class="start"><b>Komponisten</b></td>
            <td class="start"><a href="show_table2.php?table=v_komponist&sortcol=Name&title=Komponisten">Daten anzeigen</a></td>
            <td class="start"><a href="edit_komponist.php?title=Komponist&option=insert">Neu erfassen</a></td>
        </tr>

        <tr>
            <td class="start"><b>Besetzungen</b></td>
            <td class="start"><a href="show_table2.php?table=besetzung&sortcol=Name&title=Besetzungen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_besetzung.php?title=Besetzung&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Verwendungszwecke</b></td>
            <td class="start"><a href="show_table2.php?table=verwendungszweck&sortcol=Name&title=Verwendungszwecke">Daten anzeigen</a></td>
            <td class="start"><a href="edit_verwendungszweck.php?title=Verwendungszweck&option=insert">Neu erfassen</a></td>
        </tr>

        <tr>
            <td class="start"><b>Gattungen</b></td>
            <td class="start"><a href="show_table2.php?table=gattung&sortcol=Name&title=Gattungen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_gattung.php?title=Gattung&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Epochen</b></td>
            <td class="start"><a href="show_table2.php?table=epoche&sortcol=Name&title=Epochen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_epoche.php?title=Epoche&option=insert">Neu erfassen</a></td>
        </tr>
        </table> 

    </div>


    <div class="start-box4"> 

        <h2> Satz Stammdaten </h2>

        <table class="start"> 
  
        <tr>
            <td class="start"><b>Erprobt</b></td>
            <td class="start"><a href="show_table2.php?table=erprobt&sortcol=Name&title=Erprobt">Daten anzeigen</a></td>
            <td class="start"><a href="edit_erprobt.php?title=Erprobt&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Schwierigkeitsgrad</b></td>
            <td class="start"><a href="show_table2.php?table=schwierigkeitsgrad&sortcol=Name&title=Schwierigkeitsgrade">Daten anzeigen</a></td>
            <td class="start"><a href="edit_schwierigkeitsgrad.php?title=Schwierigkeitsgrad&option=insert">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Schwierigkeitsgrad Instrumente</b></td>
            <td class="start"><a href="show_table2.php?table=instrument&sortcol=Name&title=Instrumente">Daten anzeigen</a></td>
            <td class="start"><a href="edit_instrument.php?title=Instrument&option=insert">Neu erfassen</a></td>
        </tr> 
        

        <tr>
            <td class="start"><b>Besonderheiten</b></td>
            <td class="start"><a href="show_table2.php?table=v_lookup&sortcol=LookupType,Name&title=Besonderheiten">Daten anzeigen</a></td>
            <td class="start"><a href="edit_lookup.php?title=Besonderheit&option=insert">Neu erfassen</a></td>
        </tr>
        
        <tr>
            <td class="start"><b>Besonderheit Typen</b></td>
            <td class="start"><a href="show_table2.php?table=lookup_type&sortcol=Name&title=Besonderheit Typen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_lookup_type.php?title=Besonderheit-Typ&option=insert">Neu erfassen</a></td>
        </tr>
                
        </table>

    </div>

    <div class="start-box5"> 

        <h2> Sonstiges </h2>
        <table class="start">
        <tr>
            <td class="start"><b>Abfragen</b></td>
            <td class="start"><a href="show_table2.php?table=v_abfrage&sortcol=Name&title=Abfragen&add_link_show">Daten anzeigen</a></td>
            <td class="start"><a href="edit_abfrage.php?title=Abfrage&option=insert">Neu erfassen</a>
            </td>
        </tr>
<!-- 

        
        <tr>
            <td class="start"><b>Obsolete: Übung</b></td>
            <td class="start"><a href="show_table2.php?table=uebung&sortcol=Name&title=Übungen">Daten anzeigen</a></td>
            <td class="start"><a href="insert_uebung.php?title=Übung">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Obsolete: Stricharten</b></td>
            <td class="start"><a href="show_table2.php?table=strichart&sortcol=Name&title=Stricharten">Daten anzeigen</a></td>
            <td class="start"><a href="insert_strichart.php?title=Strichart">Neu erfassen</a></td>
        </tr>
        <tr>
            <td class="start"><b>Obsolete: Notenwerte</b></td>
            <td class="start"><a href="show_table2.php?table=notenwert&sortcol=Name&title=Notenwerte">Daten anzeigen</a></td>
            <td class="start"><a href="insert_notenwert.php?title=Notenwert">Neu erfassen</a></td>
        </tr>         
        -->
        </table>
    </div>

</div> 

<?php 
include('foot.php');
?>


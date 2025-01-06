<?php 
include('head.php');
?>
<style>
h1 {
    background-color: lightblue; 
}
h3 {
    background-color: greenyellow; 
}

</style>

<table class="start">
<tr> <td colspan="3" class="start"> <h1> Notendatenbank   </h1> </td> </tr>    
        <tr>
            <td class="start"><b>Sammlung</b></td>
            <td class="start"><a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&title=Sammlungen&show_filter">Daten anzeigen</a></td>
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

<!---   --> 
<tr> <td colspan="3" class="start"> <h3>Sammlung Stammdaten </h3> </td> </tr>
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


        <tr> <td colspan="3" class="start"> <h3>Musikstück Stammdaten</h3> </td> </tr>

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
  
        
<!---   Stammdaten   --> 
        <tr> <td colspan="3" class="start"> <h3>Satz Stammdaten</h3> </td> </tr>
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
        
        <tr> <td colspan="3" class="start"> <h3>Sonst</h3> </td> </tr>

        <tr>
            <td class="start"><b>Besonderheiten</b></td>
            <td class="start"><a href="show_table2.php?table=v_lookup&sortcol=LookupTypeName,Name&title=Besonderheiten">Daten anzeigen</a></td>
            <td class="start"><a href="insert_lookup.php?title=Besonderheit&option=insert">Neu erfassen</a></td>
        </tr>
    
           
        <tr>
            <td class="start"><b>Besonderheit Typen</b></td>
            <td class="start"><a href="show_table2.php?table=lookup_type&sortcol=Name&title=Besonderheit Typen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_lookup_type.php?title=Besonderheit-Typ&option=insert">Neu erfassen</a></td>
        </tr>
                
        <tr>
            <td class="start"><b>Link-Typen</b></td>
            <td class="start"><a href="show_table2.php?table=linktype&sortcol=Name&title=Link-Typen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_linktype.php?title=Link-Typ&option=insert">Neu erfassen</a></td>
        </tr>
                        

        <!---  Sonstiges   --> 

        <tr> <td colspan="3" class="start"> <h3>Hintergrund</h3> </td> </tr>        

        <tr>
            <td class="start"><b>Schüler</b></td>
            <td class="start"><a href="show_table2.php?table=schueler&sortcol=Name&title=Schüler">Daten anzeigen</a></td>
            <td class="start"><a href="edit_schueler.php?title=Schüler&option=insert">Neu erfassen</a></td>
        </tr>

        <tr>
            <td class="start"><b>Abfragen</b></td>
            <td class="start"><a href="show_table2.php?table=v_abfrage&sortcol=Name&title=Abfragen&add_link_show&show_filter">Daten anzeigen</a></td>
            <td class="start"><a href="edit_abfrage.php?title=Abfrage&option=insert">Neu erfassen</a></td>
        </tr>

        <tr>
            <td class="start"><b>Abfragetypen</b></td>
            <td class="start"><a href="show_table2.php?table=abfragetyp&sortcol=Name&title=Abfragetypen">Daten anzeigen</a></td>
            <td class="start"><a href="edit_abfragetyp.php?title=Abfragetyp&option=insert">Neu erfassen</a></td>
        </tr>

        <tr> <td colspan="3" class="start"> <h3>Info-Sichten</h3> </td> </tr>        


        <tr>
            <td class="start"><b>Verwendete Tempobezeichnungen</b></td>
            <td class="start"><a href="show_table2.php?table=v2_info_Tempobezeichnungen&sortcol=Tempobezeichnung&title=Tempobezeichnungen">Daten anzeigen</a></td>
            <td class="start"></td>
        </tr>        

        <tr>
            <td class="start"><b>Verwendete Tonarten</b></td>
            <td class="start"><a href="show_table2.php?table=v2_info_Tonarten&sortcol=Tonart&title=Tonarten">Daten anzeigen</a></td>
            <td class="start"></td>
        </tr>

        <tr>
            <td class="start"><b>Verwendete Taktarten</b></td>
            <td class="start"><a href="show_table2.php?table=v2_info_Taktarten&sortcol=Taktart&title=Taktarten">Daten anzeigen</a></td>
            <td class="start"></td>
        </tr>

        <tr>
            <td class="start"><b>Verwendete Spieldauern</b></td>
            <td class="start"><a href="show_table2.php?table=v2_info_Spieldauern&sortcol=Spieldauer&title=Spieldauern">Daten anzeigen</a></td>
            <td class="start"></td>
        </tr>        

        
        

<style>

/* customizable snowflake styling */
/* https://pajasevi.github.io/CSSnowflakes/  */
.snowflake {
  color: #fff;
  font-size: 1em;
  font-family: Arial, sans-serif;
  text-shadow: 0 0 5px #000;
}

.snowflake,.snowflake .inner{animation-iteration-count:infinite;animation-play-state:running}@keyframes snowflakes-fall{0%{transform:translateY(0)}100%{transform:translateY(110vh)}}@keyframes snowflakes-shake{0%,100%{transform:translateX(0)}50%{transform:translateX(80px)}}.snowflake{position:fixed;top:-10%;z-index:9999;-webkit-user-select:none;user-select:none;cursor:default;animation-name:snowflakes-shake;animation-duration:3s;animation-timing-function:ease-in-out}.snowflake .inner{animation-duration:10s;animation-name:snowflakes-fall;animation-timing-function:linear}.snowflake:nth-of-type(0){left:1%;animation-delay:0s}.snowflake:nth-of-type(0) .inner{animation-delay:0s}.snowflake:first-of-type{left:10%;animation-delay:1s}.snowflake:first-of-type .inner,.snowflake:nth-of-type(8) .inner{animation-delay:1s}.snowflake:nth-of-type(2){left:20%;animation-delay:.5s}.snowflake:nth-of-type(2) .inner,.snowflake:nth-of-type(6) .inner{animation-delay:6s}.snowflake:nth-of-type(3){left:30%;animation-delay:2s}.snowflake:nth-of-type(11) .inner,.snowflake:nth-of-type(3) .inner{animation-delay:4s}.snowflake:nth-of-type(4){left:40%;animation-delay:2s}.snowflake:nth-of-type(10) .inner,.snowflake:nth-of-type(4) .inner{animation-delay:2s}.snowflake:nth-of-type(5){left:50%;animation-delay:3s}.snowflake:nth-of-type(5) .inner{animation-delay:8s}.snowflake:nth-of-type(6){left:60%;animation-delay:2s}.snowflake:nth-of-type(7){left:70%;animation-delay:1s}.snowflake:nth-of-type(7) .inner{animation-delay:2.5s}.snowflake:nth-of-type(8){left:80%;animation-delay:0s}.snowflake:nth-of-type(9){left:90%;animation-delay:1.5s}.snowflake:nth-of-type(9) .inner{animation-delay:3s}.snowflake:nth-of-type(10){left:25%;animation-delay:0s}.snowflake:nth-of-type(11){left:65%;animation-delay:2.5s}
</style>
<div class="snowflakes" aria-hidden="true">
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
</div>



</table






<?php 
include('foot.php');
?>


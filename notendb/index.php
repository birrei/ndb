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
<tr> <td class="start"> <h1> Notendatenbank   </h1> </td> </tr>    
        <tr>
            <td class="start">
              <a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&show_filter">Sammlungen</a> | 
              <a href="edit_sammlung.php?title=Sammlung&option=insert">Neu erfassen</a> 
            </td>
         
        </tr>

      <tr> <td colspan="3" class="start"> <h3>Sammlung Stammdaten </h3> </td> </tr>
        <tr>
            <td class="start">
                <a href="show_table2.php?table=verlag&sortcol=Name">Verlage</a> |  
                <a href="show_table2.php?table=standort&sortcol=Name">Standorte</a> | 
                <a href="show_table2.php?table=linktype&sortcol=Name">Link-Typen</a> 

              </td>
   
        </tr>


        <tr> <td class="start"> <h3>Musikstück Stammdaten</h3> </td> </tr>

        <tr>
            <td class="start">
              <a href="show_table2.php?table=v_komponist&sortcol=Name">Komponisten</a> | 
              <a href="show_table2.php?table=besetzung&sortcol=Name">Besetzungen</a> | 
              <a href="show_table2.php?table=verwendungszweck&sortcol=Name">Verwendungszwecke</a> | 
              <a href="show_table2.php?table=gattung&sortcol=Name">Gattungen</a> | 
              <a href="show_table2.php?table=epoche&sortcol=Name">Epochen</a> 

            </td>
        </tr>

      

        <tr> <td class="start"> <h3>Satz Stammdaten</h3> </td> </tr>
        <tr>
            <td class="start">
            <a href="show_table2.php?table=erprobt&sortcol=Name">Erprobt-Eigenschaften</a> | 
            <a href="show_table2.php?table=schwierigkeitsgrad&sortcol=Name">Schwierigkeitsgrade</a> | 
            <a href="show_table2.php?table=instrument&sortcol=Name">Instrumente</a> | 
            <a href="show_table2.php?table=v_lookup&sortcol=LookupTypeName,Name">Besonderheiten</a> | 
            <a href="show_table2.php?table=lookup_type&sortcol=Name">Besonderheit Typen</a> 


            </td>
        </tr>


        <tr> <td class="start"> <h3>Sonst</h3> </td> </tr>       
        <tr>
            <td class="start">
            <a href="show_table2.php?table=v_schueler&sortcol=Name">Schüler</a> |               
            <a href="show_table2.php?table=v_material&sortcol=Name">Material</a> |    
            <a href="show_table2.php?table=materialtyp&sortcol=Name">Materialtypen</a> | 
            <a href="show_table2.php?table=status&sortcol=Name">Status</a>

            </td>
        </tr>


        <tr> <td class="start"> <h3>Abfragen</h3> </td> </tr>   

        <tr>
            <td class="start">    
            <a href="show_table2.php?table=v_abfrage&sortcol=Name&add_link_show">Abfragen</a> | 
            <a href="show_table2.php?table=abfragetyp&sortcol=Name">Abfrage-Typen</a> 
            </td>
        </tr>



        <tr> <td class="start"> <h3>Info-Sichten</h3> </td> </tr>        
        <tr>
            <td class="start">
            <a href="show_table2.php?table=v2_info_Tempobezeichnungen&sortcol=Tempobezeichnung">Verwendete Tempobezeichnungen</a> | 
            <a href="show_table2.php?table=v2_info_Tonarten&sortcol=Tonart">Verwendete Tonarten</a> | 
            <a href="show_table2.php?table=v2_info_Taktarten&sortcol=Taktart">Verwendete Taktarten</a> | 
            <a href="show_table2.php?table=v2_info_Spieldauern&sortcol=Spieldauer">Verwendete Spieldauern</a> 


            </td>

        </tr>        

         

</table>
        

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
<!-- 
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
    <div class="inner">🌼</div>
  </div>
</div>
 -->



</table






<?php 
include('foot.php');
?>


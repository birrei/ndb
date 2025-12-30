<?php 
class SQLPart {

  // public $add_linkebreak=false;

  // public $SQL=''; 


  // // Sammlung (obl.), Musikstueck (opt), Satz (opt). Mit Zeilenumbruch 
  // public $select_concat_noten_namen=
  //             "
  //             CONCAT(
  //                   sammlung.Name
  //                   , COALESCE(
  //                     IF(
  //                     length(musikstueck.Name) > 0
  //                     , CONCAT('<br>', musikstueck.Name)
  //                     , CONCAT('<br>Musikstueck Nr ', musikstueck.Nummer)
  //                     ), '') 
  //                 , COALESCE(
  //                   IF(
  //                     length(satz.Name) > 0
  //                     , CONCAT('<br>', satz.Name)
  //                     , CONCAT('<br>Satz Nr ', satz.Nr)
  //                     ), '')            	
  //                     ) as Noten  
  //                 "; 




  // public function __construct(
  //     $level='satz', 
  //     $add_linkebreak=false, // <br>Tag einfügen ja / nein 
  //     $leave_empty=false // Wenn Musikstück / Satz keinen Namen haben, dann leer lassen 

  //   ){
  //     $tmpSQL=''; 
  //     switch($level) {
  //       case 'satz': 
  //         $tmpSQL="CONCAT(
  //           sammlung.Name
  //         , IF(
  //           length(musikstueck.Name) > 0
  //           , CONCAT('".($add_linkebreak?"<br>":"")."', musikstueck.Name)
  //           , CONCAT('".($add_linkebreak?"<br>":"")."Musikstueck Nr ', musikstueck.Nummer)
  //           )
  //         , IF(
  //           length(satz.Name) > 0
  //           , CONCAT('".($add_linkebreak?"<br>":"")."', satz.Name)
  //           , CONCAT('".($add_linkebreak?"<br>":"")."Satz Nr ', satz.Nr)           	
  //           ) ) as Noten                       
  //         "; 
  //       break; 
  //     }
  //     $this->SQL=$tmpSQL; 
  // }

  public function getSQL_COL_CONCAT_Noten($type=1, $add_linkebreak=false) {

    // types 1 - 99: Test-Ballons XXXX
    // types ab 100: Abschießend zu verwendendete Standardversionen

    $tmpSQL=''; 
    switch($type) {
      case 1: // Sammlung, Musikstück, Satz 
        $tmpSQL="
              CONCAT(
                    sammlung.Name
                    , ' / Standort: '
                    , standort.Name  
                    , COALESCE(
                      IF(
                      length(musikstueck.Name) > 0
                      , CONCAT('<br>', musikstueck.Name)
                      , CONCAT('<br>Musikstueck Nr ', musikstueck.Nummer)
                      ), '') 
                  , COALESCE(
                    IF(
                      length(satz.Name) > 0
                      , CONCAT('<br>', satz.Name)
                      , CONCAT('<br>Satz Nr ', satz.Nr)
                      ), '')            	
                      ) as Noten  
                  "; 
        break; 

      case 2: 
        $tmpSQL="CONCAT(
              sammlung.Name
            , IF(
              length(musikstueck.Name) > 0
              , CONCAT('".($add_linkebreak?"<br>":"")."', musikstueck.Name)
              , CONCAT('".($add_linkebreak?"<br>":"")."Musikstueck Nr ', musikstueck.Nummer)
              )
            , IF(
              length(satz.Name) > 0
              , CONCAT('".($add_linkebreak?"<br>":"")."', satz.Name)
              , CONCAT('".($add_linkebreak?"<br>":"")."Satz Nr ', satz.Nr)           	
              ) ) as Noten                       
            "; 
        break; 

      /************************/
      case 100: // Sammlung, Musikstück + Satz
                // Bedingung für Verwendung: Satz Ebene, existierende satz.ID
                // ggf. GROUP BY auf satz.ID   
                // Nicht befüllte Felder werden nicht ausgegeben
                // Musikstück- bzw. Satz Nummer werden nicht angezeigt  (auch dann, wenn die Namen leer sind) 
                // => Info: Es ist also denkbar, dass nur der Sammlung Name ausgegeben wird
                   // obwohl auch Musikstück und Satz (z.B. als Pro Forma-Gerüste) angelegt sind 

        $tmpSQL="CONCAT(
              sammlung.Name
            , IF(
                length(musikstueck.Name) > 0
                , CONCAT(' / ".($add_linkebreak?"<br>":"")."', musikstueck.Name), '' )
            , IF(length(satz.Name) > 0
                , CONCAT(' / ".($add_linkebreak?"<br>":"")."', satz.Name), '' ) ) 
               as Noten                       
            "; 
        break;       
        
              /********** ab 200: Gruppierung Schüler **************/
      case 200: // Auflistung Sammlung, Musikstück + Satz pro Schüler 
  
        $tmpSQL.="GROUP_CONCAT(
                  DISTINCT concat('* ', sammlung.Name, ' / ', musikstueck.Name, 
                          IF(satz.Name <> '', CONCAT(' / ', satz.Name), ''), 
                          IF(schueler_satz.StatusID is not null, CONCAT(' / Status: ', status.Name), ''),
                          IF(schueler_satz.Bemerkung <> '', CONCAT(' / ', schueler_satz.Bemerkung), '')
              )  
              order by sammlung.Name, musikstueck.Nummer 
              SEPARATOR '<br />') as `Noten / Status `  ".PHP_EOL;       

        break;   


    }

      return $tmpSQL; 

  }


}

 



?>
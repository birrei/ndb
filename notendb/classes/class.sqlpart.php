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
    $tmpSQL=''; 
    switch($type) {
      case 1: 
        $tmpSQL="
              CONCAT(
                    sammlung.Name
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


    }

      return $tmpSQL; 

  }


}

 



?>
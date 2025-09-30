
<?php 


class SQLPart {

  public $add_linkebreak=false;
  public $select_concat_noten_namen="
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
                  ";  // 


}

 



?>
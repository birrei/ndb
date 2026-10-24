<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Query {


  public string $table_edit=''; // Tabelle, die über den "Bearbeiten"- Link geöffnet werden soll 

  // filter
  public string $SchuljahrID=''; 
  public string $SchuelerID=''; 
  public string $Datum=''; 
  public string $Datum_bis=''; 
  public string $Unterricht_Geplant=''; 
  public string $Unterricht_Protokolliert=''; 
  public string $Berechnet=''; 
  public string $Suchtext=''; 


  public string $wochentag_nr=''; 


  public string $groupcol=''; 


  public bool $add_link_edit=true; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  // public function print_schueler_uebungstage() {
  //   // Variante bezieht für "Stunden berechnet" die Übungszeit (Summe aus uebung.Anzahl = Übung Minuten ) mit ein.  
  //   // Zeigt die Übungszeit   
  //   $query="SELECT 
  //         schueler_kalender.Datum 
  //         , schueler_kalender.Bemerkung       
  //         , kalender.Wochentag_Name as Wochentag     
  //         , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
  //         -- , SUM(uebung.Anzahl ) as `Summe Minuten` 
  //         , TIME_FORMAT(SEC_TO_TIME( SUM(uebung.Anzahl) * 60), '%H:%i')  as `Stunden Übung`     
  //         , TIME_FORMAT(SEC_TO_TIME(( 
  //             SUM(
  //             CASE 
	//             WHEN schueler_kalender.Berechnen = 1 
  //                   AND kalender.Unterricht_Protokolliert = 1 
	//                 THEN  
	//                   CASE 
  //                     WHEN uebung.ID IS NOT NULL 
	//                     THEN uebung.Anzahl
	//                   	ELSE schueler.Unterricht_Dauer
	//                   	END 
  //             ELSE 
  //                 0 
  //             END
  //               ))  
  //                * 60 
  //               ), '%H:%i') AS `Stunden berechnet`
  //         , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
  //         , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
  //         , ferien.Bezeichnung AS Ferientag 
  //         , feiertag.Bezeichnung AS Feiertag 
  //         , schuljahr.Bezeichnung AS Schuljahr
  //         , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterricht geplant`   
  //         , IF(kalender.Unterricht_Protokolliert=1, 'X' , '') as `Unterricht protokolliert`  
  //         , IF(schueler_kalender.Berechnen=1, 'X' , '') as `Berechnen`                     
  //         , schueler_kalender.ID                           
  //   FROM  schueler_kalender
  //   		INNER JOIN 
  //   		kalender 
  //           ON schueler_kalender.Datum = kalender.Datum         
  //       INNER JOIN schueler 
  //           ON schueler.ID= schueler_kalender.SchuelerID 
  //       LEFT JOIN schuljahr 
  //         ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
  //       LEFT JOIN ferien 
  //         ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
  //       LEFT JOIN feiertag 
  //         ON kalender.Datum = feiertag.Datum             
  //       LEFT JOIN uebung 
  //           ON schueler.ID = uebung.SchuelerID 
  //           AND schueler_kalender.Datum = uebung.Datum                  
  //       LEFT join uebungtyp 
  //           ON uebung.UebungtypID=uebungtyp.ID 
  //       WHERE 1=1 "; 
    
  //       if($this->SchuelerID!='') {
  //         $query.="AND schueler.ID = :SchuelerID " ;  
  //       }

  //       if($this->SchuljahrID!='') {
  //         $query.="AND schuljahr.ID = :SchuljahrID ";  
  //       }

  //   $query.="
  //       GROUP BY schueler.ID, schueler_kalender.Datum  
  //       ORDER BY schueler_kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name            
  //       "; 

  //   $stmt = $this->db->prepare($query); 

  //   if($this->SchuelerID!=''){
  //     $stmt->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT); 
  //   } 

  //   if($this->SchuljahrID!=''){
  //     $stmt->bindParam(':SchuljahrID', $this->SchuljahrID, PDO::PARAM_INT); 
  //   } 

  //   $this->print_table($stmt); 
  
  // }

  public function print_schueler_uebungstage2($is_overview=false) {

    $query="SELECT "; 

    if($is_overview) {
      $query.="schueler.Name AS `Schüler Name`, 
              schueler.Bemerkung `Schueler Bemerkung`,  "; 
    }

    $query.="schueler_kalender.Datum 
          , schueler_kalender.Bemerkung       
          , kalender.Wochentag_Name as Wochentag     
          , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
          , TIME_FORMAT(SEC_TO_TIME( SUM(uebung.Anzahl) * 60), '%H:%i')  as `Stunden Übung`  
          , TIME_FORMAT(SEC_TO_TIME( (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) * 60), '%H:%i')  as `Abweichung Stunden Übung`         
          , TIME_FORMAT(SEC_TO_TIME( 
              ( 
                CASE 
                WHEN schueler_kalender.Berechnen = 1 AND kalender.Unterricht_Protokolliert = 1 
                  THEN  
                      schueler.Unterricht_Dauer
                  ELSE 
                    0 
                END
                ) 
                 * 60 
                ), '%H:%i') AS `Stunden berechnet`
          , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
          , ferien.Bezeichnung AS Ferientag 
          , feiertag.Bezeichnung AS Feiertag 
          , schuljahr.Bezeichnung AS Schuljahr
          , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterricht geplant`   
          , IF(kalender.Unterricht_Protokolliert=1, 'X' , '') as `Unterricht protokolliert`  
          , IF(schueler_kalender.Berechnen=1, 'X' , '') as `Berechnen`                     
          , schueler_kalender.ID                           
      FROM 
        schueler_kalender
    		INNER JOIN 
    		kalender 
            ON schueler_kalender.Datum = kalender.Datum         
        INNER JOIN schueler 
            ON schueler.ID= schueler_kalender.SchuelerID 
        LEFT JOIN schuljahr 
          ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
        LEFT JOIN ferien 
          ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
        LEFT JOIN feiertag 
          ON kalender.Datum = feiertag.Datum             
        LEFT JOIN uebung 
            ON schueler.ID = uebung.SchuelerID 
            AND schueler_kalender.Datum = uebung.Datum                  
        LEFT join uebungtyp 
            ON uebung.UebungtypID=uebungtyp.ID 
        WHERE schueler.Aktiv=1 "; 
 
    if($this->SchuelerID!='') {
      $query.="AND schueler.ID = :SchuelerID " ;  
      if (empty($this->Datum) & $this->SchuelerID=='') {
        $this->groupcol='Datum'; 
      }      
    }

    if($this->SchuljahrID!='') {
      $query.="AND schuljahr.ID = :SchuljahrID ";  
    }

    if ($this->Unterricht_Geplant!='') {
      $query.="AND kalender.Unterricht_Geplant=".$this->Unterricht_Geplant." ".PHP_EOL;  
    }   

    if ($this->Unterricht_Protokolliert!='') {
      $query.="AND kalender.Unterricht_Protokolliert=".$this->Unterricht_Protokolliert." ".PHP_EOL; 
    }       

    if($this->Suchtext!='') {
      $query.="AND ( schueler.Bemerkung LIKE '%".$this->Suchtext."%' 
                  OR schueler_kalender.Bemerkung LIKE '%".$this->Suchtext."%' 
                  ) "; 
    }  

    if (!empty($this->Datum) & empty($this->Datum_bis)) {
      $query.="AND schueler_kalender.Datum='".$this->Datum."' ".PHP_EOL;  
    }
    if (!empty($this->Datum) & !empty($this->Datum_bis)) {
      $query.="AND schueler_kalender.Datum BETWEEN '".$this->Datum."' AND '".$this->Datum_bis."' ".PHP_EOL; 
      $this->groupcol='Datum';  
    }
    if (empty($this->Datum) & !empty($this->Datum_bis)) {
      $query.="AND schueler_kalender.Datum <= '".$this->Datum_bis."' ".PHP_EOL;
      $this->groupcol='Datum';         
    }
                  
    $query.="
          GROUP BY schueler.ID, schueler_kalender.Datum  
          ORDER BY schueler_kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name            
          "; 

    // echo '<pre>'.$query.'</pre>'; // test 

    $stmt = $this->db->prepare($query); 

    if($this->SchuelerID!=''){
      $stmt->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT); 
    } 

    if($this->SchuljahrID!=''){
      $stmt->bindParam(':SchuljahrID', $this->SchuljahrID, PDO::PARAM_INT); 
    } 

    $this->print_table($stmt); 
    
  }

  public function print_schueler_auswertung_uebungstage($is_overview=false) {

    $query="SELECT stunden_plan.SchuljahrID
              , stunden_plan.Schuljahr
              , stunden_plan.Tage AS `Tage Plan`
              , stunden_plan.Stunden AS `Stunden Plan` 
              , stunden_ist.Tage AS `Tage Ist`
              , stunden_ist.Stunden AS 'Stunden Ist' 
          FROM 
          (
          SELECT schueler_kalender.SchuelerID
              , schuljahr.ID AS SchuljahrID 
              , schuljahr.Bezeichnung  AS Schuljahr 
              , COUNT(DISTINCT schueler_kalender.Datum) AS Tage
                  ,  TIME_FORMAT(SEC_TO_TIME( (COUNT(schueler_kalender.Datum) * schueler.Unterricht_Dauer) * 60), '%H:%i')   AS Stunden
          FROM schueler_kalender
          INNER JOIN kalender ON schueler_kalender.Datum = kalender.Datum 
          INNER JOIN schueler ON schueler_kalender.SchuelerID  = schueler.ID
          INNER JOIN schuljahr ON schueler_kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
          WHERE 1=1 
          -- AND kalender.Unterricht_Protokolliert = 1
          AND schueler.ID = :SchuelerID              
          GROUP BY schueler_kalender.SchuelerID, schuljahr.ID 
          ) stunden_plan 
          LEFT JOIN 
          ( 
          SELECT schueler_kalender.SchuelerID
              , schuljahr.ID AS SchuljahrID  
              , COUNT(DISTINCT schueler_kalender.Datum) AS Tage 
                  ,  TIME_FORMAT(SEC_TO_TIME( (COUNT(schueler_kalender.Datum) * schueler.Unterricht_Dauer) * 60), '%H:%i')   AS Stunden
          FROM schueler_kalender
          INNER JOIN kalender ON schueler_kalender.Datum = kalender.Datum 
          INNER JOIN schueler ON schueler_kalender.SchuelerID  = schueler.ID
          INNER JOIN schuljahr ON schueler_kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
          WHERE 1=1 
          AND kalender.Unterricht_Protokolliert = 1
          AND schueler_kalender.Berechnen = 1 
          AND schueler.ID = :SchuelerID        
          GROUP BY schueler_kalender.SchuelerID, schuljahr.ID 
          ) AS stunden_ist 
          ON stunden_plan.SchuljahrID = stunden_ist.SchuljahrID 
          AND stunden_plan.SchuelerID = stunden_ist.SchuelerID  
        ORDER BY Schuljahr DESC "; 

    // echo '<pre>'.$query.'</pre>'; // test 

    $stmt = $this->db->prepare($query); 

    if($this->SchuelerID!=''){
      $stmt->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT); 
    } 

    // if($this->SchuljahrID!=''){
    //   $stmt->bindParam(':SchuljahrID', $this->SchuljahrID, PDO::PARAM_INT); 
    // } 

    $this->print_table($stmt); 
    
  }





  private function print_table($stmt) {

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=$this->add_link_edit;      
      $html->edit_link_table=$this->table_edit; 
      $html->edit_link_open_newpage=true; 
      $html->show_missing_data_message=false;      
      $html->group_col=$this->groupcol; 
      // $html->show_row_count=true; 
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }

  }

}

 



?>
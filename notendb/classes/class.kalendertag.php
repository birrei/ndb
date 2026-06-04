<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.kalender.php"); 


class Kalendertag {

  public int $ID; 
  public DateTime $Datum;
  public string $Datum_DE;
  public string $Datum_EN;
  // public DateTime $Datum;  
  // $date = new DateTime($datumString);

  public string $Name;   // aktuell = Datum, ggf. erweiterte Bezeichnung möglich
  public int $Wochentag_Nr; 
  public string $Wochentag; 
  public string $Ferien;  
  public string $Feiertag; 
  public string $Schuljahr; 
  public string $Kalenderwoche; 
  public string $Hinweise=''; 

  public string $Title='Kalendertag'; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  public function update(int $Unterricht_Geplant, int $Unterricht_Protokolliert) {

    $update = $this->db->prepare("UPDATE `kalender` 
                            SET
                            `Unterricht_Geplant`     = :Unterricht_Geplant, 
                            `Unterricht_Protokolliert`     = :Unterricht_Protokolliert
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Unterricht_Geplant', $Unterricht_Geplant);
    $update->bindParam(':Unterricht_Protokolliert', $Unterricht_Protokolliert);

    try {
      $update->execute();
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }  


  function load_row() {

    $select = $this->db->prepare(
                    "SELECT kalender.ID
                      , kalender.Datum
                      , kalender.Name 
                      , kalender.Wochentag_Name 
                      , kalender.Wochentag_Nr
                      , kalender.Kalenderwoche 
                      , kalender.Unterricht_Geplant 
                      , kalender.Unterricht_Protokolliert                      
                      , COALESCE(ferien.Bezeichnung,'') AS Ferien 
                      , COALESCE(feiertag.Bezeichnung, '') AS Feiertag 
                      , COALESCE(schuljahr.Bezeichnung, '') AS Schuljahr   
                FROM kalender  
                    LEFT JOIN schuljahr 
                      ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
                    LEFT JOIN ferien 
                      ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
                    LEFT JOIN feiertag 
                      ON kalender.Datum = feiertag.Datum 
                WHERE kalender.ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Datum = new Datetime($row_data["Datum"]);
      $this->Datum_DE = $this->Datum->format('d.m.Y');  
      $this->Datum_EN = $this->Datum->format('Y-m-d');  
      $this->Wochentag_Nr=$row_data["Wochentag_Nr"];    
      $this->Wochentag_Name=$row_data["Wochentag_Name"];    
      $this->Kalenderwoche=$row_data["Kalenderwoche"];    
      $this->Unterricht_Geplant=$row_data["Unterricht_Geplant"];    
      $this->Unterricht_Protokolliert=$row_data["Unterricht_Protokolliert"];
      $this->Ferien=$row_data["Ferien"];
      $this->Feiertag=$row_data["Feiertag"];
      $this->Schuljahr=$row_data["Schuljahr"];

      // echo 'Schuljahr: '.$this->Schuljahr; 
      // echo 'Ferien: '.$this->Ferien; 
      $this->Hinweise=($this->Ferien!='' & $this->Feiertag!=''?$this->Ferien.', '.$this->Feiertag:''); 
      $this->Hinweise=($this->Ferien!='' & $this->Feiertag==''?$this->Ferien:''); 
      $this->Hinweise=($this->Ferien=='' & $this->Feiertag!=''?$this->Feiertag:''); 

      return true; 
    } 
    else {
      return false; 
    }
  }  

   
}

class SchuelerKalendertag extends Kalendertag {

  public int $SchuelerID; 
  public string $SchuelerName=''; 

  public string $Title='Schüler Übungstag'; 
  public string $Bemerkung=''; 

  public function load_row() {

    $query="SELECT schueler_kalender.ID
          , COALESCE(schueler_kalender.Datum, '') as Datum 
          -- , schueler_kalender.Datum
          , COALESCE(schueler_kalender.Bemerkung, '') as Bemerkung
          , schueler_kalender.SchuelerID
          , COALESCE(kalender.Wochentag_Name, '') as Wochentag 
          , COALESCE(ferien.Bezeichnung,'') AS Ferien 
          , COALESCE(feiertag.Bezeichnung, '') AS Feiertag 
          , COALESCE(schuljahr.Bezeichnung, '') AS Schuljahr
          , schueler.Name as SchuelerName   
    FROM schueler_kalender 
          INNER JOIN schueler 
            ON schueler.ID= schueler_kalender.SchuelerID           
        LEFT JOIN  kalender 
            ON schueler_kalender.Datum = kalender.Datum         
        LEFT JOIN schuljahr 
          ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
        LEFT JOIN ferien 
          ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
        LEFT JOIN feiertag 
          ON kalender.Datum = feiertag.Datum    
    WHERE schueler_kalender.ID = :ID"; 
          


    $select = $this->db->prepare($query);

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch(); 
      // echo '<pre>'; 
      // print_r($row_data); // test    
      // echo '</pre>';

      if(!empty($row_data["Datum"])) {
        $this->Datum = new Datetime($row_data["Datum"]);        
        $this->Datum_DE = $this->Datum->format('d.m.Y');  
        $this->Datum_EN = $this->Datum->format('Y-m-d');  
      } else {
        $this->Datum_DE = ''; 
        $this->Datum_EN = ''; 
      }
      // $this->Name=$row_data["Datum"]; 
      $this->Bemerkung=$row_data["Bemerkung"]; 
      $this->Wochentag=$row_data["Wochentag"]; 
      $this->Ferien=$row_data["Ferien"]; 
      $this->Feiertag=$row_data["Feiertag"]; 
      $this->Schuljahr=$row_data["Schuljahr"]; 
      $this->SchuelerID=$row_data["SchuelerID"]; 
      $this->SchuelerName=$row_data["SchuelerName"]; 

      return true; 
    } 
    else {
      return false; 
    }
    
  }   

  public function insert_row(int $SchuelerID) {

    // print_r(func_get_args()); 

    $insert = $this->db->prepare("INSERT INTO schueler_kalender  
                                  SET `SchuelerID` = :SchuelerID ");
          
    $insert->bindParam(':SchuelerID', $SchuelerID,PDO::PARAM_INT);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId(); 
      
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

  public function update_row(string $Bemerkung, string $Datum) {

    // Datum ändern nicht möglich wenn: 
    // 1. das neue Datum im Schüler-Kalender schon existiert
    // 2. es bereits Übungen mit dem bisherigen Datum gibt  

    // print_r(func_get_args()); // Test 

    $Datum_Neu = new Datetime($Datum);
    $Datum_Neu_DE = $Datum_Neu->format('d.m.Y');  
    $Datum_Neu_EN = $Datum_Neu->format('Y-m-d');  

    $this->load_row(); 

    /** prüfung auf Dublette  */

    $uebungskalender = new SchuelerKalender(); 
    $uebungskalender->SchuelerID= $this->SchuelerID; 

    if ($uebungskalender->date_exists($Datum)) {
      $this->info->print_user_error('Das erfasste Datum '.$Datum_Neu_DE.' existiert bereits im Schülerkalender. 
                                  Das Datum wird auf den vorherigen Wert '.$this->Datum_DE.' zurückgesetzt.   <br>'); 
      $Datum=$this->Datum_EN;

    } 

    /** prüfung auf Dublette  */

    $AnzahlUebungen = $this->AnzahlUebungen();  

    if($AnzahlUebungen > 0 ) {
        $this->info->print_user_error('Es sind noch '.$AnzahlUebungen.' Übungen mit Datum '.$this->Datum_DE.' vorhanden.
                                  Das erfasste Datum '.$Datum_Neu_DE.' kann nicht gespeichert werden und wird auf '.$this->Datum_DE.' zurückgesetzt.<br>'); 
        $Datum=$this->Datum_EN;; 
      }


    $update = $this->db->prepare("UPDATE schueler_kalender  
                                  SET Bemerkung    = :Bemerkung, 
                                      Datum        = :Datum 
                                  WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Bemerkung', $Bemerkung);
    $update->bindParam(':Datum', $Datum);

    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }

  function is_deletable() {
    
    $AnzahlUebungen = $this->AnzahlUebungen(); 
    
    $this->load_row(); 

    If ($AnzahlUebungen > 0)  { 
      $this->info->print_warning('Das Datum '.$this->Datum_DE.' für Schüler "'.$this->SchuelerName.'" 
        kann nicht gelöscht werden, da noch  '.$AnzahlUebungen.' Übungen vorhanden sind.<br>'); 
      return false; 
    }
    else { 
        return true; 
    } 

  }

  function delete(){

    $delete = $this->db->prepare("DELETE FROM schueler_kalender WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Das Datum wurde gelöscht.');             
      return true;          
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false ; 
    }  
  }   

  public function AnzahlUebungen() {

    $tmpAnzahl = 0; 

    $select = $this->db->prepare("SELECT * 
              FROM uebung 
              WHERE SchuelerID=:SchuelerID 
              AND Datum = :Datum 
              "
              );
    $select->bindValue(':SchuelerID', $this->SchuelerID); 
    $select->bindValue(':Datum', $this->Datum_EN); 
    $select->execute();  
    
    // if ($select->rowCount() > 0 ){
    //   $this->info->print_warning('Das Datum '.$this->Datum_DE.' für Schüler "'.$this->SchuelerName.'" 
    //     kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
    //     Übungen existiert.<br>'); 
    //   return false;       
    // } 

    $tmpAnzahl = $select->rowCount(); 

    return $tmpAnzahl; 

  }



}




 



?>
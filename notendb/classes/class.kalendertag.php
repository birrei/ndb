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

  public string $Title='Kalendertag'; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
   
}

class SchuelerKalendertag extends Kalendertag {

  public int $SchuelerID; 
  public string $SchuelerName=''; 

  public string $Title='Schüler-Kalendertag'; 
  public string $Bemerkung=''; 

  public function load_row() {
    $select = $this->db->prepare(
                      "SELECT schueler_kalender.ID
                      , schueler_kalender.Datum
                      , COALESCE(schueler_kalender.Bemerkung, '') as Bemerkung
                      , schueler_kalender.SchuelerID
                      , kalender.Wochentag_Name as Wochentag 
                      , COALESCE(ferien.Bezeichnung,'') AS Ferientag 
                      , COALESCE(feiertag.Bezeichnung, '') AS Feiertag 
                      , COALESCE(schuljahr.Bezeichnung, '') AS Schuljahr
                      , schueler.Name as SchuelerName   
                FROM schueler_kalender 
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
                WHERE schueler_kalender.ID = :ID");


    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();         
      $this->Datum = new Datetime($row_data["Datum"]);
      $this->Datum_DE = $this->Datum->format('d.m.Y');  
      $this->Datum_EN = $this->Datum->format('Y-m-d');  
      $this->Name=$row_data["Datum"]; 
      $this->Bemerkung=$row_data["Bemerkung"]; 
      $this->Wochentag=$row_data["Wochentag"]; 
      $this->Ferien=$row_data["Ferientag"]; 
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

  function insert(string $str_date) {
      
    $insert = $this->db->prepare("INSERT INTO schueler_kalender  
              SET `SchuelerID` = :SchuelerID
                  , Datum      =  :Datum "
           );
          
    $insert->bindParam(':SchuelerID', $this->SchuelerID,PDO::PARAM_INT);
    $insert->bindParam(':Datum', $str_date);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId(); 
      $this->load_row();        
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

  public function update_row(string $Bemerkung) {

    $update = $this->db->prepare("UPDATE schueler_kalender  
                                  SET Bemerkung    = :Bemerkung 
                                  WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Bemerkung', $Bemerkung);

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
    
    $this->load_row(); 

    $select = $this->db->prepare("SELECT * 
              FROM uebung 
              WHERE SchuelerID=:SchuelerID 
              AND Datum = :Datum 
              "
              );
    $select->bindValue(':SchuelerID', $this->SchuelerID); 
    $select->bindValue(':Datum', $this->Datum_EN); 
    $select->execute();  
    
    // $select->debugDumpParams(); 

    if ($select->rowCount() > 0 ){
      $this->info->print_warning('Das Datum '.$this->Datum_DE.' für Schüler "'.$this->SchuelerName.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
        Übungen existiert.<br>'); 
      return false;       
    } 

    return true;

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




}




 



?>
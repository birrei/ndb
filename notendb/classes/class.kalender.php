<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.kalendertag.php"); 

class Kalender {

  private $table_name='kalender'; 

  public $Title='Kalender Datum';
  public $Titles='Kalender';  

  public string $Datum; // schreibgeschützt
  public string $Name; // schreibgeschützt
  public string $Wochentag_Nr; // schreibgeschützt
  public string $Wochentag_Name; // schreibgeschützt
  public string $Kalenderwoche; // schreibgeschützt
  public int $Unterricht_Geplant; 
  public int $Unterricht_Protokolliert; 
  
  private $wochentageDeutsch = [
      1 => 'Montag',
      2 => 'Dienstag',
      3 => 'Mittwoch',
      4 => 'Donnerstag',
      5 => 'Freitag',
      6 => 'Samstag',
      7 => 'Sonntag'
  ];
    
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
   

  public function insert_new_date(DateTime $date) {

    $Datum = $date->format('Y-m-d'); 

    $new_date_exists = $this->date_exists($Datum); 

    if ($new_date_exists) {
      $this->info->user_error('Das Datum '.$Datum.' ist schon vorhanden!'); 

    } else {
      // $date = new DateTimeImmutable($str_date);

      $Name = $date->format('d.m.Y');      
      $Wochentag_Nr= $date->format('N'); // Wochentage 1-7 (1= Montag) 
      $Wochentag_Name = $this->wochentageDeutsch[$Wochentag_Nr]; 
      $Kalenderwoche= $date->format('o-W'); // YYYY-WW
      $insert = $this->db->prepare("INSERT INTO kalender 
              SET `Name` = :Name, 
                   Datum = :Datum, 
                   Wochentag_Nr     = :Wochentag_Nr, 
                   Wochentag_Name     = :Wochentag_Name,  
                   Kalenderwoche     = :Kalenderwoche                    
              
              ");
      
      
      $insert->bindParam(':Name', $Name);
      $insert->bindParam(':Datum', $Datum);
      $insert->bindParam(':Wochentag_Nr', $Wochentag_Nr);
      $insert->bindParam(':Wochentag_Name', $Wochentag_Name);
      $insert->bindParam(':Kalenderwoche', $Kalenderwoche);

      try {
        $insert->execute(); 
        $this->ID=$this->db->lastInsertId();
        // $this->load_row();  
      }
        catch (PDOException $e) {
        $info = new HTML_Info();      
        $info->print_user_error(); 
        $info->print_error($insert, $e);  ; 
      }
    }
  }  


  public function date_exists(string $str_date) {
    $select = $this->db->prepare("SELECT * FROM kalender WHERE Datum = :Datum");
    $select->bindParam(':Datum', $str_date);
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
       return true; 
    } else {
      return false; 
    }
  }

  function insert_data($str_date_start='', $str_date_end='', $print=false){

    $date_start = new DateTime($str_date_start);
    $date_end  = new DateTime($str_date_end);
    $intervall = new DateInterval('P1D'); // "Period 1 Day"
    $zeitraum  = new DatePeriod($date_start, $intervall, $date_end->modify('+1 day'));

    foreach ($zeitraum as $datum) {
        $this->insert_new_date($datum); 
    }

    if($print) {
      $sql_select = "SELECT * from kalender ORDER BY Datum"; 
      $select = $this->db->prepare($sql_select); 
      $select->execute();          
      $htmltable = new HTML_Table($select);   
      $htmltable->add_link_edit=false; 
      $htmltable->print_table2();         
    }

  }

  public function getFirstdate () {
    $sql="SELECT MIN(datum) from kalender "; 
    $stmt = $this->db->prepare($sql); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  
  
  public function getLastdate () {
    $sql="SELECT MAX(datum) from kalender "; 
    $stmt = $this->db->prepare($sql); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  
  
  
  public function getID (string $strDate) {
    $sql="SELECT MAX(ID) from kalender WHERE Datum='".$strDate."'" ; 
    $stmt = $this->db->prepare($sql); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  
  
}

class SchuelerKalender extends Kalender {
  // aka "Übungstage" 
  public string $SchuelerID; 
  public string $SchuelerName=''; 
  private string $table_name='schueler_kalender'; 

  public function date_exists(string $str_date) {
    // print_r(func_get_args()); // Test 

    $select = $this->db->prepare("SELECT * FROM schueler_kalender 
                WHERE Datum = :Datum 
                AND SchuelerID = :SchuelerID " 
                );
    $select->bindParam(':Datum', $str_date);
    $select->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT);
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
       return true; 
    } else {
      return false; 
    }
  }

  public function getLastdate (string $strDate='') {
    // letzter Übungstag vor Heute bzw. letzter Übungstag vor einem bestimmten Datum 

    $refDate=$strDate!=''?$strDate:date('Y-m-d'); 

    $sql="SELECT MAX(datum) FROM schueler_kalender 
          WHERE SchuelerID=:SchuelerID 
                AND Datum <= :LetztesDatumUebungskalender 
          "; 
    $stmt = $this->db->prepare($sql); 
    $stmt->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT);
    $stmt->bindParam(':LetztesDatumUebungskalender', $refDate);
    $stmt->execute(); 
    // $stmt->debugDumpParams(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  } 

  function insert_rows($SchuljahrID, $SchuelerID='') {

    if($SchuljahrID=='') {
      $this->info->print_user_error('Es wurde kein Schuljahr ausgewählt!.'); 
      return; 
    }

    $query="INSERT INTO schueler_kalender (SchuelerID, Datum )           
        SELECT schueler.ID AS SchuelerID, kalender.Datum
        FROM schueler 
          INNER JOIN kalender 
            ON kalender.Wochentag_Nr = schueler.Unterricht_Wochentag
          INNER JOIN schuljahr 
            ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
          LEFT JOIN (
            SELECT schueler_kalender.SchuelerID , schueler_kalender.Datum 
            FROM schueler_kalender 
            INNER JOIN schuljahr 
            ON schueler_kalender.Datum  BETWEEN schueler_kalender.Datum  AND schueler_kalender.Datum 
            AND schuljahr.ID = :SchuljahrID 
          ) AS  schueler_kalender_vorhanden 
            ON schueler.ID = schueler_kalender_vorhanden.SchuelerID 
            AND kalender.Datum  = schueler_kalender_vorhanden.Datum 
          LEFT JOIN ferien 
            ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
            AND ferien.SchuljahrID = schuljahr.ID  
          LEFT JOIN feiertag 
            ON kalender.Datum = feiertag.Datum 
            AND  feiertag.SchuljahrID = schuljahr.ID 
          WHERE schueler.Aktiv =1  
          AND schuljahr.Eingelesen = 0 
          AND schueler_kalender_vorhanden.Datum IS NULL -- schon vorhandene (manuelle) Einträge ausschließen 
          AND schuljahr.ID = :SchuljahrID 
          AND  (ferien.ID IS NULL AND feiertag.ID IS  NULL) 
          GROUP BY kalender.Datum, schueler.ID 
          ORDER BY schueler.ID, kalender.Datum
          "; 


    $insert = $this->db->prepare($query);
    $insert->bindParam(':SchuljahrID', $SchuljahrID, PDO::PARAM_INT);

    try {
      $insert->execute(); 
      $this->info->print_info('Es wurden '.$insert->rowCount().' Übungstage eingefügt.'); 
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }          


  function delete_rows($SchuljahrID, $SchuelerID='') {

    if($SchuljahrID=='') {
      $this->info->print_user_error('Es wurde kein Schuljahr ausgewählt!.'); 
      return; 
    }
    // 
    $query="DELETE schueler_kalender 
            FROM schueler_kalender 
                INNER JOIN 
                schuljahr 
                ON schueler_kalender.Datum  BETWEEN schuljahr.Datum_Start   AND schuljahr.Datum_Ende   
            WHERE schuljahr.ID = :SchuljahrID
            AND schuljahr.Eingelesen = 0  
          "; 

    $insert = $this->db->prepare($query);
    $insert->bindParam(':SchuljahrID', $SchuljahrID, PDO::PARAM_INT);

    try {
      $insert->execute(); 
      $this->info->print_info('Es wurden '.$insert->rowCount().' Übungstage gelöscht.'); 
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }          


}  






?>
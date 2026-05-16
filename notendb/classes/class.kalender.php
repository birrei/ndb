<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.kalendertag.php"); 

class Kalender {

  public $table_name='kalender'; 

  public $Title='Kalender Datum';
  public $Titles='Kalender';  

  public string $Datum; // schreibgeschützt
  public string $Name; // schreibgeschützt
  public string $Wochentag_Nr; // schreibgeschützt
  public string $Wochentag_Name; // schreibgeschützt
  public string $Kalenderwoche; // schreibgeschützt
  public int $Unterricht_Geplant; 
  
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
   
  function load_row() {


    $select = $this->db->prepare("SELECT `ID`
                                        , `Datum` 
                                        , `Name` 
                                        , `Wochentag_Nr` 
                                        , `Wochentag_Name`
                                        , Kalenderwoche 
                                        ,  Unterricht_Geplant 
                          FROM `kalender`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Datum=$row_data["Datum"];    
      $this->Wochentag_Nr=$row_data["Wochentag_Nr"];    
      $this->Wochentag_Name=$row_data["Wochentag_Name"];    
      $this->Kalenderwoche=$row_data["Kalenderwoche"];    
      $this->Unterricht_Geplant=$row_data["Unterricht_Geplant"];    
      return true; 
    } 
    else {
      return false; 
    }
  }  

  function update_row(int $Unterricht_Geplant) {

    $update = $this->db->prepare("UPDATE `kalender` 
                            SET
                            `Unterricht_Geplant`     = :Unterricht_Geplant
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Unterricht_Geplant', $Unterricht_Geplant);

    try {
      $update->execute();
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }


  public function insert_new_date(string $str_date) {

    $new_date_exists = $this->date_exists($str_date); 

    if ($new_date_exists) {
      $this->info->print_warning('Das Datum '.$str_date.' ist schon vorhanden!'); 

    } else {

      $date = new DateTimeImmutable($str_date);
      $Name = $date->format('d.m.Y');

      $insert = $this->db->prepare("INSERT INTO kalender SET `Name` = :Name, Datum = :Datum");
      $insert->bindParam(':Name', $Name);
      $insert->bindParam(':Datum', $str_date);

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

    // $sql_delete = "DELETE FROM kalender"; 
    // $delete = $this->db->prepare($sql_delete);     
    // $delete->execute();               

    foreach ($zeitraum as $datum) {

        $str_date= $datum->format('Y-m-d'); 
        $wochentag_nr= $datum->format('N'); // Wochentage 1-7 (1= Montag) 
        $wochentag_name = $this->wochentageDeutsch[$wochentag_nr]; 
        // $kalenderwoche= $datum->format('W'); 
        $kalenderwoche= $datum->format('o-W'); // YYYY-WW

        
        $this->insert_new_date($str_date); 

            
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



 



?>
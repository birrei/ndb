<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Kalender {

  public $table_name='kalender'; 
  public $ID;
  public $Name; // 

  
  private $wochentageDeutsch = [
      1 => 'Montag',
      2 => 'Dienstag',
      3 => 'Mittwoch',
      4 => 'Donnerstag',
      5 => 'Freitag',
      6 => 'Samstag',
      7 => 'Sonntag'
  ];
    
  public $Title='Kalender';
  public $Titles='Kalender';  
  public string $infotext=''; 
  public $titles_selected_list; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
   
  function insert_data($str_date_start='', $str_date_end='', $print=false){

    // XXXX $overwrite true = Tabelle wird neu befüllt. false: Tabelle wird bis date_end ergänzt 

    $date_start = new DateTime($str_date_start);
    $date_end  = new DateTime($str_date_end);
    $intervall = new DateInterval('P1D'); // P1D steht für "Period 1 Day"
    $zeitraum  = new DatePeriod($date_start, $intervall, $date_end->modify('+1 day'));

    $sql_delete = "DELETE FROM kalender"; 
    $delete = $this->db->prepare($sql_delete);     
    $delete->execute();               

    foreach ($zeitraum as $datum) {

        $Datum_str= $datum->format('Y-m-d'); 
        $wochentag_nr= $datum->format('N'); // Wochentage 1-7 (1= Montag) 
        $wochentag_name = $this->wochentageDeutsch[$wochentag_nr]; 
        // $kalenderwoche= $datum->format('W'); 
        $kalenderwoche= $datum->format('o-W'); 

        $sql_insert = "INSERT into kalender 
                                (datum
                                  , wochentag_nr
                                  , wochentag_name
                                  , kalenderwoche
                                  )
                        VALUES('".$Datum_str."'
                              , ".$wochentag_nr."
                              , '".$wochentag_name."'
                              , '".$kalenderwoche."'
                              )   ";     
        // echo $sql_insert . "<br>";   
        $insert = $this->db->prepare($sql_insert); 
        $insert->execute();            
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
  







  }  



 



?>
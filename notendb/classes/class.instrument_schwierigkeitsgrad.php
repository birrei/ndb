<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class InstrumentSchwierigkeitsgrad {

  /* Tabelle "instrument_schwierigkeitsgrad" ist eine Hilfstabelle, 
     in die alle verwendeten Instrument-Schwierigkeitsgrad - Kombinationen geschrieben werden
     Sie wird nur für die Suche- Seite(n) (Auswahl-Box "Instrument/Schwierigkeitsgrad"). 

     Für die Erfassung bzw. in Erfassungsformularen wird die Tabelle nicht benötigt. 
  */

  public $table_name='instrument_schwierigkeitsgrad'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Instrument / Schwierigkeitsgrad';
  public $Titles='Instrument / Schwierigkeitsgrade';  

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row($InstrumentID, $SchwierigkeitsgradID ){

    // Insert, falls Kombination InstrumentID/SchwierigkeitsgradID noch noch nicht vorhanden
    $query="INSERT INTO instrument_schwierigkeitsgrad (InstrumentID, SchwierigkeitsgradID)
        SELECT t_ins.InstrumentID, t_ins.SchwierigkeitsgradID 
        FROM (SELECT :InstrumentID as InstrumentID, :SchwierigkeitsgradID as SchwierigkeitsgradID) t_ins
          LEFT JOIN instrument_schwierigkeitsgrad as t_ref
          ON t_ref.InstrumentID = t_ins.InstrumentID 
          AND t_ref.SchwierigkeitsgradID  = t_ins.SchwierigkeitsgradID
        WHERE t_ref.InstrumentID  IS NULL "; 

    $insert = $this->db->prepare($query);
    $insert->bindValue(':InstrumentID', $InstrumentID);      
    $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  

    try {
      $insert->execute(); 
      if ($insert->rowCount()) {
        $this->ID=$this->db->lastInsertId();      
      }
    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  
  function print_select_multi($options_selected=[]){

    $query="select ss.ID, concat(i.Name, ': ', s.Name) as Name
            from instrument_schwierigkeitsgrad ss 
              inner join 
              schwierigkeitsgrad s  on ss.SchwierigkeitsgradID  = s.ID 
              inner  join 
              instrument i on ss.InstrumentID  = i.ID 	 
            order by i.Name, s.Name"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->visible_rows= 10; 
      $html->print_select_multi('Schwierigkeitsgrad', 'InstrumentSchwierigkeitsgrad[]', $options_selected, 'Instrument/Schwierigkeitsgrad:'); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  


  function delete_orphaned_rows(){
    /* Löschen, falls keine Satz-Refererenz (mehr) vorhandenden ist  */
    $query="
      delete instrument_schwierigkeitsgrad
      from instrument_schwierigkeitsgrad 
      left join satz_schwierigkeitsgrad 
      on instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
      and instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
      where satz_schwierigkeitsgrad.ID IS NULL "; 

    $delete = $this->db->prepare($query); 

    try {
      $delete->execute(); 
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  } 

}

 



?>
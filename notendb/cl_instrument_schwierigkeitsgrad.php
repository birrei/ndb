<?php 
class InstrumentSchwierigkeitsgrad {

  public $table_name; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Instrument / Schwierigkeitsgrad';
  public $Titles='Instrument / Schwierigkeitsgrade';  

  public function __construct(){
    $this->table_name='instrument_schwierigkeitsgrad'; 
  }

  function insert_row($InstrumentID, $SchwierigkeitsgradID ){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    // Insert, falls Kombination InstrumentID/SchwierigkeitsgradID noch noch nicht vorhanden
    $query="
        insert into instrument_schwierigkeitsgrad (InstrumentID, SchwierigkeitsgradID)
        select t_ins.InstrumentID, t_ins.SchwierigkeitsgradID 
        from (select :InstrumentID as InstrumentID, :SchwierigkeitsgradID as SchwierigkeitsgradID) t_ins
          left join instrument_schwierigkeitsgrad as t_ref
          on t_ref.InstrumentID = t_ins.InstrumentID 
          and t_ref.SchwierigkeitsgradID  = t_ins.SchwierigkeitsgradID
        where t_ref.InstrumentID  is null 
    "; 

    $insert = $db->prepare($query);
    $insert->bindValue(':InstrumentID', $InstrumentID);      
    $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  

    try {
      $insert->execute(); 
      if ($insert->rowCount()) {
        $this->ID=$db->lastInsertId();      
      }
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

}

 



?>
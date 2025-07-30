<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 


class InstrumentSchwierigkeitsgrad {

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
      include_once("class.html_info.php"); 
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
      $html->print_select_multi('Schwierigkeitsgrad', 'InstrumentSchwierigkeitsgrad[]', $options_selected, 'Satz Instrument/Schwierigkeitsgrad:'); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }  

  function getSucheFilterSQL($Schwierigkeitsgrade){

    $strFilter=''; 
    $query = "SELECT DISTINCT InstrumentID 
                      FROM instrument_schwierigkeitsgrad  
                      WHERE ID IN (".implode(',', $Schwierigkeitsgrade).") 
                      order by ID";
    // echo $query; 

    $select = $this->db->prepare($query); 
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $arrTmp=[]; 
      $strFilter.="AND satz.ID IN (SELECT SatzID FROM satz_schwierigkeitsgrad WHERE InstrumentID=".$row["InstrumentID"]." "; 
      $query2 = "SELECT DISTINCT SchwierigkeitsgradID 
                FROM instrument_schwierigkeitsgrad  
                WHERE ID IN (".implode(',', $Schwierigkeitsgrade).") 
                AND InstrumentID=".$row["InstrumentID"]."  
                ORDER by ID";
      // echo $query2; 
      $select2 = $this->db->prepare($query2); 
      $select2->execute(); 
      $result2 = $select2->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result2 as $row2) {
        $arrTmp[]=$row2["SchwierigkeitsgradID"]; 
      }
      $strFilter.="AND SchwierigkeitsgradID IN (".implode(',', $arrTmp)."))".PHP_EOL; 
    }
    return  $strFilter; 
  }


}

 



?>
<?php 


 class Instrument {

  public $table_name; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Instrument';
  public $Titles='Instrumente';  
  public $Parent='Satz'; // Satz, Schueler 
  public string $infotext=''; 
  
  public function __construct(){
    $this->table_name='instrument'; 
  }

  function insert_row ($Name) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `instrument` SET `Name` = :Name");
    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='', $refID='', $caption=''){
      
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name 
            FROM `instrument` "; 

    switch($this->Parent) {
      case 'Satz': 
        if ($refID!=''){
          $query.='WHERE ID NOT IN 
                  (SELECT InstrumentID FROM satz_schwierigkeitsgrad   
                  WHERE SatzID=:refID) ';
        }
     
        break; 

        case 'Schueler': 
          // nicht verwendet, da beim Schüler (im Gegensatz zum Satz) 
          // pro Instrument auch mehrere Schwierigkeitsgrade zugeordnet werden können 
          // (beim Schüler wird durch mehrere Einträge eine Bandbreite an Schwierigkeitsgraden vorgegeben )
          if ($refID!=''){
            $query.='WHERE ID NOT IN 
                    (SELECT InstrumentID FROM schueler_schwierigkeitsgrad   
                    WHERE SchuelerID=:refID) ';
          }       
          break; 
    }
    $query.='ORDER BY `Name`';    

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    if ($refID!=''){
      $stmt->bindParam(':refID', $refID);
    }        

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->autofocus=false;     
      $html->caption = $caption;         
      $html->print_select("InstrumentID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from instrument ORDER by Name"; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row(
              $Name 
            ) {

    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `instrument` 
                            SET
                            `Name`     = :Name
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID',$this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);

    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }

  function load_row() { 
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT `ID`, `Name`
                          FROM `instrument`
                          WHERE `ID` = :ID");

 
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      return true; 
    } 
    else {
      return false; 
    }
    
  }  

  function print_select_multi($options_selected=[]){

    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name 
            FROM `instrument` 
            order by `Name`"; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
     //  $html->print_select_multi('Instrument', 'Instrumente[]', $options_selected, 'Instrument(e):');
     $html->print_select_multi('Instrument', 'Instrumente[]', $options_selected, 'Schwierigkeitsgrad Instrument(e):');
      $this->titles_selected_list = $html->titles_selected_list;        
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }  

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT * from satz_schwierigkeitsgrad WHERE InstrumentID=:InstrumentID");
    $select->bindValue(':InstrumentID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Das Instrument ID '.$this->ID.' "'.$this->Name.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
        Sätze existiert. </p>';   
      return false;            
    }
 
    $delete = $db->prepare("DELETE FROM `instrument` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Das Instrument wurde gelöscht.</p>'; 
      return true;         
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false;  
    }  
  } 

}

 



?>
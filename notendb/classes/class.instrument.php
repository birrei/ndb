<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

 class Instrument {

  public $table_name='instrument'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Instrument';
  public $Titles='Instrumente';  
  public $Parent='Satz'; // Satz, Schueler 
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `instrument` SET `Name` = :Name");
    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='', $refID='', $caption=''){

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


    $stmt = $this->db->prepare($query); 
    if ($refID!=''){
      $stmt->bindParam(':refID', $refID);
    }        

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->autofocus=false;     
      $html->caption = $caption;         
      $html->print_select("InstrumentID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from instrument ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      include_once("class.html_table.php");      
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row(
              $Name 
            ) {

    $update = $this->db->prepare("UPDATE `instrument` 
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
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }

  function load_row() { 

    $select = $this->db->prepare("SELECT `ID`, `Name`
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

    $query="SELECT ID, Name 
            FROM `instrument` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
     //  $html->print_select_multi('Instrument', 'Instrumente[]', $options_selected, 'Instrument(e):');
     $html->print_select_multi('Instrument', 'Instrumente[]', $options_selected, 'Schwierigkeitsgrad Instrument(e):');
      $this->titles_selected_list = $html->titles_selected_list;        
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }  

  function delete(){

    $select = $this->db->prepare("SELECT * from satz_schwierigkeitsgrad WHERE InstrumentID=:InstrumentID");
    $select->bindValue(':InstrumentID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Das Instrument ID '.$this->ID.' "'.$this->Name.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
        Sätze existiert. </p>';   
      return false;            
    }
 
    $delete = $this->db->prepare("DELETE FROM `instrument` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Das Instrument wurde gelöscht.</p>'; 
      return true;         
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false;  
    }  
  } 

}

 



?>
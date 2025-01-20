<?php 

class SchuelerSatz {

  public $table_name; 

  public $ID='';
  public $SatzID='';
  public $SchuelerID=''; 
    // DatumVon XXX 
  // DatumBis XXX 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='SatzSchueler';
  public $Titles='SatzSchuelers';  

  public function __construct(){
    $this->table_name='schueler_satz'; 
  }

  function insert_row () {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
       
    // echo 'Insert: SatzID: '.$this->SatzID; // test 

    $insert = $db->prepare("INSERT INTO `schueler_satz` 
              SET SatzID = :SatzID"       
           );

    $insert->bindParam(':SatzID', $this->SatzID);

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
   
  function update_row ($SatzID,$SchuelerID, $Bemerkung) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db;  
    
    // echo 'Update: SatzID: '.$SatzID.', SchuelerID: '.$SchuelerID.', Bemerkung: '.$Bemerkung; // test 

    $update = $db->prepare("UPDATE `schueler_satz` 
              SET 
                SatzID= :SatzID
              , SchuelerID=:SchuelerID         
              , Bemerkung = :Bemerkung
              WHERE ID=:ID
              "           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':SatzID', $SatzID);
    $update->bindParam(':SchuelerID', $SchuelerID);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                          , SatzID
                          , SchuelerID
                          , COALESCE(Bemerkung, '') as Bemerkung
                          FROM `schueler_satz`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->SatzID=$row_data["SatzID"]; 
      $this->SchuelerID=$row_data["SchuelerID"];     
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>Lösche schueler_satz ID: '.$this->ID.':</p>';
    $delete = $db->prepare("DELETE FROM `schueler_satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Zeile wurde gelöscht.</p>';   
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
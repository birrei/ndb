<?php 

class SatzErprobt {

  public $table_name; 

  public $ID;
  public $SatzID;
  public $ErprobtID; 
  public $Jahr; 
  public $Bemerkung; 

  public $titles_selected_list; 
  public $Title='SatzErprobt';
  public $Titles='SatzErprobts';  

  public function __construct(){
    $this->table_name='satz_erprobt'; 
  }

  function insert_row () {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_erprobt` 
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
   
  function update_row ($SatzID,$ErprobtID, $Jahr, $Bemerkung) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $update = $db->prepare("UPDATE `satz_erprobt` 
              SET 
                SatzID= :SatzID
              , ErprobtID=:ErprobtID
              , Jahr=:Jahr              
              , Bemerkung = :Bemerkung
              WHERE ID=:ID
              "           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':SatzID', $SatzID);
    $update->bindParam(':ErprobtID', $ErprobtID);
    // $update->bindParam(':Jahr', $Jahr);
    $update->bindParam(':Jahr', $Jahr, ($Jahr==''? PDO::PARAM_NULL:PDO::PARAM_INT));
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
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                          , SatzID
                          , ErprobtID
                          , Jahr
                          , COALESCE(Bemerkung, '') as Bemerkung
                          FROM `satz_erprobt`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->SatzID=$row_data["SatzID"]; 
      $this->ErprobtID=$row_data["ErprobtID"];  
      $this->Jahr=$row_data["Jahr"];    
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function delete(){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>Lösche satz_erprobt ID: '.$this->ID.':</p>';
    $delete = $db->prepare("DELETE FROM `satz_erprobt` WHERE ID=:ID"); 
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
<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class SatzErprobt {

  public $table_name='satz_erprobt'; 

  public $ID='';
  public $SatzID='';
  public $ErprobtID=''; 
  public $Jahr; 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='SatzErprobt';
  public $Titles='SatzErprobts';  

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row () {

    $insert = $this->db->prepare("INSERT INTO `satz_erprobt` 
              SET SatzID = :SatzID"       
           );

    $insert->bindParam(':SatzID', $this->SatzID);

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
   
  function update_row ($SatzID,$ErprobtID, $Jahr, $Bemerkung) {

    // echo '<p>update_row - Parameter:<br />'; 
    // echo 'SatzID: '.$SatzID.'<br />';
    // echo 'ErprobtID: '.$ErprobtID.'<br />';      
    // echo 'Jahr: '.$Jahr.'<br />';     
    // echo 'Bemerkung: '.$Bemerkung.'<br />';     
    // echo 'Neue ID: '.$this->ID.'<br />';         
    // echo '</p>';       
    
    $update = $this->db->prepare("UPDATE `satz_erprobt` 
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
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function load_row() {

    $select = $this->db->prepare("SELECT ID
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

    // echo '<p>Lösche satz_erprobt ID: '.$this->ID.':</p>';
    $delete = $this->db->prepare("DELETE FROM `satz_erprobt` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Zeile wurde gelöscht.</p>';   
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
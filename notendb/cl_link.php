<?php 

class Link {

  public $table_name; 
  public $ID='';
  public $Name='';
  public $Bezeichnung=''; 
  public $URL=''; 
  public $LinktypeID; 
  public $SammlungID; 
  public $titles_selected_list; 
  public $Title='Link';
  public $Titles='Links';  

  public function __construct(){
    $this->table_name='link'; 
  }

  function insert_row () {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `link` 
              SET SammlungID = :SammlungID"       
           );

    $insert->bindParam(':SammlungID', $this->SammlungID);

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
   
  function update_row ($LinktypeID, $Bezeichnung, $URL) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($this->ID=='') {
      $this->insert_row(); 
    } 
    $update = $db->prepare("UPDATE `link` 
              SET 
                SammlungID=:SammlungID 
              , LinktypeID= :LinktypeID
              , Bezeichnung=:Bezeichnung
              , `URL` = :URL
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':SammlungID', $this->SammlungID);    
    $update->bindParam(':LinktypeID', $LinktypeID);
    $update->bindParam(':Bezeichnung', $Bezeichnung);
    $update->bindParam(':URL', $URL);

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
                          , COALESCE(Bezeichnung, '') as Bezeichnung
                          , COALESCE(URL, '') as URL
                          , LinktypeID
                          , SammlungID 
                          FROM `link`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->SammlungID=$row_data["SammlungID"]; 
      $this->LinktypeID=$row_data["LinktypeID"];  
      $this->Bezeichnung=$row_data["Bezeichnung"];
      $this->URL=$row_data["URL"];    
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
    // echo '<p>Lösche Link ID: '.$this->ID.':</p>';
 
    $delete = $db->prepare("DELETE FROM `link` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Link wurde gelöscht.</p>'; 
      return true;          
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false ; 
    }  
  }  

}

 



?>
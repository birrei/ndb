<?php 

class SchuelerSatz {

  public $table_name; 

  public $ID='';
  public $SatzID='';
  public $StatusID='';
  public $SchuelerID=''; 
  public $DatumVon='' ; 
  public $DatumBis='' ; 

  // DatumBis XXX 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='SatzSchueler';
  public $Titles='SatzSchuelers';  

  public function __construct(){
    $this->table_name='schueler_satz'; 
  }

  function insert_row ($SchuelerID, $SatzID) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($SchuelerID=='' || $SatzID=='') {
      return false; 
    }
       
    // echo 'Insert: SatzID: '.$this->SatzID; // test 

    $insert = $db->prepare("INSERT INTO `schueler_satz` 
              SET SatzID = :SatzID   
                , SchuelerID  = :SchuelerID
                "
           );

    $insert->bindParam(':SatzID', $SatzID);
    $insert->bindParam(':SchuelerID', $SchuelerID);    

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      // $this->load_row();   
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
                          , DatumVon
                          , DatumBis
                          , StatusID 
                          FROM `schueler_satz`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->SatzID=$row_data["SatzID"]; 
      $this->SchuelerID=$row_data["SchuelerID"];     
      $this->Bemerkung=$row_data["Bemerkung"];
      $this->DatumVon=$row_data["DatumVon"];
      $this->DatumBis=$row_data["DatumBis"];     
      $this->StatusID=$row_data["StatusID"];                    
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
    echo '<p>Lösche schueler_satz ID: '.$this->ID.':</p>';
    $delete = $db->prepare("DELETE FROM `schueler_satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
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

 
  function update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID) {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    // echo 'TEST: ID: '.$this->ID; 
    // echo '<br>SchuelerID: '.$SchuelerID; 
    // echo '<br>SatzID: '.$SatzID; 
    // echo '<br>DatumVon: '.$DatumVon; 
    // echo '<br>DatumBis: '.$DatumBis; 

    if ($this->ID=='') {
      $this->insert_row($SchuelerID, $SatzID); 
    }

    $update = $db->prepare("UPDATE `schueler_satz` 
                            SET `SchuelerID`=:SchuelerID,
                                SatzID=:SatzID, 
                                DatumVon=:DatumVon, 
                                DatumBis=:DatumBis, 
                                StatusID=:StatusID, 
                                Bemerkung=:Bemerkung 
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);

    $update->bindParam(':SchuelerID', $SchuelerID, ($SchuelerID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':SatzID', $SatzID, ($SatzID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':StatusID', $StatusID, ($StatusID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':DatumVon', $DatumVon, ($DatumVon==''? PDO::PARAM_NULL:PDO::PARAM_STR));
    $update->bindParam(':DatumBis', $DatumBis, ($DatumBis==''? PDO::PARAM_NULL:PDO::PARAM_STR));
    $update->bindParam(':Bemerkung', $Bemerkung); 

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



}

 



?>
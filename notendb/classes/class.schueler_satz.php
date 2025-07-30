<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class SchuelerSatz {

  public $table_name='schueler_satz'; 

  public $ID='';
  public $SatzID='';
  public $SchuelerID=''; 
  public $StatusID='';
  public $DatumVon='' ; 
  public $DatumBis='' ; 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='SatzSchueler';
  public $Titles='SatzSchuelers';  

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }  

  function insert_row ($SchuelerID, $SatzID) {

    if ($SchuelerID=='' || $SatzID=='') {
      return false; 
    }   

    include_once("class.status.php");
    $status=new Status();      
    $StatusID= $status->getDefaultID(); 

    // echo 'Insert: SatzID: '.$this->SatzID; // test 
    $insert = $this->db->prepare("INSERT INTO `schueler_satz` 
              SET SatzID = :SatzID   
                  , SchuelerID  = :SchuelerID
                  , StatusID  =:StatusID
                  "
             );

    $insert->bindParam(':SatzID', $SatzID);
    $insert->bindParam(':SchuelerID', $SchuelerID);  
    $insert->bindParam(':StatusID', $StatusID);          

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      // $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
   
  function load_row() {

    $select = $this->db->prepare("SELECT ID
                          , SatzID
                          , SchuelerID
                          , DatumVon
                          , DatumBis
                          , StatusID 
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

    // echo '<p>Lösche schueler_satz ID: '.$this->ID.':</p>';
    $delete = $this->db->prepare("DELETE FROM `schueler_satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      return true;        
    }
    catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false; 
    }  
  }  

 
  function update_row($SchuelerID, $SatzID, $DatumVon, $DatumBis, $Bemerkung, $StatusID) {
    // echo 'TEST: ID: '.$this->ID; 
    // echo '<br>SchuelerID: '.$SchuelerID; 
    // echo '<br>SatzID: '.$SatzID; 
    // echo '<br>DatumVon: '.$DatumVon; 
    // echo '<br>DatumBis: '.$DatumBis; 

    if ($this->ID=='') {
      $this->insert_row($SchuelerID, $SatzID); 
    }

    $update = $this->db->prepare("UPDATE `schueler_satz` 
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
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }



}

 



?>
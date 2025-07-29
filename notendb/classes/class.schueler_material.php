<?php 

class SchuelerMaterial {

  public $table_name; 

  public $ID='';
  public $MaterialID='';
  public $SchuelerID=''; 
  public $StatusID='';
  public $DatumVon='' ; 
  public $DatumBis='' ; 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='Material Schüler';
  public $Titles='Material Schüler'; 
  public $Parent='Material'; // "Material" (dem Material wird ein Schüler hinzugefügt) 
                             // oder "Schueler" (dem Schueler wird Material hinzugefügt) 

  public function __construct(){
    $this->table_name='schueler_material'; 
  }

  
  function insert_row ($SchuelerID, $MaterialID) {

    if ($SchuelerID=='' || $MaterialID=='') {
      return false; 
    }
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    include_once("classes/class.status.php");
    $status=new Status();      
    $StatusID= $status->getDefaultID();     
       
    $insert = $db->prepare("INSERT INTO `schueler_material` 
                            SET SchuelerID =:SchuelerID, 
                                MaterialID =:MaterialID, 
                                StatusID   =:StatusID
                                ");

    $insert->bindParam(':SchuelerID', $SchuelerID);
    $insert->bindParam(':MaterialID', $MaterialID);
    $insert->bindParam(':StatusID', $StatusID);  

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
 
  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                          , MaterialID
                          , SchuelerID
                          , StatusID 
                          , DatumVon
                          , DatumBis
                          , COALESCE(Bemerkung, '') as Bemerkung                          
                          FROM `schueler_material`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->MaterialID=$row_data["MaterialID"]; 
      $this->SchuelerID=$row_data["SchuelerID"];     
      $this->StatusID=$row_data["StatusID"];
      $this->DatumVon=$row_data["DatumVon"];
      $this->DatumBis=$row_data["DatumBis"];                  
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } 
    else {
      return false; 
    }  
  }  


  function update_row($SchuelerID, $MaterialID, $DatumVon, $DatumBis, $Bemerkung, $StatusID) {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    // echo 'TEST: ID: '.$this->ID; 
    // echo '<br>SchuelerID: '.$SchuelerID; 
    // echo '<br$MaterialID: '.$MaterialID; 
    // echo '<br>DatumVon: '.$DatumVon; 
    // echo '<br>DatumBis: '.$DatumBis; 

    if ($this->ID=='') {
      $this->insert_row($SchuelerID, $MaterialID); 
    }

    $update = $db->prepare("UPDATE `schueler_material` 
                            SET `SchuelerID`=:SchuelerID,
                                 MaterialID=:MaterialID, 
                                DatumVon=:DatumVon, 
                                DatumBis=:DatumBis, 
                                StatusID=:StatusID, 
                                Bemerkung=:Bemerkung 
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);

    $update->bindParam(':SchuelerID', $SchuelerID, ($SchuelerID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':MaterialID', $MaterialID, ($MaterialID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
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



  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>Lösche schueler_material ID: '.$this->ID.':</p>';
    $delete = $db->prepare("DELETE FROM `schueler_material` WHERE ID=:ID"); 
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
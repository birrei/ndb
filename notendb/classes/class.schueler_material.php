<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class SchuelerMaterial {

  public $table_name='schueler_material'; 

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

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
  
  function insert_row ($SchuelerID, $MaterialID) {

    if ($SchuelerID=='' || $MaterialID=='') {
      return false; 
    }

    include_once("class.status.php");
    $status=new Status();      
    $StatusID= $status->getDefaultID();     
       
    $insert = $this->db->prepare("INSERT INTO `schueler_material` 
                            SET SchuelerID =:SchuelerID, 
                                MaterialID =:MaterialID, 
                                StatusID   =:StatusID
                                ");

    $insert->bindParam(':SchuelerID', $SchuelerID);
    $insert->bindParam(':MaterialID', $MaterialID);
    $insert->bindParam(':StatusID', $StatusID);  

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();   
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

    // echo 'TEST: ID: '.$this->ID; 
    // echo '<br>SchuelerID: '.$SchuelerID; 
    // echo '<br$MaterialID: '.$MaterialID; 
    // echo '<br>DatumVon: '.$DatumVon; 
    // echo '<br>DatumBis: '.$DatumBis; 

    if ($this->ID=='') {
      $this->insert_row($SchuelerID, $MaterialID); 
    }

    $update = $this->db->prepare("UPDATE `schueler_material` 
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
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }



  function delete(){

    // echo '<p>Lösche schueler_material ID: '.$this->ID.':</p>';
    $delete = $this->db->prepare("DELETE FROM `schueler_material` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Zeile wurde gelöscht.</p>';   
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

}

 



?>
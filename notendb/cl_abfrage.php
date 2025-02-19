
<?php 

class Abfrage {

  public $table_name; 
  public $ID;
  public $Name;
  public $Beschreibung='';
  public $Abfrage; // XXX Umbennenen in "Abfragetext"  
  public $AbfragetypID=0;
  public $Abfragetyp='';  
  public $Tabelle;
  // public $success=false; 
  public $Title='Abfrage';
  public $Titles='Abfragen';    
  public string $infotext=''; 
  
  public function __construct(){
    $this->table_name='abfrage'; 
  }

  function insert_row ($Name) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `abfrage` 
              SET `Name`     = :Name"
           );

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
 
  function insert_row2() {
    /* Anlass: Gespeicherte Suche  */
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($this->Abfragetyp!='') {
      $this->AbfragetypID=$this->getTypID($this->Abfragetyp); 
      if ($this->AbfragetypID==0) {
         include_once("cl_abfragetyp.php");
         $abfragetyp = new Abfragetyp(); 
         $abfragetyp->insert_row($this->Abfragetyp); 
         $this->AbfragetypID = $abfragetyp->ID; 
      }
    }
    
    /* Falls Abfrage mit gleichem Namen schon vorhanden ist, erfolgt ein Update  */
    $checkselect = $db->prepare("SELECT MAX(ID) as maxID FROM abfrage WHERE Name=:Name");
    $checkselect->bindParam(':Name', $this->Name);
    $checkselect->execute(); 
    $existingID=intval($checkselect->fetchColumn()); // = 0, falls Name nicht vorhanden  

    if($existingID > 0 )  {
      $this->ID = $existingID; 
      $this->update_row($this->Name,  $this->Beschreibung, $this->AbfragetypID, $this->Abfrage, $this->Tabelle); 
    } else {
      $insert = $db->prepare("INSERT 
                INTO `abfrage` 
                SET `Name` = :Name, 
                  Beschreibung=:Beschreibung, 
                  AbfragetypID=:AbfragetypID,                  
                  Abfrage=:Abfrage,
                  Tabelle=:Tabelle");
      
      $insert->bindParam(':Name', $this->Name);
      $insert->bindParam(':Beschreibung', $this->Beschreibung);
      $insert->bindParam(':Abfrage', $this->Abfrage);    
      $insert->bindParam(':Tabelle', $this->Tabelle);  
      $insert->bindParam(':AbfragetypID', $this->AbfragetypID);        

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
  }  


  function print_table(){

    $query="SELECT * from abfrage ORDER by Name"; 

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


  function update_row($Name,$Beschreibung,$AbfragetypID) {
    // Nur Name, Beschreibung und Abfragetyp
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `abfrage` 
                            SET
                            `Name`     = :Name
                            , Beschreibung = :Beschreibung
                            , AbfragetypID= :AbfragetypID
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':AbfragetypID', $AbfragetypID);    
    $update->bindParam(':Beschreibung', $Beschreibung);

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

  function update_row2($Abfrage, $Tabelle ) {
    // nur SQL / Tabelle 
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `abfrage` 
                            SET Abfrage=:Abfrage
                            , Tabelle = :Tabelle
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Abfrage', $Abfrage);    
    $update->bindParam(':Tabelle', $Tabelle);    

    try {
      $update->execute(); 
      $this->load_row(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                                , COALESCE(Name,'') Name    
                                , COALESCE(Beschreibung,'') Beschreibung
                                , AbfragetypID 
                                , COALESCE(Abfrage,'') Abfrage
                                , COALESCE(Tabelle,'') Tabelle
                          FROM `abfrage`
                          WHERE `ID` = :ID");
 
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Beschreibung=$row_data["Beschreibung"];
      $this->AbfragetypID=$row_data["AbfragetypID"];      
      $this->Abfrage=$row_data["Abfrage"];
      $this->Tabelle=$row_data["Tabelle"]; 
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
    $delete = $db->prepare("DELETE FROM `abfrage` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Die Abfrage wurde gelöscht.</p>';
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

  function getTypID($Name) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="SELECT coalesce(MAX(ID),0) as TypID from `abfragetyp` WHERE Name=:Name"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindParam(':Name', $Name);
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  } 


}

 



?>
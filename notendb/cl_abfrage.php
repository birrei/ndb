
<?php 

class Abfrage {

  public $table_name; 
  public $ID;
  public $Name;
  public $Beschreibung;
  public $Abfrage;
  public $Tabelle;
  public $success=false; 

  public function __construct(){
    $this->table_name='abfrage'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
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
      $this->success=true; 
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_table(){

    $query="SELECT * from abfrage ORDER by Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->print_table($this->table_name, true); 
      $this->success=true;   
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name,$Beschreibung, $Abfrage, $Tabelle ) {

    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `abfrage` 
                            SET
                            `Name`     = :Name
                            , Beschreibung = :Beschreibung
                            , Abfrage=:Abfrage
                            , Tabelle = :Tabelle
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Beschreibung', $Beschreibung);
    $update->bindParam(':Abfrage', $Abfrage);    
    $update->bindParam(':Tabelle', $Tabelle);    

    try {
      $update->execute(); 
      $this->load_row(); 
      $this->success=true; 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                                , COALESCE(Name,'') Name    
                                , COALESCE(Beschreibung,'') Beschreibung
                                , COALESCE(Abfrage,'') Abfrage
                                , COALESCE(Tabelle,'') Tabelle
                          FROM `abfrage`
                          WHERE `ID` = :ID");
 
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();

    // echo '<p>Anzahl Zeilen: '.$select->rowCount(); 

    if ($select->rowCount()==1) {
      // falls ID existiert 
      $this->success=true; 
      $this->Name=$row_data["Name"];    
      $this->Beschreibung=$row_data["Beschreibung"];
      $this->Abfrage=$row_data["Abfrage"];
      $this->Tabelle=$row_data["Tabelle"]; 
    } else 
    {
      echo '<p>Der Datensatz konnte nicht geladen werden, die ID '.$this->ID.' existiert nicht.'; 
    }
 
  }  

  function delete(){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    $delete = $db->prepare("DELETE FROM `abfrage` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->success=true; 
      echo '<p>Die Abfrage wurde gelöscht.</p>';          
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }  



}

 



?>
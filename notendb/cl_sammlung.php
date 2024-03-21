<?php 
 
class Sammlung {

  public $table_name; 

  
  public $ID;
  public $Name;
  public $VerlagID;
  public $Bestellnummer; 
  // public $Standort; 
  public $StandortID; 
  public $Bemerkung;

  public function __construct(){
    $this->table_name='sammlung'; 
  }


/***** Neue Zeile einfügen ***************/   
  function insert_row($Name) {         
    include_once("cl_db.php");

    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `sammlung` SET
                          `Name`     = :Name");

    $insert->bindValue(':Name', $Name);
    // $insert->bindValue(':VerlagID', $VerlagID);

    try {
      $insert->execute(); 
      $this->ID = $db->lastInsertId();
      $this->Name=$Name; 
      // $this->VerlagID=$VerlagID;  

    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function print_table(){

    $query="SELECT s.ID, s.Name, v.Name as Verlag   
    from sammlung s
    left join verlag v
      on v.ID = s.VerlagID  
    ORDER by s.ID DESC"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $select = $db->prepare($query); 
      
    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->print_table($this->table_name, false); 
    }
    catch (PDOException $e) {
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row(
          $Name
          , $VerlagID
         // , $Standort
         , $StandortID
          , $Bestellnummer
          , $Bemerkung
         ) 
    {

      include_once("cl_db.php");   
      $conn = new DbConn(); 
      $db=$conn->db; 
          
      $update = $db->prepare("UPDATE `sammlung` 
            SET
            `Name`     = :Name,
            `VerlagID`     = :VerlagID,   
            `StandortID`     = :StandortID,                              
            `Bestellnummer`     = :Bestellnummer,   
            `Bemerkung`     = :Bemerkung                               
            WHERE `ID` = :ID");           

      $update->bindParam(':ID', $this->ID);
      $update->bindParam(':Name', $Name);
      $update->bindParam(':VerlagID', $VerlagID);
      $update->bindParam(':StandortID', $StandortID);
      $update->bindParam(':Bestellnummer', $Bestellnummer);
      $update->bindParam(':Bemerkung', $Bemerkung);

      try {
        $update->execute(); 
        $this->Name=$Name;
        $this->VerlagID=$VerlagID;
        $this->StandortID=$StandortID;
        $this->Bestellnummer=$Bestellnummer;
        $this->Bemerkung=$Bemerkung;
      }
      catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($stmt, $e); 
      }
  }

  function print_select($value_selected=''){
    /***** select box (fake) *****/ 
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT DISTINCT 
            `ID` as SammlungID, Name 
            FROM `sammlung` 
            WHERE ID=:ID
            order by `Name`"; 

  	$conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("SammlungID", $value_selected, false); 
    }
    catch (PDOException $e) {
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT 
                          `ID`, 
                          `Name`, 
                          `VerlagID`, 
                          `Bestellnummer` , 
                          `StandortID`, 
                          `Bemerkung`
                        FROM `sammlung`
                        WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data= $select->fetch();

    $this->Name=$row_data["Name"];
    $this->VerlagID=$row_data["VerlagID"];
    $this->Bestellnummer=$row_data["Bestellnummer"];
    $this->StandortID=$row_data["StandortID"];
    $this->Bemerkung=$row_data["Bemerkung"];      
  }
}

 



?>
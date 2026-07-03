<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Schuljahr {

  public $table_name='schuljahr'; 
  public int $ID;
  public string $Name;
  public string $Bezeichnung;
  public string $Datum_Start_EN; // YYYY-MM-DD
  public string $Datum_Ende_EN;
  public string $Datum_Start_DE; // DD.MM.YYYY 
  public string $Datum_Ende_DE;
  public string $Datum_Start_ISO_8601; // YYYYMMDD   // ISO 8601
  public string $Datum_Ende_ISO_8601;
  
  public int $Eingelesen; // Schuljahr kann verwendet werden (Ferientage und Feiertage sind importiert / geprüft)

    
  // public $titles_selected_list; 
  public string $Title='Schuljahr';
  public string $Titles='Schuljahre';  
  public string $infotext=''; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }




  function load_row() {

    $select = $this->db->prepare("SELECT `ID`
                                  , Bezeichnung as `Name`
                                  , Datum_Start
                                  , Datum_Ende 
                                  , Eingelesen
                          FROM `schuljahr` 
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Bezeichnung=$row_data["Name"];    
      $this->Datum_Start_EN=$row_data["Datum_Start"];    
      $this->Datum_Ende_EN=$row_data["Datum_Ende"];    
      $this->Name=$row_data["Name"];    
      $this->Eingelesen=$row_data["Eingelesen"];    

      $Datum_Start = new Datetime($this->Datum_Start_EN); 
      $Datum_Ende = new Datetime($this->Datum_Ende_EN); 
        
      $this->Datum_Start_DE=$Datum_Start->format('d.m.Y');
      $this->Datum_Ende_DE=$Datum_Ende->format('d.m.Y');



      return true; 
    } 
    else {
      return false; 
    }
  }  
  
 
  public function getCurrentID() {

    $sql="SELECT MAX(ID)  
          FROM schuljahr  
          WHERE CURDATE() BETWEEN Datum_Start AND Datum_Ende"; 
    $stmt = $this->db->prepare($sql); 
    // $stmt->bindParam(':SammlungID', $this->SammlungID, PDO::PARAM_INT); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    $this->ID = $col; 
    return $col;      
  }

  public function getIDFromName($strSchuljahr) {
    // strSchuljahr Format "YYYY/YYYY", z.B. 2026/2027 
    $sql="SELECT MAX(ID)  
          FROM schuljahr  
          WHERE Bezeichnung LIKE '%".$strSchuljahr."%'"; 
    // echo $sql; 
    $stmt = $this->db->prepare($sql); 
    // $stmt->bindParam(':SammlungID', $this->SammlungID, PDO::PARAM_INT); 
    $stmt->execute(); 
    // $stmt->debuDumpParams(); 
    $col=$stmt->fetchColumn(); 
    $this->ID = $col; 
    return $col;      
  }

  

}

 



?>
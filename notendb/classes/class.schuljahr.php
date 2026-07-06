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
  public string $Datum_Start; // YYYY-MM-DD
  public string $Datum_Ende;  
  public string $Datum_Start_EN; // YYYY-MM-DD
  public string $Datum_Ende_EN;
  public string $Datum_Start_DE; // DD.MM.YYYY 
  public string $Datum_Ende_DE;
  public string $Datum_Start_ISO_8601; // YYYYMMDD   // ISO 8601
  public string $Datum_Ende_ISO_8601;
  
  public int $Eingelesen; // Schuljahr kann verwendet werden (Ferien und Feiertage sind importiert / geprüft)

    
  // public $titles_selected_list; 
  public string $Title='Schuljahr';
  public string $Titles='Schuljahre';  
  public string $infotext=''; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }


  function insert_row ($Bezeichnung='') {
    
    $insert = $this->db->prepare("INSERT INTO schuljahr  
              SET  Bezeichnung= :Bezeichnung " 
          );
    $insert->bindParam(':Bezeichnung', $Bezeichnung);
  
    try {
      $insert->execute(); 
      // $insert->debugDumpParams(); 
      $this->ID=$this->db->lastInsertId(); 
      $this->load_row();        
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

    function update_row($Name
                , $Datum_Start
                , $Datum_Ende
    ) 
    {
      // XXXX Prüfung Datumswerte 
      $update = $this->db->prepare("UPDATE schuljahr  
                                    SET Bezeichnung = :Name
                                      , Datum_Start = :Datum_Start
                                      , Datum_Ende = :Datum_Ende
                              WHERE `ID` = :ID"); 

      $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
      $update->bindParam(':Name', $Name);
      $update->bindParam(':Datum_Start', $Datum_Start);
      $update->bindParam(':Datum_Ende', $Datum_Ende);
    try {
      $update->execute();
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
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
      $this->Datum_Start=$row_data["Datum_Start"];    
      $this->Datum_Ende=$row_data["Datum_Ende"];       
      // $this->Datum_Start_EN=$row_data["Datum_Start"];    
      // $this->Datum_Ende_EN=$row_data["Datum_Ende"];    
      $this->Name=$row_data["Name"];    
      $this->Eingelesen=$row_data["Eingelesen"];    

      // $Datum_Start = new Datetime($this->Datum_Start_EN); 
      // $Datum_Ende = new Datetime($this->Datum_Ende_EN); 
        
      // $this->Datum_Start_DE=$Datum_Start->format('d.m.Y');
      // $this->Datum_Ende_DE=$Datum_Ende->format('d.m.Y');



      return true; 
    } 
    else {
      return false; 
    }
  }  
  
 
  function is_deletable() {
    $tmpDeletable=true; 

    $this->load_row(); 

    $select = $this->db->prepare("SELECT * from ferien WHERE SchuljahrID=:SchuljahrID");
    $select->bindValue(':SchuljahrID', $this->ID); 
    $select->execute();  


    if ($select->rowCount() > 0 ){
      $this->info->print_warning('Das Schuljahr ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                  Es existieren '.$select->rowCount().' zugeordnete Ferieneinträge.<br>'); 
      $tmpDeletable=false; 
    } 

    $select = $this->db->prepare("SELECT * from feiertag WHERE SchuljahrID=:SchuljahrID");
    $select->bindValue(':SchuljahrID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->info->print_warning('Das Schuljahr ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                  Es existieren '.$select->rowCount().' zugeordnete Feiertage.<br>'); 
      $tmpDeletable=false; 
    } 

    return $tmpDeletable; 

  }


  function delete(){
 
    $delete = $this->db->prepare("DELETE FROM schuljahr WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
     $this->info->print_info('Das Schuljahr wurde gelöscht.');      
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
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

  function print_select(string $value_selected='', string $caption=''){

    $query="SELECT ID, Bezeichnung as Name 
            FROM `schuljahr` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->type=2; 
      $html->caption = $caption;       
      $html->print_select("SchuljahrID", $value_selected); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_preselect(string $value_selected='', string $caption='', $add_null_option=false){

    $query="SELECT ID, Bezeichnung as Name 
            FROM `schuljahr` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_preselect("SchuljahrID", $value_selected, $add_null_option); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

  function print_table(){

    $query="SELECT * from epoche ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  

      
    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

   

}

 



?>
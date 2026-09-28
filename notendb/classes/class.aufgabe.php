<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Aufgabe {

  public $table_name='aufgabe'; 
  public $ID;
  // public $Name;
  public $Beschreibung;
  public $Erledigt=0;
  public $SchuelerID;

  public $titles_selected_list; 
  public $Title='Aufgabe';
  public $Titles='Aufgaben';  
  public string $infotext=''; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($SchuelerID, $Datum) {

    $insert = $this->db->prepare("INSERT INTO `aufgabe` 
              SET SchuelerID = :SchuelerID, `Datum`     = :Datum"
           );

    $insert->bindParam(':SchuelerID', $SchuelerID,PDO::PARAM_INT);
    $insert->bindParam(':Datum', $Datum);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

  function print_table(){

    $query="SELECT * from aufgabe ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
            
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }

  function update_row($Datum, $Beschreibung, $Erledigt, $SchuelerID) {
    
    $update = $this->db->prepare("UPDATE `aufgabe` 
                            SET 
                                -- `Name`     = :Name, 
                                 Datum = :Datum, 
                                 Beschreibung = :Beschreibung, 
                                 SchuelerID = :SchuelerID, 
                                 Erledigt = :Erledigt 
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    // $update->bindParam(':Name', $Name);
    $update->bindParam(':Datum', $Datum);
    $update->bindParam(':Beschreibung', $Beschreibung);
    $update->bindParam(':Erledigt', $Erledigt);
    $update->bindParam(':SchuelerID', $SchuelerID);

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

    $select = $this->db->prepare("SELECT `ID`, Datum, Beschreibung, SchuelerID, Erledigt 
                          FROM `aufgabe`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      // $this->Name=$row_data["Name"];    
      $this->Datum=$row_data["Datum"];    
      $this->Beschreibung=$row_data["Beschreibung"];    
      $this->Erledigt=$row_data["Erledigt"];    
      $this->SchuelerID=$row_data["SchuelerID"];    
      return true; 
    } 
    else {
      return false; 
    }
  }  
  
  function is_deletable() {
    return true; // aktuell keine Abängigkeiten berücksichtigt. 
   
  }

  function delete(){
 
    $delete = $this->db->prepare("DELETE FROM `aufgabe` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // $this->info->print_info('Die Aufgabe wurde gelöscht.');      
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }    

  function copy(){

    $sql="INSERT INTO aufgabe (Beschreibung
                            , Datum
                            , SchuelerID
                            , Erledigt 
                            )
          SELECT CONCAT(Beschreibung, ' (Kopie)') as Beschreibung 
                            , Datum
                            , SchuelerID
                            , 0 as Erledigt 
          FROM aufgabe   
          WHERE ID=:ID 


          ";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    
      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
      $this->infotext='Der Datensatz wurde kopiert.';
      $this->info->print_info($this->infotext);        
    }
    catch (PDOException $e) {     
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }  
  

}

 



?>
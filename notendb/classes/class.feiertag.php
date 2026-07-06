<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Feiertag {

  public $table_name='feiertag'; 
  public int $ID;
  public string $Name; // alias für "Bezeichnung" 
  public string $Bezeichnung;
  public string $Datum;
  public int $SchuljahrID; 
  public string $Bundesland='Baden-Württemberg'; // XXXX Auswahl verfügbar machen (akt. im Formular schreibgeschützt)

  // public $titles_selected_list; 
  public string $Title='Feiertag';
  public string $Titles='Feiertage';
  public string $infotext=''; 
  
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row (string $SchuljahrID) {
    
    $insert = $this->db->prepare("INSERT INTO feiertag 
              SET SchuljahrID= :SchuljahrID, 
              Bundesland='Baden-Württemberg' " 
          );
          // XXXX Bundesland Auswahl fehlt noch 
    $insert->bindParam(':SchuljahrID', $SchuljahrID,PDO::PARAM_INT);
  
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

  function is_deletable() {
    return true; 
  }

  function delete(){
 
    $delete = $this->db->prepare("DELETE FROM feiertag WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
     $this->info->print_info('Der Feiertag wurde gelöscht.');      
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }   

  function print_table(){

    $query="SELECT * from feiertag ORDER by Name"; 

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

  function update_row($Name
                , $Datum
                , $Bundesland
                , $SchuljahrID
    ) 
    {
      // XXXX Prüfung Datumswerte 
      $update = $this->db->prepare("UPDATE feiertag 
                                    SET Bezeichnung = :Name
                                      , Datum = :Datum 
                                      , Bundesland = :Bundesland
                                      , SchuljahrID = :SchuljahrID
                              WHERE `ID` = :ID"); 

      $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
      $update->bindParam(':Name', $Name);
      $update->bindParam(':Datum', $Datum);
      $update->bindParam(':Bundesland', $Bundesland);
      $update->bindParam(':SchuljahrID', $SchuljahrID, PDO::PARAM_INT);

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

    $select = $this->db->prepare("SELECT ID
                                        , Bezeichnung
                                        , Datum
                                        , COALESCE(Bundesland, 'Baden-Württemberg') as Bundesland 
                                        , SchuljahrID  
                          FROM `feiertag` 
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Bezeichnung"];    
      $this->Bezeichnung=$row_data["Bezeichnung"];    
      $this->Datum=$row_data["Datum"];    
      $this->Bundesland=$row_data["Bundesland"];    
      $this->SchuljahrID=$row_data["SchuljahrID"];    
      return true; 
    } 
    else {
      return false; 
    }
    
  }  


}

 



?>
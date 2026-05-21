<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Schuljahr {

  public $table_name='schuljahr'; 
  public int $ID;
  public string $Name;
  // public $titles_selected_list; 
  public string $Title='Schuljahr';
  public string $Titles='Schuljahre';  
  public string $infotext=''; 

  
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  // function insert_row ($Name) {
    //   $insert = $this->db->prepare("INSERT INTO `epoche` 
    //             SET `Name`     = :Name"
    //          );

    //   $insert->bindParam(':Name', $Name);

    //   try {
    //     $insert->execute(); 
    //     $this->ID=$this->db->lastInsertId();
    //     $this->load_row();   
    //   }
    //     catch (PDOException $e) {
    //     $info = new HTML_Info();      
    //     $info->print_user_error(); 
    //     $info->print_error($insert, $e);  ; 
    //   }
  // }  
 
  // function update_row($Name) {

    //   $update = $this->db->prepare("UPDATE `epoche` 
    //                           SET
    //                           `Name`     = :Name
    //                           WHERE `ID` = :ID"); 

    //   $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    //   $update->bindParam(':Name', $Name);

    //   try {
    //     $update->execute();
    //     $this->load_row();  
    //   }
    //   catch (PDOException $e) {
    //     $this->info->print_user_error(); 
    //     $this->info->print_error($update, $e);  
    //   }
  // }

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

  function load_row() {

    $select = $this->db->prepare("SELECT `ID`, Bezeichnung as `Name` 
                          FROM `schuljahr` 
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      return true; 
    } 
    else {
      return false; 
    }
    
  }  
  
 
  // function delete(){
 
  //   $delete = $this->db->prepare("DELETE FROM `epoche` WHERE ID=:ID"); 
  //   $delete->bindValue(':ID', $this->ID);  

  //   try {
  //     $delete->execute(); 
  //     $this->info->print_info('Die Epoche wurde gelöscht');     
  //     return true;         
  //   }
  //   catch (PDOException $e) {
  //     $this->info->print_user_error(); 
  //     $this->info->print_error($delete, $e);  
  //     return false;  
  //   }  
  // }    

  // function is_deletable() {
    

  //   $select = $this->db->prepare("SELECT * from musikstueck WHERE EpocheID=:EpocheID");
  //   $select->bindValue(':EpocheID', $this->ID); 
  //   $select->execute();  

  //   if ($select->rowCount() > 0 ){
  //     $this->load_row(); 
  //     $this->info->print_warning('Epoche ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
  //                                Es existieren '.$select->rowCount().' zugeordnete Musikstücke.<br>'); 
  //     return false;       
  //   } else {
  //     return true; 
  //   }
  // }

}

 



?>
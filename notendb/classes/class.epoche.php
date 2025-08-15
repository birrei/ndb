<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Epoche {

  public $table_name='epoche'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Epoche';
  public $Titles='Epochen';  
  public string $infotext=''; 

  private $db; 
  private $info; 
  
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `epoche` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='', $caption=''){

    $query="SELECT ID, Name 
            FROM `epoche` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("EpocheID", $value_selected, true); 
      
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

  function update_row($Name) {

    $update = $this->db->prepare("UPDATE `epoche` 
                            SET
                            `Name`     = :Name
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);

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

    $select = $this->db->prepare("SELECT `ID`, `Name` 
                          FROM `epoche`
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
  
  function print_select_multi($options_selected=[]){

    $query="SELECT ID, Name 
            FROM `epoche` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_select_multi('Epoche', 'Epochen[]', $options_selected, 'Epoche(n):'); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  
 
  function delete(){
 
    $delete = $this->db->prepare("DELETE FROM `epoche` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Die Epoche wurde gelöscht');     
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }    

  function is_deletable() {
    

    $select = $this->db->prepare("SELECT * from musikstueck WHERE EpocheID=:EpocheID");
    $select->bindValue(':EpocheID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Epoche ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                 Es existieren '.$select->rowCount().' zugeordnete Musikstücke.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }

}

 



?>
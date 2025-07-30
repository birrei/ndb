<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Gattung {

  public $table_name='gattung'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Gattung';
  public $Titles='Gattungen';  
  public string $infotext=''; 
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `gattung` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='', $caption=''){

    $query="SELECT ID, Name 
            FROM `gattung` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("GattungID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from gattung ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      include_once("class.html_table.php");      
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  

    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name) {

    $update = $this->db->prepare("UPDATE `gattung` 
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
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {

    $select = $this->db->prepare("SELECT `ID`, `Name` 
                          FROM `gattung`
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
            FROM `gattung` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_select_multi('Gattung', 'Gattungen[]', $options_selected, 'Gattung:'); 
      $this->titles_selected_list = $html->titles_selected_list;
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  } 
  
  
  function delete(){

    $select = $this->db->prepare("SELECT * from musikstueck WHERE GattungID=:GattungID");
    $select->bindValue(':GattungID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Die Gattung ID '.$this->ID.' "'.$this->Name.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
        Musikstücke existiert. </p>';   
      return false;            
    }
 
    $delete = $this->db->prepare("DELETE FROM `gattung` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Die Zeile wurde gelöscht.</p>'; 
      return true;         
    }
    catch (PDOException $e) {
      include_once("class.html_info.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false;  
    }  
  }  


}

 



?>
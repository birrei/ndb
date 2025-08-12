<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 


 class Verlag {

  public $table_name='verlag';
  public $ID;
  public $Name;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Verlag';
  public $Titles='Verlage';  
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `verlag` SET `Name`     = :Name");
    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='', $caption=''){

    $query="SELECT ID, Name 
            FROM `verlag` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("VerlagID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from verlag ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
            
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2(); 
    }
    catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row(
              $Name
            , $Bemerkung    
            ) {
    
    $update = $this->db->prepare("UPDATE `verlag` 
                            SET
                            `Name`     = :Name,
                            `Bemerkung` = :Bemerkung
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID',$this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {

    $select = $this->db->prepare("SELECT `ID`, `Name`, `Bemerkung` 
                          FROM `verlag`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();

    if ($select->rowCount()==1) {
      $this->Name=$row_data["Name"];
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } else {
      return false; 
    }
    
  }  

  function print_select_multi($options_selected=[]){

    $query="SELECT ID, Name 
            FROM `verlag` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_select_multi('Verlag', 'Verlage[]', $options_selected, 'Verlag(e):');
      $this->titles_selected_list = $html->titles_selected_list;        
    }
    catch (PDOException $e) {
      include_once("class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }  

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `verlag` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Verlag wurde gelöscht.'); 
      return true;             
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;   
    }  
  }  

  function is_deletable() {
    
    $select = $this->db->prepare("SELECT * from sammlung WHERE VerlagID=:VerlagID");
    $select->bindValue(':VerlagID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Der Verlag ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                 Es existieren '.$select->rowCount().' zugeordnete Sammlungen.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }


}

 



?>
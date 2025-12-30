<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class status {

  public $table_name='status'; 
  public $ID;
  public $Name;

  public $Title='Status';
  public $Titles='Status';  
  public string $infotext=''; 
  public $titles_selected_list; 


  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `status` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

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
 
  function print_select($value_selected='', $caption='', $required=false, $add_null_option=true){

    $query="SELECT ID, Name 
            FROM `status` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->required=$required;        
      $html->caption = $caption;   
      $html->print_select("StatusID", $value_selected,$add_null_option ); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from status ORDER by Name"; 

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

  function update_row($Name) {
    
    $update = $this->db->prepare("UPDATE `status` 
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
                          FROM `status`
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
            FROM `status` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_select_multi('status', 'status[]', $options_selected, 'status(n):'); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  
 
  function is_deletable() {
    $deletable=true; 

    $tmp_infotext=''; 
    $this->infotext=''; 
    $select = $this->db->prepare("SELECT * from schueler_satz WHERE StatusID=:StatusID");
    $select->bindValue(':StatusID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $deletable=false;       
      $tmp_infotext.='Es existieren noch '.$select->rowCount().' Schüler/Satz-Verknüpfungen<br>';   
    }
    
    $select = $this->db->prepare("SELECT * from schueler_material WHERE StatusID=:StatusID");
    $select->bindValue(':StatusID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $deletable=false;       
      $tmp_infotext.='Es existieren noch '.$select->rowCount().' Schüler/Material-Verknüpfungen<br>';
    }
  
    if (!$deletable) {
      $this->load_row(); 
      $this->infotext='Der Status-Eintrag ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden<br>';
      $this->infotext.=$tmp_infotext; 
      $this->info->print_warning($this->infotext); 
      return false; 
    } else {
      return true; 
    }
  }

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `status` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Status wurde gelöscht.');       
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }    

  function getDefaultID() {

    $sql="SELECT (coalesce(MIN(ID),0)) AS DefaultID FROM status "; 
    $stmt = $this->db->prepare($sql); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  

  function print_preselect($value_selected=''){

    $query="SELECT ID, Name 
                  FROM status 
                  ORDER BY Name";
    
    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_preselect("StatusID", $value_selected, true); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

}

 



?>
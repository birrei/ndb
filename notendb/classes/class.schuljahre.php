<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Schuljahre {

  public $table_name='schuljahr'; 
  public int $ID;
  public string $Name;
  // public $titles_selected_list; 
  public string $Title='Schuljahre';
  public string $infotext=''; 

  
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
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
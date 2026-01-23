<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
// include_once("class.htmltable.php"); 

class Wochentage {

  public $table_name='wochentage'; 
  public $ID;
  public $Name;

  public $Title='Wochentage';
  public $Titles='Wochentage';  
  public string $infotext=''; 
  public $titles_selected_list; 


  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
 
  function print_select($value_selected='', $caption='Wochentag', $required=false, $add_null_option=true){

    $query="SELECT wochentag_nr, wochentag_name  
            FROM `wochentage` 
            WHERE wochentag_nr > 0 
            order by `wochentag_nr`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->required=$required;        
      $html->caption = $caption;   
      $html->print_select("wochentag_nr", $value_selected,$add_null_option ); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }


  function print_preselect($value_selected=''){

    $query="SELECT wochentag_nr, wochentag_name  
            FROM `wochentage` 
            WHERE wochentag_nr > 0 
            order by `wochentag_nr`"; 
    
    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_preselect("wochentag_nr", $value_selected, true); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  




}

 



?>
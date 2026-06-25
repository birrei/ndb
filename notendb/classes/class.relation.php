<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Relation {

  public $table_name='relation';  
  public $ID;
  public $Name;
  public $Relation;
  public $type_key;
  public int $selsize; // Suche: Anzahl Zeilen der Multi-Select Box
  public $titles_selected_list; 
  public $Title='Relation';
  public $Titles='Relationen';
  public $textInfo=''; 
  public $textWarning=''; 
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }


  function print_select($value_selected='', $caption='', $RefKey='', $refID=0){

    switch($RefKey) {
      case 'LookuptypeID': 
        $query="SELECT ID, Name from relation 
                WHERE ID NOT IN (SELECT DISTINCT RelationID 
                                FROM lookuptype_relation
                                WHERE LookuptypeID=:LookuptypeID ) 
                ORDER BY Name";
        $stmt = $this->db->prepare($query); 
        $stmt->bindValue(':LookuptypeID', $refID);    
      break; 

      default: 
        $query="SELECT ID, Name from relation order by Name";
        $stmt = $this->db->prepare($query);       
    }

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("RelationID", $value_selected); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_preselect($value_selected=''){

    $query="SELECT ID, Name 
                  FROM relation 
                  ORDER BY Name";
    
    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_preselect("RelationID", $value_selected, true); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }



}


 



?>
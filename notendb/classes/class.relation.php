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
  public int $selsize; // Anzahl Zeilen Multi-Select Box (Suche)     
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


  // XXX - löschen 
  // function insert_row ($Name) {

  //   $insert = $this->db->prepare("INSERT INTO `lookup_type` 
  //             SET `Name`     = :Name"              
  //          );

  //   $insert->bindParam(':Name', $Name);

  //   try {
  //     $insert->execute(); 
  //     $this->ID=$this->db->lastInsertId();
  //     $this->load_row();   
  //   }
  //     catch (PDOException $e) {
  //     $this->info->print_user_error(); 
  //     $this->info->print_error($insert, $e);  ; 
  //   }
  // }  
  
  // function load_row() {

  //   $select = $this->db->prepare("SELECT ID, Name, Relation, type_key, selsize
  //                         FROM `lookup_type`
  //                         WHERE `ID` = :ID");

  //   $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
  //   $select->execute(); 

  //   if ($select->rowCount()==1) {
  //     $row_data=$select->fetch();      
  //     $this->Name=$row_data["Name"];
  //     // $this->Relation=$row_data["Relation"];
  //     // $this->type_key=$row_data["type_key"];
  //     $this->type_key=(empty($row_data["type_key"])?'typekey'.strval($this->ID):$row_data["type_key"]); 
  //     $this->selsize=$row_data["selsize"];
  //     return true; 
  //   } 
  //   else {
  //     return false; 
  //   }   
  // }  


}


 



?>
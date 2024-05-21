<?php 
class Lookuptype {

  public $table_name; 
  public $ID;
  public $Name;
  public $Relation; 
  public $sel_Names=[]; // Liste Select-Element Namens-Arrays 
  public $sel_IDs=[]; 
  

  public function __construct(){
    $this->table_name='lookup_type_type'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `lookup_type` 
              SET `Name`     = :Name"
              
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected=''){
      
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name from lookup_type order by Name";

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("LookupTypeID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_preselect($value_selected=''){
      
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name from lookup_type order by Name";

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_preselect("LookupTypeID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  function print_table(){

    $query="SELECT * from lookup_type ORDER by Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->print_table($this->table_name, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name) {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `lookup_type` 
                            SET Name     = :Name
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);

    try {
      $update->execute(); 
      $this->load_row(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID, Name
                          FROM `lookup_type`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->Name=$row_data["Name"];

  }  

  function print_items($item_type){

    $query_lookups = 'select ID, Name, Relation from lookup_type order by ID';

    include_once("cl_db.php");

    $conn = new DbConn(); 
    $db=$conn->db; 
    $select = $db->prepare($query_lookups); 
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);


    foreach ($result as $row) {
      switch($item_type) {
        case 'multiselect': 
            $lookup=New Lookup(); 
            echo '<p><b>'.$row["Name"].':</b><br/>';      
            $lookup->print_select_multi($row["ID"]); 
            echo '</p>';
        
        // break; 
        //   case 'list_names': 




      }
 
    }
       
  }
  


    // $query="SELECT * from lookup_type ORDER by Name"; 

    // include_once("cl_db.php");
    // $conn = new DbConn(); 
    // $db=$conn->db; 

    // $select = $db->prepare($query); 

    // try {
    //   $select->execute(); 
    //   include_once("cl_html_table.php");      
    //   $html = new HtmlTable($select); 
    //   $html->print_table($this->table_name, true); 
      
    // }
    // catch (PDOException $e) {
    //   include_once("cl_html_info.php"); 
    //   $info = new HtmlInfo();      
    //   $info->print_user_error(); 
    //   $info->print_error($select, $e); 
    // }
  





}


 



?>
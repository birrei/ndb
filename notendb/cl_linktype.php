<?php 
class Linktype {

  public $table_name; 
  public $ID;
  public $Name;
  public $Relation;
  public $type_key;
  public $ArrData=[]; 
  public $titles_selected_list; 

  public function __construct(){
    $this->table_name='linktype'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `linktype` 
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

    $query="SELECT ID, Name from linktype order by Name";

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("LinktypeID", $value_selected, true); 
      
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

    $query="SELECT ID, Name from linktype order by Name";

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

    $query="SELECT * from linktype ORDER by Name"; 

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

  function update_row($Name, $Relation, $type_key) {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `linktype` 
                            SET Name     = :Name, 
                              Relation   = :Relation, 
                              type_key   = :type_key
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Relation', $Relation);
    $update->bindParam(':type_key', $type_key);

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

    $select = $db->prepare("SELECT ID, Name, Relation, type_key
                          FROM `linktype`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->Name=$row_data["Name"];
    $this->Relation=$row_data["Relation"];
    $this->type_key=$row_data["type_key"];    
  }  

  function setArrData(){
    include_once("cl_db.php");

    $query_lookups = 'select ID, Name, type_key from linktype order by ID';
    $conn = new DbConn(); 
    $db=$conn->db; 
    $select = $db->prepare($query_lookups); 
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $this->ArrData[] = array(
              'ID'=>$row["ID"], 
              'Name'=>$row["Name"],
              'type_key'=>$row["type_key"]              
             ); 
        }
        // print_r($this->ArrData); // test
    }

  function print_select_multi($options_selected=[]){
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name 
            FROM `linktype` 
            order by `Name`"; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select_multi('Linktyp', 'Linktypen[]', $options_selected, 'Linktyp(en):'); 
      $this->titles_selected_list = $html->titles_selected_list;      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }  
  
}


 



?>
<?php 
class Linktype {

  public $table_name; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Link-Typ';
  public $Titles='Link-Typen';  

  public function __construct(){
    $this->table_name='linktype'; 
  }

  function insert_row ($Name) {
    include_once("dbconn/cl_db.php");
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
      
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name from linktype order by Name";

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->autofocus=true;       
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
      
    include_once("dbconn/cl_db.php");  
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

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();        
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name) {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `linktype` 
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
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID, Name
                          FROM `linktype`
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


  // Verwendung? XXX 
  // function setArrData(){
  //   include_once("dbconn/cl_db.php");

  //   $query_lookups = 'select ID, Name, type_key from linktype order by ID';
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
  //   $select = $db->prepare($query_lookups); 
  //   $select->execute(); 
  //   $result = $select->fetchAll(PDO::FETCH_ASSOC);

  //   foreach ($result as $row) {
  //       $this->ArrData[] = array(
  //             'ID'=>$row["ID"], 
  //             'Name'=>$row["Name"],
  //             'type_key'=>$row["type_key"]              
  //            ); 
  //       }
  //       // print_r($this->ArrData); // test
  //   }

  function print_select_multi($options_selected=[]){
    include_once("dbconn/cl_db.php");  
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

  
  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT * from link WHERE LinktypeID=:LinktypeID");
    $select->bindValue(':LinktypeID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Der Link-Typ ID '.$this->ID.' "'.$this->Name.'"  
      kann nicht gelöscht werden, da noch eine Zuordnung fuer '.$select->rowCount().' Links existiert. </p>';   
      return false;            
    }

    $delete = $db->prepare("DELETE FROM linktype WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Der Link-Typ wurde gelöscht.</p>';    
      return true;       
    }
    catch (PDOException $e) {
      // print_r($e); 
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e); 
      return false;  
    }  
  }   
  
}


 



?>
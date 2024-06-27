<?php 

class Verwendungszweck {

  public $table_name; 
  public $ID;
  public $Name;
  public $titles_selected_list; 

  public function __construct(){
    $this->table_name='verwendungszweck'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `verwendungszweck` 
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
 
  function print_select($value_selected='',$referenced_MusikstueckID=''){
      
    include_once("cl_db.php");  
    include_once("cl_html_select.php");


    $query='SELECT ID, Name 
            FROM `verwendungszweck` ';

    if ($referenced_MusikstueckID!=''){
      $query.='WHERE ID NOT IN 
              (SELECT VerwendungszweckID FROM musikstueck_verwendungszweck  
              WHERE MusikstueckID=:MusikstueckID) ';
    }
    $query.='ORDER BY `Name`'; 


    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    
    if ($referenced_MusikstueckID!=''){
      $stmt->bindParam(':MusikstueckID', $referenced_MusikstueckID);
    }    

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("VerwendungszweckID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_select_multi($options_selected=[]){

    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT ID, Name 
            FROM `verwendungszweck` 
            order by `Name`"; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select_multi('Verwendungszweck', 'Verwendungszwecke[]', $options_selected, 'Verwendungszweck(e):'); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from verwendungszweck ORDER by Name"; 

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
    
    $update = $db->prepare("UPDATE `verwendungszweck` 
                            SET
                            `Name`     = :Name
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID',$this->ID, PDO::PARAM_INT);
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

    $select = $db->prepare("SELECT `ID`, `Name` 
                          FROM `verwendungszweck`
                          WHERE `ID` = :ID");

 
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->Name=$row_data["Name"];
    
  }  





}

 



?>
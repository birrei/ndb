<?php 

/* Für Attribute, die aus "ID" / "Name" bestehen und per Mehrfach-Zuordnung verwendet werden 

*/
class Lookup {

  public $table_name; 
  public $ID;
  public $Name;
  public $TypeID; 
  public $TypeName; 

  public function __construct(){
    $this->table_name='lookup'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `lookup` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->Name=$Name;  
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='',$referenced_SatzID=''){
      
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT Lookup.ID
            , concat(lookup_type.Name, ': ', lookup.Name) as Besonderheit
            FROM lookup 
            INNER JOIN lookup_type 
            ON lookup_type.ID=lookup.lookup_type_ID ";

    if ($referenced_SatzID!=''){
        $query.='WHERE lookup.ID NOT IN 
              (SELECT LookupID FROM satz_lookup 
               WHERE SatzID=:SatzID) ';
    }

    $query.='ORDER BY Besonderheit'; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    if ($referenced_SatzID!=''){
      $stmt->bindParam(':SatzID', $referenced_SatzID);
    }  

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("LookupID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  // function print_table(){

  //   $query="SELECT * from lookup ORDER by Name"; 

  //   include_once("cl_db.php");
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $select = $db->prepare($query); 

  //   try {
  //     $select->execute(); 
  //     include_once("cl_html_table.php");      
  //     $html = new HtmlTable($select); 
  //     $html->print_table($this->table_name, true); 
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($select, $e); 
  //   }
  // }

  // function update_row($Name) {
  //   include_once("cl_db.php");   
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
    
  //   $update = $db->prepare("UPDATE `lookup` 
  //                           SET
  //                           `Name`     = :Name
  //                           WHERE `ID` = :ID"); 

  //   $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
  //   $update->bindParam(':Name', $Name);

  //   try {
  //     $update->execute(); 
  //     $this->Name=$Name;
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }

  // function load_row() {
  //   include_once("cl_db.php");   
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $select = $db->prepare("SELECT `ID`, `Name` 
  //                         FROM `lookup`
  //                         WHERE `ID` = :ID");

  //   $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
  //   $select->execute(); 
  //   $row_data=$select->fetch();
  //   $this->Name=$row_data["Name"];
    
  // }  
  
  // function print_select_multi($options_selected=[]){

  //   include_once("cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query="SELECT ID, Name 
  //           FROM `lookup` 
  //           order by `Name`"; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query); 

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->print_select_multi('Lookup', 'Lookupen[]', $options_selected); 
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }  

}

 



?>
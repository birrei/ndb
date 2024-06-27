<?php 

/* Für Attribute, die aus "ID" / "Name" bestehen und per Mehrfach-Zuordnung verwendet werden 

*/
class Lookup {

  public $table_name; 
  public $ID;
  public $Name;
  public $LookupTypeID; 
  public $LookupTypeKey;   
  public $TypeName; 
  public $ID_List; 
  public $titles_selected_list; 

  public function __construct(){
    $this->table_name='lookup'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `lookup` 
              SET `Name`     = :Name, LookupTypeID=:LookupTypeID"          
           );

    $insert->bindParam(':Name', $Name);
    $insert->bindParam(':LookupTypeID', $this->LookupTypeID);

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
 
  function print_select($value_selected='',$referenced_SatzID=''){
      
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT Lookup.ID
            , concat(lookup_type.Name, ': ', lookup.Name) as Besonderheit
            FROM lookup 
            INNER JOIN lookup_type 
            ON lookup_type.ID=lookup.LookupTypeID 
            WHERE 1=1 ";

    if ($referenced_SatzID!=''){
        $query.='AND lookup.ID NOT IN 
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

  function print_select2($LookupTypeID, $Relation, $referenced_RelationID='',$value_selected=''){
    // Lookup für einen ausgewählten Typ   
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT lookup.ID
            , lookup.Name
            FROM lookup 
            INNER JOIN lookup_type 
            ON lookup_type.ID=lookup.LookupTypeID 
            WHERE 1=1 
            AND LookupTypeID=:LookupTypeID ";

    if ($Relation=='satz' & $referenced_RelationID!=''){
        $query.='AND lookup.ID NOT IN 
              (SELECT LookupID FROM satz_lookup 
               WHERE SatzID=:referenced_RelationID) ';
    }

    $query.='ORDER BY lookup.Name'; 

    // echo $query; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $LookupTypeID);    

    if ($referenced_RelationID!=''){
      $stmt->bindParam(':referenced_RelationID', $referenced_RelationID);
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




  function print_table($LookupTypeID=''){

    $query="SELECT * from v_lookup WHERE 1=1 "; 
    $query.=($LookupTypeID!=''?"AND LookupTypeID = :LookupTypeID ":"");
    $query.="ORDER by Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo $query; 
    $select = $db->prepare($query); 

    if($LookupTypeID!='') {
      $select->bindParam(':LookupTypeID', $LookupTypeID);
    }    

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

  function update_row($Name, $LookupTypeID) {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `lookup` 
                            SET Name     = :Name
                                , LookupTypeID=:LookupTypeID
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':LookupTypeID', $LookupTypeID);    

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

    $select = $db->prepare("SELECT ID, Name, LookupTypeID 
                          FROM `lookup`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->Name=$row_data["Name"];
    $this->LookupTypeID=$row_data["LookupTypeID"];    
    
  }  

  function print_select_multi($type_key, $options_selected=[]){

    include_once("cl_db.php");  
    include_once("cl_html_select.php");
    
    // $this->ID_List=implode(',', $options_selected); 

    $query="SELECT ID, Name from lookup 
          WHERE 1=1 
          AND LookupTypeID = :LookupTypeID 
          ORDER BY Name 
          "; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo $query; 
    $select = $db->prepare($query); 
    $select->bindParam(':LookupTypeID', $this->LookupTypeID);
     

    try {
      $select->execute(); 
      $html = new HtmlSelect($select); 
      $html->print_select_multi($type_key, $type_key.'[]', $options_selected);
      $this->titles_selected_list = $html->titles_selected_list;       
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }  



}

 



?>
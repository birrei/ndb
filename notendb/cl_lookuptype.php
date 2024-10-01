<?php 
class Lookuptype {

  public $table_name; 
  public $ID;
  public $Name;
  public $Relation;
  public $type_key;
  public int $selsize; // Anzahl Zeilen Multi-Select Box (Suche)     
  public $ArrData=[]; 
  public $titles_selected_list; 
  public $Title='Besonderheit-Typ';
  public $Titles='Besonderheit-Typen';
  public $textInfo=''; 
  public $textWarning=''; 

  public function __construct(){
    $this->table_name='lookup_type'; 
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

    if ($this->Relation!='') {
      $query="SELECT ID, Name 
      FROM lookup_type
      WHERE Relation=:Relation  
      ORDER BY Name";

    } else {
      $query="SELECT ID, concat(Name, ' (', Relation,')') as Name
      FROM lookup_type
      ORDER BY Relation, Name";
    }
  

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    if ($this->Relation!='') {
      $stmt->bindParam(':Relation', $this->Relation);
    } 

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

  function update_row($Name, $Relation, $type_key, $selsize) {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    // prüfen, ob Wert "Relation" geändert wurde. 
    // Dieser darf nicht mehr geändert werden, falls bereits lookups vorhanden sind 
    $select = $db->prepare("
        select lookup_type.Relation 
        from lookup_type 
        inner join lookup on lookup.LookupTypeID = lookup_type.ID
        where lookup_type.ID = :ID 
        ");
    $select->bindValue(':ID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $Relation_exists=$select->fetchColumn(); 
      if($Relation != $Relation_exists) {
        $this->textWarning='Der Wert im Feld Relation kann nicht geändert werden, da bereits Zuordnungen vorhanden sind.';
        $Relation=$Relation_exists; 
      }      
    }      
    
    $update = $db->prepare("UPDATE `lookup_type` 
                            SET Name     = :Name, 
                              Relation   = :Relation, 
                              type_key   = :type_key, 
                              selsize = :selsize
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Relation', $Relation);
    $update->bindParam(':type_key', $type_key);
    $update->bindParam(':selsize', $selsize);    

    try {
      $update->execute(); 
      $this->load_row(); 
      return true; 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
      return false; 
    }
  }

  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID, Name, Relation, type_key, selsize
                          FROM `lookup_type`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];
      $this->Relation=$row_data["Relation"];
      // $this->type_key=$row_data["type_key"];
      $this->type_key=(empty($row_data["type_key"])?'typekey'.strval($this->ID):$row_data["type_key"]); 
      $this->selsize=$row_data["selsize"];
      return true; 
    } 
    else {
      return false; 
    }   
  }  

  function setArrData(){
    // alle Typen einer Relation 
    include_once("cl_db.php");

    $query_lookups = 'SELECT ID, Name, type_key, selsize 
                      FROM lookup_type 
                      WHERE Relation=:Relation 
                      AND ID IN (SELECT DISTINCT LookupTypeID from lookup) 
                      order by ID';
    $conn = new DbConn(); 
    $db=$conn->db; 
    $select = $db->prepare($query_lookups); 
    $select->bindParam(':Relation', $this->Relation);    
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $this->ArrData[] = array(
              'ID'=>$row["ID"], 
              'Name'=>$row["Name"],
              'type_key'=>$row["type_key"],
              'selsize'=>$row["selsize"]              
             ); 
        }
        // print_r($this->ArrData); // test
  }

  function delete(){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT * from lookup WHERE LookupTypeID=:LookupTypeID");
    $select->bindValue(':LookupTypeID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Der Besonderheit-Typ ID '.$this->ID.' "'.$this->Name.'"  
      kann nicht gelöscht werden, da noch eine Zuordnung fuer '.$select->rowCount().' Besonderheiten existiert. </p>';   
      return false;            
    }

    $delete = $db->prepare("DELETE FROM lookup_type WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Der Besonderheit-Typ wurde gelöscht.</p>';    
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

  function print_table_lookups($target_file){
    $query="SELECT ID, Name FROM v_lookup where LookupTypeID=:LookupTypeID"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table = 'lookup'; 
      $html->print_table2(); 
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
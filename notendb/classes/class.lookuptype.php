<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Lookuptype {

  public $table_name='lookup_type';  
  public $ID;
  public $Name;

  public $Relation; // Relations-Scope (dynam. übergabe aus Erfassungs-Formular Satz, Sammlung ... ) 
  public $Relations;  // Sammlung zugordneter Relation-Namen
  public $RelationIDs; // Sammlung zugeorndeter Relation-IDs 

  public $type_key;
  public int $selsize; // Anzahl Zeilen Multi-Select Box (Suche)     
  public $titles_selected_list; 
  public $Title='Besonderheit-Typ';
  public $Titles='Besonderheit-Typen';
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

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `lookup_type` 
              SET `Name`     = :Name"              
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  
  
  function load_row() {

    $select = $this->db->prepare("SELECT ID, Name, Relation, type_key, selsize
                          FROM `lookup_type`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];
      // $this->Relation=$row_data["Relation"];
      // $this->type_key=$row_data["type_key"];
      $this->type_key=(empty($row_data["type_key"])?'typekey'.strval($this->ID):$row_data["type_key"]); 
      $this->selsize=$row_data["selsize"];
      return true; 
    } 
    else {
      return false; 
    }   
  }  

  function update_row($Name, $type_key, $selsize) {
    
    $update = $this->db->prepare("UPDATE `lookup_type` 
                            SET Name     = :Name, 
                              type_key   = :type_key, 
                              selsize = :selsize
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':type_key', $type_key);
    $update->bindParam(':selsize', $selsize);    

    try {
      $update->execute(); 
      $this->load_row(); 
      return true; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e); 
      return false; 
    }
  }

  function print_select($value_selected='', $caption=''){

    $query="SELECT ID, Name from lookup_type order by Name";

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("LookupTypeID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_preselect($value_selected=''){

    if ($this->Relation!='') {
      $query="SELECT lookup_type.ID
                    , lookup_type.Name 
              FROM lookup_type
                  INNER JOIN lookuptype_relation ON lookup_type.ID=lookuptype_relation.LookuptypeID 
                  INNER JOIN relation ON relation.ID = lookuptype_relation.RelationID  
              WHERE relation.Name=:Relation  
              ORDER BY Name";
    } 
    // XXXX ??
    // else {
    //   $query="SELECT ID, concat(Name, ' (', Relation,')') as Name
    //   FROM lookup_type
    //   ORDER BY Relation, Name";
    // }

    $stmt = $this->db->prepare($query); 

    if ($this->Relation!='') {
      $stmt->bindParam(':Relation', $this->Relation);
    } 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_preselect("LookupTypeID", $value_selected, true); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from lookup_type ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
            
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();       
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }

  function getArrData(){
    // alle Typen einer Relation 
    $arrTmp=[]; 
    $query_lookups = 'SELECT ID, Name, type_key, selsize 
                      FROM lookup_type 
                      WHERE Relation=:Relation 
                      AND ID IN (SELECT DISTINCT LookupTypeID from lookup) 
                      order by ID';

    $select = $this->db->prepare($query_lookups); 
    $select->bindParam(':Relation', $this->Relation);    
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $arrTmp[] = array(
              'ID'=>$row["ID"], 
              'Name'=>$row["Name"],
              'type_key'=>$row["type_key"],
              'selsize'=>$row["selsize"]              
             ); 
    }
        // print_r($this->ArrData); // test
    return $arrTmp; 
  }

  function delete(){

    $delete = $this->db->prepare("DELETE FROM lookup_type WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Besonderheit-Typ wurde gelöscht.');    
      return true;       
    }
    catch (PDOException $e) {
      // print_r($e); 
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);
      return false;  
    }  
  }   

  function print_table_lookups($target_file){
    $query="SELECT ID, Name FROM v_lookup where LookupTypeID=:LookupTypeID"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->edit_link_table = 'lookup'; 
      $html->edit_link_target_iframe=true;       
      $html->print_table2(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table_relationen($target_file){

    $query="select relation.ID, relation.Name as Relation  
            from lookuptype_relation 
            inner join relation 
            on lookuptype_relation.RelationID = relation.ID 
            where lookuptype_relation.LookuptypeID=:LookupTypeID"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false; 
      $html->edit_link_target_iframe=true;       

      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='LookuptypeID'; 
      $html->del_link_parent_id= $this->ID; 


      $html->print_table2(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function delete_relation($RelationID){

    $delete = $this->db->prepare("DELETE FROM `lookuptype_relation`  
                          WHERE LookuptypeID=:LookuptypeID
                          AND RelationID=:RelationID
                          "
                          ); 
    $delete->bindValue(':LookuptypeID', $this->ID);  
    $delete->bindValue(':RelationID', $RelationID);      

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }  

  function is_deletable() {
    
    $select = $this->db->prepare("SELECT * from lookup WHERE LookupTypeID=:LookupTypeID");
    $select->bindValue(':LookupTypeID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Besonderheit-Typ ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                 Es existieren '.$select->rowCount().' zugeordnete Besonderheiten.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }


  function add_relation ($RelationID){

    $update = $this->db->prepare("INSERT IGNORE INTO `lookuptype_relation` SET
                            `LookuptypeID`     = :LookuptypeID,
                            `RelationID`     = :RelationID");

    $update->bindValue(':LookuptypeID', $this->ID);  
    $update->bindValue(':RelationID', $RelationID);           

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }  

  }

}


 



?>
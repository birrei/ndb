<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.lookuptype.php"); 

class Lookup {

  public $table_name='lookup'; 
  public $ID;
  public $Name;
  public $LookupTypeID; 
  public $LookupTypeKey;   
  public $LookupTypeName; 
  public $LookupTypeRelation; // "satz", "sammlung", "material" oder "musikstueck" 
  public $ReferenceID; // je nach "LookupTypeRelation":  SammlungID, SatzID, MaterialID oder MusikstueckID 
  public $ID_List; 
  public $titles_selected_list; 
  public $Title='Besonderheit';
  public $Titles='Besonderheiten';  
  public string $infotext=''; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($LookupTypeID='') {

    $insert = $this->db->prepare("INSERT INTO `lookup` 
              SET `LookupTypeID` =:LookupTypeID"          
           );

    // $insert->bindParam(':Name', $Name);
    // $insert->bindParam(':LookupTypeID', $LookupTypeID);

    $insert->bindParam(':LookupTypeID', $LookupTypeID, ($LookupTypeID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));


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
 
  function print_select($value_selected='',$caption=''){

    $Relation = $this->LookupTypeRelation; 
    $ReferenceID = $this->ReferenceID;
    $LookupTypeID=$this->LookupTypeID;  

    $query="SELECT lookup.ID
            , lookup.Name as Besonderheit
            -- , concat(lookup_type.Name, ': ', lookup.Name) as Besonderheit
            FROM lookup 
            INNER JOIN lookup_type ON lookup_type.ID=lookup.LookupTypeID 
            INNER JOIN lookuptype_relation ON lookup_type.ID=lookuptype_relation.LookuptypeID 
            INNER JOIN relation ON relation.ID = lookuptype_relation.RelationID  
            WHERE relation.Name=:Relation ".PHP_EOL;

    if ($LookupTypeID!=''){
        $query.="AND lookup.LookupTypeID=:LookupTypeID ".PHP_EOL; 
    }  

    if ($ReferenceID!=''){
      switch ($Relation) {
        case 'sammlung': 
          $query.='AND lookup.ID NOT IN (SELECT LookupID FROM sammlung_lookup WHERE SammlungID=:SammlungID) '.PHP_EOL; 
          break; 

        case 'satz': 
          $query.='AND lookup.ID NOT IN (SELECT LookupID FROM satz_lookup WHERE SatzID=:SatzID) '.PHP_EOL;  
          break; 

        case 'material': 
          $query.='AND lookup.ID NOT IN (SELECT LookupID FROM material_lookup WHERE MaterialID=:MaterialID) '.PHP_EOL;  
          break;           

        }
      }

    $query.='ORDER BY Besonderheit'; 

   // echo '<pre>'.$query.'</pre>';     // test 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':Relation', $Relation);

    if ($LookupTypeID!=''){
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    }  

    if ($ReferenceID!=''){
      switch ($this->LookupTypeRelation) {
        case 'sammlung': 
          $stmt->bindParam(':SammlungID', $ReferenceID, PDO::PARAM_INT);
          break; 

        case 'satz': 
          $stmt->bindParam(':SatzID', $ReferenceID, PDO::PARAM_INT);
          break; 

        case 'material': 
          $stmt->bindParam(':MaterialID', $ReferenceID, PDO::PARAM_INT);
          break;           
        }     
    }  

    try {
      $stmt->execute(); 
      // echo '<pre>'; 
      // $stmt->debugDumpParams(); // TEST 
      // echo '</pre>';      
      $html = new HTML_Select($stmt); 
      $html->autofocus=true; 
      $html->caption = $caption;       
      $html->print_select("LookupID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_select2($LookupTypeID, $ReferenceID='',$value_selected=''){
    // XXXX 
    // Lookup für einen ausgewählten Typ   

    // ReferenceID: SammlungID, SatzID, MaterialID oder MusikstueckID 
    $Relation=$this->LookupTypeRelation; // Optionen: "satz", "sammlung", "material", "musikstueck" 

    $query="SELECT lookup.ID
            , lookup.Name
            FROM lookup 
            INNER JOIN lookup_type 
            ON lookup_type.ID=lookup.LookupTypeID 
            WHERE 1=1 
            AND LookupTypeID=:LookupTypeID ";

    if ($ReferenceID!=''){
        switch($this->LookupTypeRelation) {
          case 'sammlung': 
            $query.='AND lookup.ID NOT IN 
                (SELECT LookupID FROM sammlung_lookup 
                WHERE SammlungID=:RelationID) ';               
            break; 
            
          case 'satz': 
            $query.='AND lookup.ID NOT IN 
                (SELECT LookupID FROM satz_lookup 
                WHERE SatzID=:RelationID) ';            
              break; 
        }
    }

    $query.='ORDER BY lookup.Name'; 

    // echo $query; // Test 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $LookupTypeID);    

    if ($ReferenceID!=''){
      $stmt->bindParam(':RelationID', $ReferenceID);
    }  

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      // $html->caption = $caption;       
      $html->print_select("LookupID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table($LookupTypeID='', $edit_link_open_newpage=true){

    $query="SELECT * from v_lookup WHERE 1=1 "; 
    $query.=($LookupTypeID!=''?"AND LookupTypeID = :LookupTypeID ":"");
    $query.="ORDER by Name"; 

    $select = $this->db->prepare($query); 

    if($LookupTypeID!='') {
      $select->bindParam(':LookupTypeID', $LookupTypeID);
    }    

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

  function update_row($Name, $LookupTypeID) {

    $update = $this->db->prepare("UPDATE `lookup` 
                            SET Name     = :Name
                                , LookupTypeID=:LookupTypeID
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':LookupTypeID', $LookupTypeID, ($LookupTypeID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

    try {
      $update->execute(); 
      $this->load_row(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }

  function load_row() {

    $select = $this->db->prepare("SELECT ID, Name, LookupTypeID 
                          FROM `lookup`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->LookupTypeID=$row_data["LookupTypeID"]; 

      $lookuptype=new Lookuptype();
      $lookuptype->ID = $this->LookupTypeID; 
      $lookuptype->load_row();
      $this->LookupTypeName=$lookuptype->Name; 

      return true; 
    } 
    else {
      return false; 
    }

  }  

  function print_select_multi($type_key
    	  , $options_selected=[]
        , $caption=''
        , $print_check_exact=false // Anzeige Box Aussschluss-Suche
        , $check_exact=false // Ausschluss-Suche aktiviert 
        , $print_check_exclude=false // Anzeige Box Aussschluss-Suche
        , $check_exclude=false // Ausschluss-Suche aktiviert 
    ) {
    
    // $this->ID_List=implode(',', $options_selected); 

    $query="SELECT ID, Name from lookup 
          WHERE 1=1 
          AND LookupTypeID = :LookupTypeID 
          ORDER BY Name 
          "; 

    $lookuptype=new Lookuptype(); 
    $lookuptype->ID = $this->LookupTypeID;
    $lookuptype->load_row(); 

    // echo $query; 
    $select = $this->db->prepare($query); 
    $select->bindParam(':LookupTypeID', $this->LookupTypeID);

    try {
      $select->execute(); 
      $html = new HTML_Select($select); 
      $html->visible_rows=$lookuptype->selsize; 
      $html->print_select_multi($type_key, $type_key.'[]', $options_selected,$caption, $print_check_exact, $check_exact
                              , $print_check_exclude, $check_exclude); 
      $this->titles_selected_list = $html->titles_selected_list;
      // echo  'cl_lookup: '.$this->titles_selected_list;
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }  

  function delete(){

    $delete = $this->db->prepare("DELETE FROM lookup WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Die Besonderheit wurde gelöscht.');             
      return true;       
    }
    catch (PDOException $e) {
      // print_r($e); 
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);
      return false;  
    }  
  } 

  function getArrLookups(){

    $arrTmp=[]; 

    $query_lookups = 'SELECT ID, Name
                      FROM lookup 
                      WHERE LookupTypeID=:LookupTypeID 
                      order by Name';

    $select = $this->db->prepare($query_lookups); 
    $select->bindParam(':LookupTypeID', $this->LookupTypeID);    
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $arrTmp[] = $row["ID"];       
    }
    // print_r($arrTmp); // test
    return  $arrTmp; 
  }

  function is_deletable() {
    
    $select = $this->db->prepare(
      "SELECT ID from sammlung_lookup WHERE LookupID=:LookupID
       UNION 
       SELECT ID from satz_lookup WHERE LookupID=:LookupID 
    ");
    $select->bindValue(':LookupID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Besonderheit ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                  Es existieren '.$select->rowCount().' zugeordnete Zeilen in Sammlung oder Satz.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }




}

 



?>
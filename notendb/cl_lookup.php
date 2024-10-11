<?php 
/* Für Attribute, die aus "ID" / "Name" bestehen und per Mehrfach-Zuordnung verwendet werden 

*/
class Lookup {

  public $table_name; 
  public $ID;
  public $Name;
  public $LookupTypeID; 
  public $LookupTypeKey;   
  public $LookupTypeName; 
  public $LookupTypeRelation; 
  public $ID_List; 
  public $titles_selected_list; 
  public $Title='Besonderheit';
  public $Titles='Besonderheiten';  
  

  public function __construct(){
    $this->table_name='lookup'; 
  }

  function insert_row ($Name) {
    include_once("dbconn/cl_db.php");
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
 
  function print_select($value_selected='',$RelationID='', $caption=''){
      
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT lookup.ID
          -- , concat(lookup_type.Name, ': ', lookup.Name) as Besonderheit
              , lookup.Name as Besonderheit
          FROM lookup 
          INNER JOIN lookup_type 
          ON lookup_type.ID=lookup.LookupTypeID 
          WHERE lookup_type.Relation=:Relation ";


    if ($RelationID!=''){
      switch ($this->LookupTypeRelation) {
        case 'sammlung': 
          $query.='AND lookup.ID NOT IN 
                  (SELECT LookupID FROM sammlung_lookup 
                  WHERE SammlungID=:SammlungID)'; 
          break; 

        case 'satz': 
          $query.='AND lookup.ID NOT IN 
                  (SELECT LookupID FROM satz_lookup 
                  WHERE SatzID=:SatzID)';  
          break; 

        }
      }

    $query.='ORDER BY Besonderheit'; 

   // echo '<pre>'.$query.'</pre>';     // test 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':Relation', $this->LookupTypeRelation);

    if ($RelationID!=''){


      switch ($this->LookupTypeRelation) {
        case 'sammlung': 
          $stmt->bindParam(':SammlungID', $RelationID);
          break; 

        case 'satz': 
          $stmt->bindParam(':SatzID', $RelationID);
          break; 

        }     

    }  

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->autofocus=true; 
      $html->caption = $caption;       
      $html->print_select("LookupID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_select2($LookupTypeID, $RelationID='',$value_selected=''){
    // Lookup für einen ausgewählten Typ   
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT lookup.ID
            , lookup.Name
            FROM lookup 
            INNER JOIN lookup_type 
            ON lookup_type.ID=lookup.LookupTypeID 
            WHERE 1=1 
            AND LookupTypeID=:LookupTypeID ";

    if ($RelationID!=''){
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

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':LookupTypeID', $LookupTypeID);    

    if ($RelationID!=''){
      $stmt->bindParam(':RelationID', $RelationID);
    }  

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->caption = $caption;       
      $html->print_select("LookupID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }




  function print_table($LookupTypeID='', $edit_link_open_newpage=true){

    $query="SELECT * from v_lookup WHERE 1=1 "; 
    $query.=($LookupTypeID!=''?"AND LookupTypeID = :LookupTypeID ":"");
    $query.="ORDER by Name"; 

    include_once("dbconn/cl_db.php");
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

  function update_row($Name, $LookupTypeID) {
    include_once("dbconn/cl_db.php");   
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
    include_once("dbconn/cl_db.php");   
    include_once("cl_lookuptype.php"); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID, Name, LookupTypeID 
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

  function print_select_multi($type_key, $options_selected=[], $caption=''
          , $print_check_excl=false // Anzeige Box Aussschluss-Suche
          , $check_excl=false // Ausschluss-Suche aktiviert 
  ){
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");
    include_once("cl_lookuptype.php");
    
    // $this->ID_List=implode(',', $options_selected); 

    $query="SELECT ID, Name from lookup 
          WHERE 1=1 
          AND LookupTypeID = :LookupTypeID 
          ORDER BY Name 
          "; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $lookuptype=new Lookuptype(); 
    $lookuptype->ID = $this->LookupTypeID;
    $lookuptype->load_row(); 

    // echo $query; 
    $select = $db->prepare($query); 
    $select->bindParam(':LookupTypeID', $this->LookupTypeID);

    try {
      $select->execute(); 
      $html = new HtmlSelect($select); 
      // $html->visible_rows=15; //         XXX Wert konfigurierbar machen (Tabellen-Feld)
      $html->visible_rows=$lookuptype->selsize; 
      $html->print_select_multi($type_key, $type_key.'[]', $options_selected,$caption,  $print_check_excl, $check_excl); // mit Ausschluss-Suche
      $this->titles_selected_list = $html->titles_selected_list;
      // echo  'cl_lookup: '.$this->titles_selected_list;
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }  

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT * from satz_lookup WHERE LookupID=:LookupID");
    $select->bindValue(':LookupID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Die Besonderheit ID '.$this->ID.' "'.$this->Name.'" Typ "'.$this->LookupTypeName.'" 
      kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' Sätze existiert. </p>';   
      return false;            
    }

    $delete = $db->prepare("DELETE FROM lookup WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Die Besonderheit wurde gelöscht.</p>';    
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

  function getArrLookups(){
    include_once("dbconn/cl_db.php");
    $arrTmp=[]; 

    $query_lookups = 'SELECT ID, Name
                      FROM lookup 
                      WHERE LookupTypeID=:LookupTypeID 
                      order by Name';
    $conn = new DbConn(); 
    $db=$conn->db; 
    $select = $db->prepare($query_lookups); 
    $select->bindParam(':LookupTypeID', $this->LookupTypeID);    
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $arrTmp[] = $row["ID"];       
    }
    // print_r($arrTmp); // test
    return  $arrTmp; 
  }


}

 



?>
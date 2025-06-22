<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Besetzung {

  public $table_name='besetzung'; 
  public $ID;
  public $Name;

  public $titles_selected_list; 
  public $Title='Besetzung';
  public $Titles='Besetzungen'; 
  public string $infotext='';  

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `besetzung` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->Name=$Name;  
    }
    catch (PDOException $e) {
     
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='',$referenced_MusikstueckID='', $caption='') {

    $query='SELECT ID, Name FROM `besetzung` ';

    if ($referenced_MusikstueckID!=''){
      $query.='WHERE ID NOT IN 
              (SELECT BesetzungID FROM musikstueck_besetzung 
              WHERE MusikstueckID=:MusikstueckID) ';
    }

    $query.='ORDER BY `Name`'; 

    $stmt = $this->db->prepare($query);
    
    if ($referenced_MusikstueckID!=''){
      $stmt->bindParam(':MusikstueckID', $referenced_MusikstueckID);
    }

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->autofocus=true; 
      $html->caption = $caption; 
      $html->print_select("BesetzungID", $value_selected, true); 
      
    }
    catch (PDOException $e) {    
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_select_multi($options_selected=[], $check_exact=false,$check_exclude=false){

    $query="SELECT ID, Name 
            FROM `besetzung` 
            order by `Name`"; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->visible_rows=15; //
      // $html->print_select_multi('Besetzung', 'Besetzungen[]', $options_selected, 'Besetzung(en):'); 
      $html->print_select_multi('Besetzung', 'Besetzungen[]', $options_selected, 'Besetzung(en):', true, $check_exact, true, $check_exclude); 

      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {     
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table(){

    $query="SELECT * from besetzung ORDER by Name"; 

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

  function update_row($Name) {

    $query="UPDATE `besetzung` 
            SET `Name`     = :Name
            WHERE `ID` = :ID";     

    $update = $this->db->prepare($query); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);

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

    $select = $this->db->prepare("SELECT `ID`, `Name` 
                          FROM `besetzung`
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

  function delete(){

    $select = $this->db->prepare("SELECT * from musikstueck_besetzung WHERE BesetzungID=:BesetzungID");
    $select->bindValue(':BesetzungID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->infotext='Die Besetzung ID '.$this->ID.', Name: "'.$this->Name.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' Musikstücke existiert.';   
      $this->info->print_user_error($this->infotext); 
     return false;            
    }
 
    $delete = $this->db->prepare("DELETE FROM `besetzung` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->infotext='<p>Die Zeile wurde gelöscht.</p>'; 
      $this->info->print_user_error($this->infotext);      
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }

  function getArray(){

    $arrTmp=[]; 

    $query_lookups = 'SELECT ID
                      FROM besetzung 
                      order by ID';

    $select = $this->db->prepare($query_lookups); 
    $select->execute(); 
    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $arrTmp[] = $row["ID"];       
    }
    // print_r($arrTmp); // test
    return  $arrTmp; 
  }


  function copy(){

    $sql="INSERT INTO besetzung (Name)
          SELECT CONCAT(Name, ' (Kopie)') as Name 
          FROM besetzung  
          WHERE ID=:ID 
          ";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    
      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
      $this->infotext='Der Datensatz wurde kopiert.';
      $this->info->print_info($this->infotext);  
    }
    catch (PDOException $e) {   
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }  


}

 



?>
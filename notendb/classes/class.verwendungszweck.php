<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Verwendungszweck {

  public $table_name='verwendungszweck'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Verwendungszweck';
  public $Titles='Verwendungszwecke';  
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `verwendungszweck` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();    
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($value_selected='',$referenced_MusikstueckID='', $caption=''){

    $query='SELECT ID, Name 
            FROM `verwendungszweck` ';

    if ($referenced_MusikstueckID!=''){
      $query.='WHERE ID NOT IN 
              (SELECT VerwendungszweckID FROM musikstueck_verwendungszweck  
              WHERE MusikstueckID=:MusikstueckID) ';
    }
    $query.='ORDER BY `Name`'; 

    $stmt = $this->db->prepare($query); 
    
    if ($referenced_MusikstueckID!=''){
      $stmt->bindParam(':MusikstueckID', $referenced_MusikstueckID);
    }    

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->autofocus=true; 
      $html->caption = $caption;       
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

    $query="SELECT ID, Name 
            FROM `verwendungszweck` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->visible_rows= 10; 
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

    $select = $this->db->prepare($query); 

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

    $update = $this->db->prepare("UPDATE `verwendungszweck` 
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

    $select = $this->db->prepare("SELECT `ID`, `Name` 
                          FROM `verwendungszweck`
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

    $select = $this->db->prepare("SELECT * from musikstueck_verwendungszweck WHERE VerwendungszweckID=:VerwendungszweckID");
    $select->bindValue(':VerwendungszweckID', $this->ID); 
    $select->execute();  
    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      echo '<p>Der Verwendungszweck ID '.$this->ID.' "'.$this->Name.'" 
        kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' Sätze existiert. </p>';   
      return false;            
    }
 
    $delete = $this->db->prepare("DELETE FROM `verwendungszweck` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Der Verwendungszweck wurde gelöscht.</p>'; 
      return true;         
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false;  
    }  
  }  





}

 



?>
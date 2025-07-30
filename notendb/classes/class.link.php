<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 


class Link {

  public $table_name='link'; 
  public $ID='';
  public $Name='';
  public $Bezeichnung=''; 
  public $URL=''; 
  public $LinktypeID; 
  public $SammlungID; 
  public $titles_selected_list; 
  public $Title='Link';
  public $Titles='Links';  
  public string $infotext=''; 
  

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row () {

    $insert = $this->db->prepare("INSERT INTO `link` 
              SET SammlungID = :SammlungID"       
           );

    $insert->bindParam(':SammlungID', $this->SammlungID);

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
   
  function update_row ($LinktypeID, $Bezeichnung, $URL) {

    if ($this->ID=='') {
      $this->insert_row(); 
    } 
    $update = $this->db->prepare("UPDATE `link` 
              SET 
                SammlungID=:SammlungID 
              , LinktypeID= :LinktypeID
              , Bezeichnung=:Bezeichnung
              , `URL` = :URL
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':SammlungID', $this->SammlungID);    
    $update->bindParam(':LinktypeID', $LinktypeID);
    $update->bindParam(':Bezeichnung', $Bezeichnung);
    $update->bindParam(':URL', $URL);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 

  function load_row() {

    $select = $this->db->prepare("SELECT ID
                          , COALESCE(Bezeichnung, '') as Bezeichnung
                          , COALESCE(URL, '') as URL
                          , LinktypeID
                          , SammlungID 
                          FROM `link`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->SammlungID=$row_data["SammlungID"]; 
      $this->LinktypeID=$row_data["LinktypeID"];  
      $this->Bezeichnung=$row_data["Bezeichnung"];
      $this->URL=$row_data["URL"];    
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function delete(){

    // echo '<p>Lösche Link ID: '.$this->ID.':</p>';
 
    $delete = $this->db->prepare("DELETE FROM `link` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Link wurde gelöscht.</p>'; 
      return true;          
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false ; 
    }  
  }  



  function insert_link_tmp ($URL, $Title) {

    $insert = $this->db->prepare("INSERT INTO `link_tmp` 
              SET URL = :URL, Title=:Title "       
           );

    $insert->bindParam(':URL', $URL);
    $insert->bindParam(':Title', $Title);    

    try {
      $insert->execute(); 
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  

  function truncate_link_tmp () {

    $stmt = $this->db->prepare("TRUNCATE TABLE link_tmp");

    try {
      $stmt->execute(); 
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e);  ; 
    }
  }
  
  function print_link_tmp () {
    $query="SELECT * FROM link_tmp"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=false;
      // $html->del_link_filename=$target_file; 
      $html->show_missing_data_message=false; 
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
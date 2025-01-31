<?php 

class Material {

  public $table_name; 
  public $ID='';
  public $Name='';
  public $Bemerkung=''; 
  public $MaterialtypID; 
  public $titles_selected_list; 
  public $Title='Material';
  public $Titles='Materialien';  

  public function __construct(){
    $this->table_name='material'; 
  }

  function insert_row ($MaterialtypID='') {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `material` 
          SET MaterialtypID = :MaterialtypID");
          
    $insert->bindParam(':MaterialtypID', $MaterialtypID, ($MaterialtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

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
   
  function update_row ($MaterialtypID, $Name, $Bemerkung) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($this->ID=='') {
      $this->insert_row(); 
    } 
    $update = $db->prepare("UPDATE `material` 
              SET MaterialtypID= :MaterialtypID
                , `Name`=:Name
                , Bemerkung=:Bemerkung
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    // $update->bindParam(':MaterialtypID', $MaterialtypID);
    $update->bindParam(':MaterialtypID', $MaterialtypID, ($MaterialtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    

    $update->bindParam(':Name', $Name);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($update, $e);  ; 
    }
  }  
 

  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                            , `Name`
                            , COALESCE(Bemerkung, '') as Bemerkung
                            , MaterialtypID
                          FROM `material`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Name=$row_data["Name"];       
      $this->MaterialtypID=$row_data["MaterialtypID"];  
      $this->Bemerkung=$row_data["Bemerkung"]; 
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>Lösche Material ID: '.$this->ID.':</p>';
 
    $delete = $db->prepare("DELETE FROM `material` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Material wurde gelöscht.</p>'; 
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



  function insert_material_tmp ($URL, $Title) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `material_tmp` 
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

  function truncate_material_tmp () {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare("TRUNCATE TABLE material_tmp");

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
  
  function print_material_tmp () {
    $query="SELECT * FROM material_tmp"; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=false;
      // $html->del_material_filename=$target_file; 
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


  function print_table_schueler(){
    $query="SELECT schueler_material.ID 
          , schueler.Name as Schueler
          , schueler_material.Bemerkung  
          FROM schueler_material
          left join schueler 
          on  schueler.ID = schueler_material.SchuelerID  
          WHERE schueler_material.MaterialID = :MaterialID 
          order by schueler.Name  
        "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MaterialID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table='material_schueler'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      $html->add_link_delete=true; // XXX 
      $html->del_link_filename='edit_material_schuelers.php'; 
      // $html->del_link_table='material_erprobt'; // nicht sinnvoll
      $html->del_link_parent_key='MaterialID'; 
      $html->del_link_parent_id= $this->ID;              
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }    


  function print_select( $selected_MaterialID='', $ParentID='', $MaterialtypID=''){

    // XXX Material für einen ausgewählten Typ   

    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT material.ID
			, case when LENGTH(material.Name) > 50
            	THEN CONCAT(LEFT(material.Name, 50), ' (...) (', materialtyp.Name, ')') 
            	ELSE CONCAT(material.Name, ' (',  materialtyp.Name, ')')
            END 
            	as Material
            FROM material 
            INNER JOIN materialtyp 
            ON materialtyp.ID=material.MaterialtypID 
            WHERE 1=1 " ;

    if ($selected_MaterialID!='') {
        $query.=($ParentID!=''?'AND material.ID NOT IN 
              (SELECT MaterialID FROM schueler_material 
              WHERE SchuelerID=:ParentID
              AND MaterialID!=:selected_MaterialID) ':''); 
    } else {
        $query.=($ParentID!=''?'AND material.ID NOT IN 
            (SELECT MaterialID FROM schueler_material 
            WHERE SchuelerID=:ParentID) ':''); 
    }
    
    if ($MaterialtypID!=''){
        $query.="AND MaterialtypID=:MaterialtypID "; 
    }

    

    $query.='ORDER BY material.Name'; 

    // echo $query; // Test 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 

    if ($MaterialtypID!=''){
      $stmt->bindParam(':MaterialtypID', $MaterialtypID, PDO::PARAM_INT);   
    }
    if ($ParentID!=''){
      $stmt->bindParam(':ParentID', $ParentID, PDO::PARAM_INT); 
    }
    if ($selected_MaterialID!=''){
      $stmt->bindParam(':selected_MaterialID', $selected_MaterialID, PDO::PARAM_INT); 
    }


    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      // $stmt->debugDumpParams(); // Test 
      // $html->caption = $caption;       
      $html->print_select("MaterialID", $selected_MaterialID, true); 
      
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
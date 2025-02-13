<?php 

class Schueler {

  public $table_name; 
  public $ID;
  public $Name;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Schüler';
  public $Titles='Schüler';  
  public $Ref = ''; // "Satz" oder "Material" 

  public function __construct(){
    $this->table_name='schueler'; 
  }

  function insert_row ($Name) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `schueler` 
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
 
  function print_select($selected_SchuelerID='', $ParentID='', $caption=''){
    // $ParentID: MaterialID oder SatzID 
    // echo '<p>selected_SchuelerID: '.$selected_SchuelerID.', ParentID: '.$ParentID.'<p>'; // test 
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query='SELECT ID, Name FROM `schueler` WHERE 1=1 ';

    switch ($this->Ref) {
      case 'Satz': 
        if ($ParentID!='') {
          $query.="AND ID NOT IN 
                (SELECT SchuelerID FROM schueler_satz 
                WHERE SatzID=:ParentID ".($selected_SchuelerID!=''?"AND SchuelerID!=:selected_SchuelerID":'').") "; 
        }  
        break; 
      case 'Material': 
        if ($ParentID!='') {
          $query.="AND ID NOT IN 
                (SELECT SchuelerID FROM schueler_material  
                WHERE MaterialID=:ParentID ".($selected_SchuelerID!=''?"AND SchuelerID!=:selected_SchuelerID":'').") "; 
        } 
                               
        break;       
    }

    $query.='ORDER BY `Name`'; 

    // echo $query; // test 

    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $stmt = $db->prepare($query); 

    if ($ParentID!=''){
      // echo 'ParentID'; 
      $stmt->bindParam(':ParentID', $ParentID, PDO::PARAM_INT);

      if ($selected_SchuelerID!=''){
        // echo 'selected_SchuelerID';       
        $stmt->bindParam(':selected_SchuelerID', $selected_SchuelerID, PDO::PARAM_INT);
      }  
    }

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HtmlSelect($stmt); 
      $html->caption = $caption;       
      $html->print_select("SchuelerID", $selected_SchuelerID, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function update_row($Name, $Bemerkung) {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `schueler` 
                            SET`Name`     = :Name,
                            Bemerkung = :Bemerkung 
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
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
      $info->print_error($stmt, $e); 
    }
  }

  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT `ID`, `Name`, COALESCE(Bemerkung, '') as Bemerkung 
                          FROM `schueler`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Bemerkung=$row_data["Bemerkung"];         
      return true; 
    } 
    else {
      return false; 
    }    
  }  
 
  function print_table_schwierigkeitsgrade($target_file){
    $query="SELECT
          instrument.Name as Instrument 
          , schwierigkeitsgrad.Name as Schwierigkeitsgrad
          , instrument.ID 
          , schueler_schwierigkeitsgrad.SchwierigkeitsgradID as ID2          
          FROM schueler_schwierigkeitsgrad 
          inner join schwierigkeitsgrad 
              on  schwierigkeitsgrad.ID = schueler_schwierigkeitsgrad.SchwierigkeitsgradID
          inner join instrument
          on instrument.ID = schueler_schwierigkeitsgrad.InstrumentID 
          WHERE schueler_schwierigkeitsgrad.SchuelerID = :SchuelerID 
          ORDER BY instrument.Name, schwierigkeitsgrad.Name 
        "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SchuelerID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->del_link_count_params=2; 
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
  
  function add_schwierigkeitsgrad($SchwierigkeitsgradID, $InstrumentID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $select = $db->prepare("SELECT * FROM schueler_schwierigkeitsgrad   
                        WHERE 
                        `SchuelerID`     = :SchuelerID AND 
                        `SchwierigkeitsgradID`     = :SchwierigkeitsgradID AND 
                        `InstrumentID`     = :InstrumentID
        ");

    $select->bindValue(':SchuelerID', $this->ID);  
    $select->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
    $select->bindValue(':InstrumentID', $InstrumentID);  

    $select->execute(); 

    if ($select->rowCount()>0 ) {
        echo '<p>Die gewählte Kombination exisitiert bereits!</p>'; 
    } 
    else {
      $insert = $db->prepare("INSERT INTO `schueler_schwierigkeitsgrad` SET
      `SchuelerID`     = :SchuelerID,  
      `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
      `InstrumentID`     = :InstrumentID
      ");

      $insert->bindValue(':SchuelerID', $this->ID);  
      $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
      $insert->bindValue(':InstrumentID', $InstrumentID);      

      try {
        $insert->execute(); 
        include_once("cl_instrument_schwierigkeitsgrad.php");
        $instrument_schwierigkeitsgrad=new InstrumentSchwierigkeitsgrad(); 
        $instrument_schwierigkeitsgrad->insert_row($InstrumentID, $SchwierigkeitsgradID); 
      }
        catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($insert, $e);  
      }  
    }
  }

  function delete_schwierigkeitsgrad($InstrumentID, $SchwierigkeitsgradID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
                          FROM `schueler_schwierigkeitsgrad` 
                          WHERE SchuelerID=:SchuelerID
                          AND InstrumentID=:InstrumentID
                          AND SchwierigkeitsgradID=:SchwierigkeitsgradID"
                        ); 
    $delete->bindValue(':SchuelerID', $this->ID);  
    $delete->bindValue(':InstrumentID', $InstrumentID);      
    $delete->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);    

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }
  
  function print_table_saetze(){
      $query="SELECT schueler_satz.ID
      , sammlung.Name as `Sammlung`
      , musikstueck.Nummer as `Nr`    
      , musikstueck.Name as `Musikstück`
      , satz.Nr as `Satz Nr`    
      , satz.Name as `Satz Name`
      , schueler_satz.Bemerkung  
    -- , schueler_satz.SatzID           
    FROM schueler_satz
    LEFT JOIN satz ON satz.ID = schueler_satz.SatzID  
    LEFT JOIN musikstueck ON musikstueck.ID = satz.MusikstueckID
    LEFT JOIN sammlung ON sammlung.ID = musikstueck.SammlungID                               
    WHERE schueler_satz.SchuelerID = :ID
    order by satz.Name "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table='schueler_satz'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      $html->add_link_delete=true; // XXX 
      $html->del_link_filename='edit_schueler_saetze.php'; 
      $html->del_link_parent_key='SchuelerID'; 
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
  
  function print_table_materials(){
    $query="SELECT schueler_material.ID
            , material.Name as `Material Name`
            , schueler_material.Bemerkung  as `Material Bemerkung`
            , materialtyp.Name  as `Materialtyp`            
           -- , schueler_material.SatzID           
          FROM schueler_material
          LEFT JOIN material ON material.ID = schueler_material.MaterialID  
          LEFT JOIN materialtyp ON materialtyp.ID = material.MaterialtypID                             
          WHERE schueler_material.SchuelerID = :ID
          order by material.Name  
        "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table='schueler_material'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      $html->add_link_delete=true; // XXX 
      $html->del_link_filename='edit_schueler_materials.php'; 
      $html->del_link_parent_key='SchuelerID'; 
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

  function delete_satze(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `schueler_satz` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }

  function delete_materials(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `schueler_material` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }     

  function delete_schwierigkeitsgrade(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `schueler_schwierigkeitsgrad` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }       

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $this->delete_materials(); 
    $this->delete_satze(); 
    $this->delete_schwierigkeitsgrade(); 
      
    $delete = $db->prepare("DELETE FROM `schueler` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Schüler wurde gelöscht. </p>';  
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
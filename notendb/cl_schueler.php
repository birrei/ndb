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
  public string $infotext=''; 
  
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
      $html->autofocus=false;      
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
    schueler_schwierigkeitsgrad.ID 
          , instrument.Name as Instrument 
          , schwierigkeitsgrad.Name as Schwierigkeitsgrad
          -- , instrument.ID 
          -- , schueler_schwierigkeitsgrad.SchwierigkeitsgradID as ID2          
          FROM schueler_schwierigkeitsgrad 
          left join schwierigkeitsgrad 
              on  schwierigkeitsgrad.ID = schueler_schwierigkeitsgrad.SchwierigkeitsgradID
          left join instrument
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
      // $html->del_link_count_params=2; 
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
      $insert->bindParam(':SchwierigkeitsgradID', $SchwierigkeitsgradID, ($SchwierigkeitsgradID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
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

  function delete_schwierigkeitsgrad($ID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
                      FROM `schueler_schwierigkeitsgrad` 
                      WHERE ID=:ID"
                    ); 

    $delete->bindValue(':ID', $ID);      

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
      , status.Name as `Status`
      , schueler_satz.DatumVon as `Datum von` 
      , schueler_satz.DatumBis as `Datum bis` 
      , schueler_satz.Bemerkung

     -- , schueler_satz.SatzID           
    FROM schueler_satz
    LEFT JOIN satz ON satz.ID = schueler_satz.SatzID  
    LEFT JOIN musikstueck ON musikstueck.ID = satz.MusikstueckID
    LEFT JOIN sammlung ON sammlung.ID = musikstueck.SammlungID
    LEFT JOIN status ON status.ID = schueler_satz.StatusID                                
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
      $html->add_link_edit=true;   
      $html->edit_link_table='schueler_satz'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false; 

      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_schueler_satz.php'; 
      // $html->del_link_parent_key='SchuelerID'; 
      // $html->del_link_parent_id= $this->ID;             
      
      // // Link zu Satz-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='SatzID'; 
      // $html->edit2_link_filename='edit_satz.php'; 
      // $html->edit2_link_title='Satz';       

      
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
            , material.Name 
            , sammlung.Name as Sammlung  
            , materialtyp.Name  as `Materialtyp`
            , schueler_material.DatumVon as `Datum von`
            , schueler_material.DatumBis as `Datum bis` 
            , status.Name as Status      
            , schueler_material.Bemerkung                   
          FROM schueler_material
          LEFT JOIN status on status.ID =  schueler_material.StatusID          
          LEFT JOIN material ON material.ID = schueler_material.MaterialID  
          LEFT JOIN materialtyp ON materialtyp.ID = material.MaterialtypID  
          LEFT JOIN sammlung on sammlung.ID = material.SammlungID                            
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
      $html->add_link_edit=true;      
      $html->edit_link_table='schueler_material'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_schueler_materials.php'; 
      // $html->del_link_parent_key='SchuelerID'; 
      // $html->del_link_parent_id= $this->ID;  
      
      // // Link zu Material-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='MaterialID'; 
      // $html->edit2_link_filename='edit_material.php'; 
      // $html->edit2_link_title='Material';       

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

  function copy(){

    include_once("dbconn/cl_db.php");
    include_once("cl_html_info.php"); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="INSERT INTO schueler (Name, Bemerkung)
          SELECT CONCAT(Name, ' (Kopie)') as Name , Bemerkung
          FROM schueler 
          WHERE ID=:ID ";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $db->lastInsertId();    

      $this->copy_schwierigkeitsgrade($ID_New); 
      $this->copy_saetze($ID_New); 
      $this->copy_materials($ID_New); 

      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
    }
    catch (PDOException $e) {
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  } 

  function copy_schwierigkeitsgrade($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="INSERT INTO schueler_schwierigkeitsgrad
          (SchuelerID, SchwierigkeitsgradID, InstrumentID) 
        SELECT :SchuelerID_new as SchuelerID
              , SchwierigkeitsgradID
              , InstrumentID
        FROM schueler_schwierigkeitsgrad 
        WHERE SchuelerID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  
  function copy_saetze($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="INSERT INTO schueler_satz (SchuelerID, SatzID) 
        SELECT :SchuelerID_new as SchuelerID
              , SatzID
        FROM schueler_satz 
        WHERE SchuelerID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function copy_materials($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="INSERT INTO schueler_material(SchuelerID, MaterialID) 
        SELECT :SchuelerID_new as SchuelerID
              , MaterialID
        FROM schueler_material 
        WHERE SchuelerID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function print_table_material_checklist(){
    $query="select distinct material.ID, material.Name
            from material 
            left join schueler_material on material.ID = schueler_material.MaterialID 
                        and schueler_material.SchuelerID = :SchuelerID 
            where schueler_material.ID is null 
            order by material.Name 
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
      $html->print_table_checklist('material'); 


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
<?php 

class Schueler {

  public $table_name; 
  public $ID;
  public $Name;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Schüler';
  public $Titles='Schüler';  

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
 
  // function print_select($value_selected='', $caption=''){
      
  //   include_once("dbconn/cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query="SELECT ID, Name 
  //           FROM `gattung` 
  //           order by `Name`"; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query); 

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->caption = $caption;       
  //     $html->print_select("GattungID", $value_selected, true); 
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }

  // function print_table(){

  //   $query="SELECT * from gattung ORDER by Name"; 

  //   include_once("dbconn/cl_db.php");
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $select = $db->prepare($query); 

  //   try {
  //     $select->execute(); 
  //     include_once("cl_html_table.php");      
  //     $html = new HtmlTable($select); 
  //     $html->edit_link_table= $this->table_name;
  //     $html->print_table2();  

  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($select, $e); 
  //   }
  // }

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

    $select = $db->prepare("SELECT `ID`, `Name`, Bemerkung
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

  
  // function print_select_multi($options_selected=[]){

  //   include_once("dbconn/cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query="SELECT ID, Name 
  //           FROM `gattung` 
  //           order by `Name`"; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query); 

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->print_select_multi('Gattung', 'Gattungen[]', $options_selected, 'Gattung:'); 
  //     $this->titles_selected_list = $html->titles_selected_list;
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // } 
  
  
  // function delete(){
  //   include_once("dbconn/cl_db.php");
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $select = $db->prepare("SELECT * from musikstueck WHERE GattungID=:GattungID");
  //   $select->bindValue(':GattungID', $this->ID); 
  //   $select->execute();  
  //   if ($select->rowCount() > 0 ){
  //     $this->load_row(); 
  //     echo '<p>Die Gattung ID '.$this->ID.' "'.$this->Name.'" 
  //       kann nicht gelöscht werden, da noch eine Zuordnung auf '.$select->rowCount().' 
  //       Musikstücke existiert. </p>';   
  //     return false;            
  //   }
 
  //   $delete = $db->prepare("DELETE FROM `gattung` WHERE ID=:ID"); 
  //   $delete->bindValue(':ID', $this->ID);  

  //   try {
  //     $delete->execute(); 
  //     echo '<p>Die Zeile wurde gelöscht.</p>'; 
  //     return true;         
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($delete, $e);  
  //     return false;  
  //   }  
  // }  




}

 



?>
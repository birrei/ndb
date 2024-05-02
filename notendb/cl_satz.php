<?php 
class Satz {

  public $table_name; 

  public $ID;
  public $Name;
  public $Nr;
  public $MusikstueckID;
  public $Tonart;
  public $Taktart;
  public $Tempobezeichnung;
  public $Spieldauer;
  public $SchwierigkeitsgradID;
  public $Lagen;
  // public $Stricharten;
  public $ErprobtID;
  public $Bemerkung='';
  
  public function __construct(){
    $this->table_name='satz';     
  }

  function insert_row($Nr='', $Name=''){         
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $Nr=($Nr==''? $this->get_next_nr():$Nr); 
    $Name=($Name==''?'(Satz '.$Nr.')':$Name); 
      
    $insert = $db->prepare("INSERT INTO `satz` SET
                          `Nr`     = :Nr,
                          `Name`     = :Name,  
                          `MusikstueckID`     = :MusikstueckID");

    $insert->bindValue(':Nr', $Nr);
    $insert->bindValue(':Name', $Name);
    $insert->bindValue(':MusikstueckID', $this->MusikstueckID);
  
    try {
      $insert->execute(); 
      $this->ID = $db->lastInsertId();
      $this->Nr=$Nr; 
      $this->Name=$Name;  
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e);  
    }  
  }

  function update_row(
            $Name
            , $Nr
            , $MusikstueckID
            , $Tonart
            , $Taktart
            , $Tempobezeichnung
            , $Spieldauer
            , $SchwierigkeitsgradID
            , $Lagen
            , $ErprobtID
            , $Bemerkung
    
         ) {

    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $update = $db->prepare("UPDATE `satz` 
                          SET
                          Name=:Name, 
                          Nr=:Nr, 
                          MusikstueckID=:MusikstueckID, 
                          Tonart=:Tonart, 
                          Taktart=:Taktart, 
                          Tempobezeichnung=:Tempobezeichnung, 
                          Spieldauer=:Spieldauer, 
                          SchwierigkeitsgradID=:SchwierigkeitsgradID, 
                          Lagen=:Lagen, 
                          ErprobtID=:ErprobtID, 
                          Bemerkung=:Bemerkung
                          WHERE `ID` = :ID"); 
  
    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Nr', $Nr);
    $update->bindParam(':MusikstueckID', $MusikstueckID);
    $update->bindParam(':Tonart', $Tonart);
    $update->bindParam(':Taktart', $Taktart);
    $update->bindParam(':Tempobezeichnung', $Tempobezeichnung);
    $update->bindParam(':Spieldauer', $Spieldauer, ($Spieldauer==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':SchwierigkeitsgradID', $SchwierigkeitsgradID, ($SchwierigkeitsgradID==''? PDO::PARAM_NULL:PDO::PARAM_INT));    
    $update->bindParam(':Lagen', $Lagen);
    $update->bindParam(':ErprobtID', $ErprobtID, ($ErprobtID==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->Name=$Name;
      $this->Nr=$Nr;
      $this->MusikstueckID=$MusikstueckID;
      $this->Tonart=$Tonart;
      $this->Taktart=$Taktart;
      $this->Tempobezeichnung=$Tempobezeichnung;
      $this->Spieldauer=$Spieldauer;
      $this->SchwierigkeitsgradID=$SchwierigkeitsgradID;
      $this->Lagen=$Lagen;
      $this->ErprobtID=$ErprobtID;
      $this->Bemerkung=$Bemerkung;

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }


  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT 
                      `ID`
                      ,COALESCE(Name,'') as Name 
                      ,`Nr`
                      ,`MusikstueckID`
                      ,`Tonart`
                      ,`Taktart`
                      ,`Tempobezeichnung`
                      ,`Spieldauer`
                      ,`SchwierigkeitsgradID`
                      ,`Lagen`
                      ,`ErprobtID`
                      , COALESCE(Bemerkung,'') as Bemerkung 
    FROM `satz`
    WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data= $select->fetch();


    $this->Name=$row_data["Name"];
    $this->Nr=$row_data["Nr"];
    $this->MusikstueckID=$row_data["MusikstueckID"];
    $this->Tonart=$row_data["Tonart"];
    $this->Taktart=$row_data["Taktart"];
    $this->Tempobezeichnung=$row_data["Tempobezeichnung"];
    $this->Spieldauer=$row_data["Spieldauer"];
    $this->SchwierigkeitsgradID=$row_data["SchwierigkeitsgradID"];
    $this->Lagen=$row_data["Lagen"];
    $this->ErprobtID=$row_data["ErprobtID"];
    $this->Bemerkung=$row_data["Bemerkung"];
    

  }
  
  function print_table_notenwerte($target_file){
    $query="SELECT satz_notenwert.ID
          -- , satz_notenwert.NotenwertID
          , notenwert.Name                              
          FROM satz_notenwert          
          INNER JOIN notenwert 
            on notenwert.ID=satz_notenwert.NotenwertID
          WHERE satz_notenwert.SatzID = :SatzID 
          ORDER by notenwert.Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table_with_del_link($target_file, 'SatzID', $this->ID); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }
  
  function print_table_sticharten($target_file){
    $query="SELECT ssa.ID
          , sa.Name                              
          FROM satz_strichart ssa         
          inner join strichart sa
            on ssa.StrichartID=sa.ID   
          WHERE ssa.SatzID = :SatzID 
          ORDER by ssa.ID DESC"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      // $html->print_table($this->table_name, true); 
      $html->print_table_with_del_link($target_file, 'SatzID', $this->ID);       
      // $html->print_table(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  function add_strichart ($StrichartID){
      include_once("cl_db.php");
      $conn = new DbConn(); 
      $db=$conn->db; 

      $insert = $db->prepare("INSERT INTO `satz_strichart` SET
          `SatzID`     = :SatzID,  
          `StrichartID`     = :StrichartID");

      $insert->bindValue(':SatzID', $this->ID);  
      $insert->bindValue(':StrichartID', $StrichartID);  

      try {
        $insert->execute(); 
      }
      catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($insert, $e);  
      }  

  }

  function add_notenwert($NotenwertID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_notenwert` SET
        `SatzID`     = :SatzID,  
        `NotenwertID`     = :NotenwertID");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':NotenwertID', $NotenwertID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function delete_notenwert($ID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_notenwert` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function delete_strichart($ID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_strichart` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function print_select($value_selected=''){

    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT DISTINCT 
            `ID` as SammlungID, Name 
            FROM `sammlung` 
            WHERE ID=:ID
            order by `Name`"; 

  	$conn = new DbConn(); 
    $db=$conn->db; 
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("SammlungID", $value_selected, false); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function get_next_nr() {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    $sql="SELECT (coalesce(MAX(Nr),0)) + 1 as next_nr from `satz` 
             WHERE MusikstueckID=:MusikstueckID"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindParam(':MusikstueckID', $this->MusikstueckID, PDO::PARAM_INT); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  

  function add_uebung($UebungID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_uebung` SET
        `SatzID`     = :SatzID,  
        `UebungID`     = :UebungID");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':UebungID', $UebungID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function delete_uebung($ID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_uebung` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function print_table_uebungen($target_file){
    $query="SELECT satz_uebung.ID
          -- , satz_uebung.UebungID
          , uebung.Name                              
          FROM satz_uebung          
          INNER JOIN uebung 
            on uebung.ID=satz_uebung.UebungID
          WHERE satz_uebung.SatzID = :SatzID 
          ORDER by uebung.Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table_with_del_link($target_file, 'SatzID', $this->ID); 
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
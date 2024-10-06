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
  public $ErprobtID;
  public $Bemerkung='';
  public $Orchesterbesetzung=''; 

  public $Title='Satz';
  public $Titles='Sätze';  
  public $autoupdate = true; // XXXconfig ?  
  
  public function __construct(){
    $this->table_name='satz';     
  }

  function insert_row($Nr='', $Name=''){         
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $Nr=($Nr==''? $this->get_next_nr():$Nr); 
    // $Name=($Name==''?'(Satz '.$Nr.')':$Name); 
      
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
      $this->load_row();   
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e);  
    } 

    if ($this->autoupdate) {
      $this->autoupdate_insert_erprobt(); 

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
            // , $ErprobtID
            , $Bemerkung
            , $Orchesterbesetzung
    
         ) {

    include_once("dbconn/cl_db.php");   
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
                          Bemerkung=:Bemerkung,
                          Orchesterbesetzung=:Orchesterbesetzung
                          WHERE `ID` = :ID"); 
  
    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Nr', $Nr);
    $update->bindParam(':MusikstueckID', $MusikstueckID);
    $update->bindParam(':Tonart', $Tonart);
    $update->bindParam(':Taktart', $Taktart);
    $update->bindParam(':Tempobezeichnung', $Tempobezeichnung);
    $update->bindParam(':Spieldauer', $Spieldauer, ($Spieldauer==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);
    $update->bindParam(':Orchesterbesetzung', $Orchesterbesetzung);    

    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($update, $e); 
    }
  }


  function load_row() {
    include_once("dbconn/cl_db.php");   
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
                      ,`ErprobtID`
                      , COALESCE(Bemerkung,'') as Bemerkung 
                      , COALESCE(Orchesterbesetzung,'') as Orchesterbesetzung                       
    FROM `satz`
    WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];
      $this->Nr=$row_data["Nr"];
      $this->MusikstueckID=$row_data["MusikstueckID"];
      $this->Tonart=$row_data["Tonart"];
      $this->Taktart=$row_data["Taktart"];
      $this->Tempobezeichnung=$row_data["Tempobezeichnung"];
      $this->Spieldauer=$row_data["Spieldauer"];
      $this->ErprobtID=$row_data["ErprobtID"];
      $this->Bemerkung=$row_data["Bemerkung"];
      $this->Orchesterbesetzung=$row_data["Orchesterbesetzung"];    
      return true; 
    } 
    else {
      return false; 
    }
  }

  function print_select($value_selected=''){

    include_once("dbconn/cl_db.php");  
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
    include_once("dbconn/cl_db.php");
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
    include_once("dbconn/cl_db.php");
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

  function print_table_lookups($target_file, $LookupTypeID=0){
    $query="SELECT lookup.ID
             , lookup_type.Name as Typ     
             , lookup.Name  
          FROM satz_lookup          
          INNER JOIN lookup 
            on lookup.ID=satz_lookup.LookupID
          INNER JOIN lookup_type
            on lookup_type.ID = lookup.LookupTypeID
            and lookup_type.Relation='satz' 
          WHERE satz_lookup.SatzID = :SatzID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SatzID'; 
      $html->del_link_parent_id= $this->ID; 
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

  function add_lookup($LookupID){

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_lookup` SET
        `SatzID`     = :SatzID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

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

  function delete_lookup($ID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_lookup` 
          WHERE SatzID=:SatzID
          AND LookupID=:LookupID "); 
    $delete->bindValue(':SatzID', $this->ID);            
    $delete->bindValue(':LookupID', $ID);  

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

  function delete_lookups(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_lookup` WHERE SatzID=:ID"); 
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
  
    $this->delete_lookups(); 
    $this->delete_schwierigkeitsgrade(); 
    $this->delete_erprobte(); 
 
    $delete = $db->prepare("DELETE FROM `satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Der Satz wurde gelöscht. </p>';  
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

  function print_table_schwierigkeitsgrade($target_file){
    $query="SELECT instrument.ID 
          , instrument.Name as Instrument 
          , schwierigkeitsgrad.Name as Grad
          FROM satz_schwierigkeitsgrad 
          inner join schwierigkeitsgrad 
              on  schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
          inner join instrument
          on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
          WHERE satz_schwierigkeitsgrad.SatzID = :SatzID 
        "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SatzID'; 
      $html->del_link_parent_id= $this->ID; 
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

    $insert = $db->prepare("INSERT INTO `satz_schwierigkeitsgrad` SET
                        `SatzID`     = :SatzID,  
                        `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
                        `InstrumentID`     = :InstrumentID
        ");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
    $insert->bindValue(':InstrumentID', $InstrumentID);      

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

  function delete_schwierigkeitsgrade(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_schwierigkeitsgrad` WHERE SatzID=:ID"); 
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

  function delete_schwierigkeitsgrad($ID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
                          FROM `satz_schwierigkeitsgrad` 
                          WHERE SatzID=:SatzID
                          AND InstrumentID=:InstrumentID"
                        ); 
    $delete->bindValue(':SatzID', $this->ID);  
    $delete->bindValue(':InstrumentID', $ID);      

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

 function copy( $include_schwierigkeitsgrade=false, $include_lookups=false){
    include_once("dbconn/cl_db.php");

    echo '<p>Starte Kopie Satz ID '.$this->ID.'</p>';      

    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="
        insert into satz (
          MusikstueckID
          , Name
          , Tonart
          , Taktart
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , Nr
          , ErprobtID
      )
      select 
          :MusikstueckID as MusikstueckID
          , Name
          , Tonart
          , Taktart
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , Nr
          , ErprobtID
      from satz 
      where ID=:ID 
    ";
    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MusikstueckID', $this->MusikstueckID);  
    

    try {
      $insert->execute(); 
      $ID_New = $db->lastInsertId();    

      if ($include_schwierigkeitsgrade) {
        // schwierigkeitsgrade 
        $sql="insert into satz_schwierigkeitsgrad
                  (SatzID, SchwierigkeitsgradID, InstrumentID) 
            select :SatzID_new as SatzID
                  , SchwierigkeitsgradID
                  , InstrumentID
            from satz_schwierigkeitsgrad 
            where SatzID=:ID";

        $insert = $db->prepare($sql); 
        $insert->bindValue(':ID', $this->ID);  
        $insert->bindValue(':SatzID_new', $ID_New);  
        $insert->execute();  
        echo '<p>Schwierigkeitsgrade wurden kopiert.</p>';              
      }

      if ($include_lookups) {
        // lookups (Besonderheiten)
        $sql="insert into satz_lookup
                  (SatzID, LookupID) 
            select :SatzID_new as SatzID
                  , LookupID
            from satz_lookup 
            where SatzID=:ID";

        $insert = $db->prepare($sql); 
        $insert->bindValue(':ID', $this->ID);  
        $insert->bindValue(':SatzID_new', $ID_New);  
        $insert->execute();  
        echo '<p>Besonderheiten wurden kopiert.</p>';             
      
      }

      echo '<p>Satz ID '.$this->ID.' wurde kopiert. Neue ID: '.$ID_New.'</p>';      
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }  


  function print_table_erprobte(){
    $query="SELECT satz_erprobt.ID 
          , erprobt.Name as Erprobt
          , satz_erprobt.Jahr
          , satz_erprobt.Bemerkung  
          FROM satz_erprobt 
          left join erprobt 
          on  erprobt.ID = satz_erprobt.ErprobtID 
          WHERE satz_erprobt.SatzID = :SatzID 
          order by satz_erprobt.Jahr DESC 
        "; 

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table='satz_erprobt'; 
      $html->edit_link_title='Erprobt'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      $html->add_link_delete=true; // XXX 
      $html->del_link_filename='edit_satz_erprobte.php'; 
      // $html->del_link_table='satz_erprobt'; // nicht sinnvoll
      $html->del_link_parent_key='SatzID'; 
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

  function add_erprobt($Bemerkung){

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_erprobt` SET
        `Bemerkung`     = :Bemerkung"
      );

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':LookupID', $ErprobtID);  

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

  function delete_erprobte(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `satz_erprobt` WHERE SatzID=:ID"); 
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

  function autoupdate_insert_erprobt() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    // automatische Zuordnung pro Sammlung 
    $sql="
      insert into satz_erprobt (SatzID, ErprobtID) 
      select satz.ID as SatzID, auto_update.upd_ID as ErprobtID 
      from auto_update 
          inner join musikstueck on musikstueck.SammlungID = auto_update.ref_ID     
          inner join satz on satz.MusikstueckID = musikstueck.ID
          left join satz_erprobt on satz_erprobt.SatzID = satz.ID 
                                and satz_erprobt.ErprobtID = auto_update.upd_ID 
      where auto_update.ref_colname='SammlungID'
      and auto_update.upd_colname='ErprobtID'
      and satz.ID = :ID 
      and satz_erprobt.ID IS NULL 
        ";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->execute(); 
    // echo '<p> Anzahl Einfuegungen Erprobt: '.$insert->rowCount().'</p>';     
  }

    
}

 



?>
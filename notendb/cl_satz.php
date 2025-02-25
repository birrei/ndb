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
  // public $autoupdate = false; // verworfen 
  
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

  function load_row2() {
    // Daten aus Musikstück, Sammlung 
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT 
                      `ID`
                      ,COALESCE(Name,'') as Name 
                      ,`Nummer`
                      ,`MusikstueckID`
                      ,`Tonart`
                      ,`Taktart`
                      ,`Tempobezeichnung`
                      ,`Spieldauer`
                      ,`ErprobtID`
                      , COALESCE(Bemerkung,'') as Bemerkung 
                      , COALESCE(Orchesterbesetzung,'') as Orchesterbesetzung                       
    FROM `musikstueck`
    WHERE `ID` = :MusikstueckID");

    $select->bindParam(':MusikstueckID', $this->MusikstueckID, PDO::PARAM_INT);


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

  function print_select($value_selected='', $caption=''){

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
      $html->caption = $caption;       
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
    $this->delete_schuelers(); 
     
    $delete = $db->prepare("DELETE FROM `satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Satz wurde gelöscht. </p>';  
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
          ORDER BY instrument.Name, schwierigkeitsgrad.Name 
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

  // XXX Löschen: 
  // function copy_alt( $include_schwierigkeitsgrade=false, $include_lookups=false){
  //   /* Satz eines musikstücks zu einem anderen Musistück kopieren (abweichende MusikstueckID) */
  //   include_once("dbconn/cl_db.php");

  //   // echo '<p>Starte Kopie Satz ID '.$this->ID.'</p>';      

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $sql="
  //       insert into satz (
  //         MusikstueckID
  //         , Name
  //         , Tonart
  //         , Taktart
  //         , Tempobezeichnung
  //         , Spieldauer
  //         , Bemerkung
  //         , Nr
  //         , ErprobtID
  //         , Orchesterbesetzung            
  //     )
  //     select 
  //         :MusikstueckID as MusikstueckID
  //         , Name
  //         , Tonart
  //         , Taktart
  //         , Tempobezeichnung
  //         , Spieldauer
  //         , Bemerkung
  //         , Nr
  //         , ErprobtID
  //         , Orchesterbesetzung            
  //     from satz 
  //     where ID=:ID 
  //   ";
  //   $insert = $db->prepare($sql); 
  //   $insert->bindValue(':ID', $this->ID);  
  //   $insert->bindValue(':MusikstueckID', $this->MusikstueckID);  
    

  //   try {
  //     $insert->execute(); 
  //     $ID_New = $db->lastInsertId();    

  //     if ($include_schwierigkeitsgrade) {
  //       // schwierigkeitsgrade 
  //       $sql="insert into satz_schwierigkeitsgrad
  //                 (SatzID, SchwierigkeitsgradID, InstrumentID) 
  //           select :SatzID_new as SatzID
  //                 , SchwierigkeitsgradID
  //                 , InstrumentID
  //           from satz_schwierigkeitsgrad 
  //           where SatzID=:ID";

  //       $insert = $db->prepare($sql); 
  //       $insert->bindValue(':ID', $this->ID);  
  //       $insert->bindValue(':SatzID_new', $ID_New);  
  //       $insert->execute();  
  //       echo '<p>Schwierigkeitsgrade wurden kopiert.</p>';              
  //     }

  //     if ($include_lookups) {
  //       // lookups (Besonderheiten)
  //       $sql="insert into satz_lookup
  //                 (SatzID, LookupID) 
  //           select :SatzID_new as SatzID
  //                 , LookupID
  //           from satz_lookup 
  //           where SatzID=:ID";

  //       $insert = $db->prepare($sql); 
  //       $insert->bindValue(':ID', $this->ID);  
  //       $insert->bindValue(':SatzID_new', $ID_New);  
  //       $insert->execute();  
  //       // echo '<p>Besonderheiten wurden kopiert.</p>';             
      
  //     }

  //     echo '<p>Satz ID '.$this->ID.' wurde kopiert. Neue ID: '.$ID_New.'</p>';      
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($insert, $e);  
  //   }  
  // }  

  function copy($MusikstueckID_New=0){
    /* MusikstueckID_New= 0: Kopie von Satz an vorhandenem Musikstück 
       MusikstueckID_New> 0: Kopie von Satz an Kopie von Musikstück 
     */
    include_once("dbconn/cl_db.php");

    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="
        INSERT INTO satz (
          Name
          , MusikstueckID
          , Tonart
          , Taktart
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , Nr
          , ErprobtID
          , Orchesterbesetzung  
      )
      SELECT 
         ".($MusikstueckID_New>0?"Name":"CONCAT(Name, ' (Kopie)') as Name")." 
         , ".($MusikstueckID_New>0?':MusikstueckID':'MusikstueckID')." as MusikstueckID    
          , Tonart
          , Taktart
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , Nr
          , ErprobtID
          , Orchesterbesetzung            
      FROM satz 
      WHERE ID=:ID ";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    if ($MusikstueckID_New>0) {
      $insert->bindValue(':MusikstueckID', $MusikstueckID_New);  
    }

    try {
      $insert->execute(); 

      $ID_New = $db->lastInsertId();   
      
      $this->copy_schwierigkeitsgrade($ID_New ); 

      $this->copy_lookups($ID_New ); 

      $this->copy_erprobte($ID_New );       
      
      $this->copy_schueler($ID_New );      

      $this->ID = $ID_New; 

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }
  
  function copy_schwierigkeitsgrade($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

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
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_erprobte($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="insert into satz_erprobt
          (SatzID, ErprobtID, Jahr, Bemerkung) 
    select :SatzID_new as SatzID
          , ErprobtID
          , Jahr
          , Bemerkung
    from satz_erprobt 
    where SatzID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_lookups($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="insert into satz_lookup
          (SatzID, LookupID) 
    select :SatzID_new as SatzID
          , LookupID
    from satz_lookup 
    where SatzID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_schueler($ID_new) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="insert into schueler_satz
          (SatzID, SchuelerID) 
    select :SatzID_new as SatzID
          , SchuelerID
    from schueler_satz 
    where SatzID=:ID";

    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

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
    // XXX ??? 
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_erprobt` SET
        `Bemerkung`     = :Bemerkung"
      );

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':Bemerkung', $Bemerkung);  // fehler XXX 

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

  function add_erprobt2($ErprobtID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `satz_erprobt` SET
        `SatzID`     = :SatzID , 
        `ErprobtID`     = :ErprobtID "
      );

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':ErprobtID', $ErprobtID);  

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

  function print_table_schueler(){
    $query="SELECT schueler_satz.ID 
          , schueler.Name as Schueler
          , schueler_satz.SchuelerID 
          FROM schueler_satz
          left join schueler 
          on  schueler.ID = schueler_satz.SchuelerID  
          WHERE schueler_satz.SatzID = :SatzID 
          order by schueler.Name  
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
      // $html->edit_link_table='satz_schueler'; 
      // $html->edit_link_title='Schueler'; 
      // $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      $html->add_link_delete=true; // XXX 
      $html->del_link_filename='edit_satz_schuelers.php'; 
      // $html->del_link_table='satz_erprobt'; // nicht sinnvoll
      $html->del_link_parent_key='SatzID'; 
      $html->del_link_parent_id= $this->ID;  
      
      // Link zu Schüler-Formular 
      $html->add_link_edit2=true; 
      $html->edit2_link_colname='SchuelerID'; 
      $html->edit2_link_filename='edit_schueler.php'; 
      $html->edit2_link_title='Schüler';       
       

      $html->print_table2(); 

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }    
    
  function delete_schuelers(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `schueler_satz` WHERE SatzID=:ID"); 
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
   
}

 



?>
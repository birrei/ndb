<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Satz {

  public $table_name='satz'; 

  public $ID;
  public $Name;
  public $Nr;
  public $MusikstueckID;
  public $Tempobezeichnung;
  public $Spieldauer;
  public $ErprobtID;
  public $Bemerkung='';
  public $Orchesterbesetzung=''; 

  public $MusikstueckNr=''; 
  public $Musikstueck=''; 
  
  public $Sammlung=''; 
  

  public $Title='Satz';
  public $Titles='Sätze';  
  // public $autoupdate = false; // verworfen 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row($Nr='', $Name=''){         

    $Nr=($Nr==''? $this->get_next_nr():$Nr); 
    // $Name=($Name==''?'(Satz '.$Nr.')':$Name); 
      
    $insert = $this->db->prepare("INSERT INTO `satz` SET
                          `Nr`     = :Nr,
                          `Name`     = :Name,  
                          `MusikstueckID`     = :MusikstueckID");

    $insert->bindValue(':Nr', $Nr);
    $insert->bindValue(':Name', $Name);
    $insert->bindValue(':MusikstueckID', $this->MusikstueckID);
  
    try {
      $insert->execute(); 
      $this->ID = $this->db->lastInsertId();
      $this->load_row();   
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    } 
  }

  function update_row(
            $Name
            , $Nr
            , $MusikstueckID
            , $Tempobezeichnung
            , $Spieldauer
            // , $ErprobtID
            , $Bemerkung
            , $Orchesterbesetzung
    
         ) {

    $update = $this->db->prepare("UPDATE `satz` 
                          SET
                          Name=:Name, 
                          Nr=:Nr, 
                          MusikstueckID=:MusikstueckID, 
                          Tempobezeichnung=:Tempobezeichnung, 
                          Spieldauer=:Spieldauer, 
                          Bemerkung=:Bemerkung,
                          Orchesterbesetzung=:Orchesterbesetzung
                          WHERE `ID` = :ID"); 
  
    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Nr', $Nr);
    $update->bindParam(':MusikstueckID', $MusikstueckID);
    $update->bindParam(':Tempobezeichnung', $Tempobezeichnung);
    $update->bindParam(':Spieldauer', $Spieldauer, ($Spieldauer==''? PDO::PARAM_NULL:PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);
    $update->bindParam(':Orchesterbesetzung', $Orchesterbesetzung);    

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

    $select = $this->db->prepare("SELECT 
                      `ID`
                      ,COALESCE(Name,'') as Name 
                      ,`Nr`
                      ,`MusikstueckID`
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
    $select = $this->db->prepare("SELECT 
                      `ID`
                      ,COALESCE(Name,'') as Name 
                      ,`Nummer`
                      ,`MusikstueckID`
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

  function load_row3() {
    // Daten aus Musikstück, Sammlung 

    $select = $this->db->prepare("SELECT 
                      satz.ID
                      , COALESCE(satz.Name,'') as Satz 
                      , COALESCE(satz.Nr,'') as SatzNr                       
                      , musikstueck.ID as `MusikstueckID`
                      , COALESCE(musikstueck.Nummer,'') as MusikstueckNr   
                      , COALESCE(musikstueck.Name,'') as Musikstueck   
                      , sammlung.ID as SammlungID 
                      , sammlung.Name as Sammlung
    FROM satz 
          inner join musikstueck on satz.MusikstueckID = musikstueck.ID
          inner join sammlung on sammlung.ID = musikstueck.SammlungID  
    WHERE satz.ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);

    $select->execute(); 


    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Nr=$row_data["SatzNr"];
      $this->Name=$row_data["Satz"];
      $this->MusikstueckNr=$row_data["MusikstueckNr"];      
      $this->Musikstueck=$row_data["Musikstueck"];
      $this->Sammlung=$row_data["Sammlung"];    
      return true; 
    } 
    else {
      return false; 
    }
  }
 
  function print_select($value_selected='', $caption=''){

    $query="SELECT DISTINCT 
            `ID` as SammlungID, Name 
            FROM `sammlung` 
            WHERE ID=:ID
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("SammlungID", $value_selected, false); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function get_next_nr() {

    $sql="SELECT (coalesce(MAX(Nr),0)) + 1 as next_nr from `satz` 
             WHERE MusikstueckID=:MusikstueckID"; 
    $stmt = $this->db->prepare($sql); 
    $stmt->bindParam(':MusikstueckID', $this->MusikstueckID, PDO::PARAM_INT); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  

  function add_uebung($UebungID){

    $insert = $this->db->prepare("INSERT INTO `satz_uebung` SET
        `SatzID`     = :SatzID,  
        `UebungID`     = :UebungID");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':UebungID', $UebungID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
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
          WHERE satz_lookup.SatzID = :SatzID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SatzID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();       
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

  function add_lookup($LookupID){

    $insert = $this->db->prepare("INSERT IGNORE INTO `satz_lookup` SET
        `SatzID`     = :SatzID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function delete_lookup($ID){

    $delete = $this->db->prepare("DELETE FROM `satz_lookup` 
          WHERE SatzID=:SatzID
          AND LookupID=:LookupID "); 
    $delete->bindValue(':SatzID', $this->ID);            
    $delete->bindValue(':LookupID', $ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_lookups(){

    $delete = $this->db->prepare("DELETE FROM `satz_lookup` WHERE SatzID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }
 
  function delete(){
  
    $this->delete_lookups(); 
    $this->delete_schwierigkeitsgrade(); 
    $this->delete_erprobte(); 
    $this->delete_schuelers(); 
     
    $delete = $this->db->prepare("DELETE FROM `satz` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Satz wurde gelöscht.');        
      return true;                
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
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

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SatzID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();           
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

  function add_schwierigkeitsgrad($SchwierigkeitsgradID, $InstrumentID){

    $insert = $this->db->prepare("INSERT INTO `satz_schwierigkeitsgrad` SET
                        `SatzID`     = :SatzID,  
                        `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
                        `InstrumentID`     = :InstrumentID
        ");

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
    $insert->bindValue(':InstrumentID', $InstrumentID);      

    try {
      $insert->execute(); 
      include_once("class.instrument_schwierigkeitsgrad.php");
      $instrument_schwierigkeitsgrad=new InstrumentSchwierigkeitsgrad(); 
      $instrument_schwierigkeitsgrad->insert_row($InstrumentID, $SchwierigkeitsgradID); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function delete_schwierigkeitsgrade(){

    $delete = $this->db->prepare("DELETE FROM `satz_schwierigkeitsgrad` WHERE SatzID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_schwierigkeitsgrad($ID){

    $delete = $this->db->prepare("DELETE 
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
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function copy($MusikstueckID_New=0){
    /* MusikstueckID_New= 0: Kopie von Satz an vorhandenem Musikstück 
       MusikstueckID_New> 0: Kopie von Satz an Kopie von Musikstück 
     */

    $sql="
        INSERT INTO satz (
          Name
          , MusikstueckID
          , Nr          
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , ErprobtID
          , Orchesterbesetzung  
      )
      SELECT ".($MusikstueckID_New>0?"Name":"CONCAT(Name, ' (Kopie)') as Name")." 
          , ".($MusikstueckID_New>0?':MusikstueckID':'MusikstueckID')." as MusikstueckID  
          , ".($MusikstueckID_New>0?'Nr':':Nr')." as Nr               
          , Tempobezeichnung
          , Spieldauer
          , Bemerkung
          , ErprobtID
          , Orchesterbesetzung            
      FROM satz 
      WHERE ID=:ID ";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    
    if ($MusikstueckID_New>0) {
      $insert->bindValue(':MusikstueckID', $MusikstueckID_New);  
    }
    if ($MusikstueckID_New==0) {
      // "Nummer" hochzählen 
      $this->load_row(); // Ziel: $this->MusikstueckID einlesen  
      $Nummer=$this->get_next_nr();  
      $insert->bindValue(':Nr', $Nummer);  
    }

    try {
      $insert->execute(); 

      $ID_New = $this->db->lastInsertId();   
      
      $this->copy_schwierigkeitsgrade($ID_New ); 

      $this->copy_lookups($ID_New ); 

      $this->copy_erprobte($ID_New );       
      
      $this->copy_schueler($ID_New );      

      $this->ID = $ID_New; 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }
  
  function copy_schwierigkeitsgrade($ID_new) {

    // schwierigkeitsgrade 
    $sql="insert into satz_schwierigkeitsgrad
          (SatzID, SchwierigkeitsgradID, InstrumentID) 
    select :SatzID_new as SatzID
          , SchwierigkeitsgradID
          , InstrumentID
    from satz_schwierigkeitsgrad 
    where SatzID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_erprobte($ID_new) {

    $sql="insert into satz_erprobt
          (SatzID, ErprobtID, Jahr, Bemerkung) 
    select :SatzID_new as SatzID
          , ErprobtID
          , Jahr
          , Bemerkung
    from satz_erprobt 
    where SatzID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_lookups($ID_new) {

    $sql="insert into satz_lookup
          (SatzID, LookupID) 
    select :SatzID_new as SatzID
          , LookupID
    from satz_lookup 
    where SatzID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SatzID_new', $ID_new);  
    $insert->execute();  

  }

  function copy_schueler($ID_new) {

    $sql="insert into schueler_satz
          (SatzID, SchuelerID) 
    select :SatzID_new as SatzID
          , SchuelerID
    from schueler_satz 
    where SatzID=:ID";

    $insert = $this->db->prepare($sql); 
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

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
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
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    
 
  function add_erprobt($Bemerkung){
    // XXX ??? 
    $insert = $this->db->prepare("INSERT INTO `satz_erprobt` SET
        `Bemerkung`     = :Bemerkung"
      );

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':Bemerkung', $Bemerkung);  // fehler XXX 

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function delete_erprobte(){

    $delete = $this->db->prepare("DELETE FROM `satz_erprobt` WHERE SatzID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function add_erprobt2($ErprobtID){

    $insert = $this->db->prepare("INSERT INTO `satz_erprobt` SET
        `SatzID`     = :SatzID , 
        `ErprobtID`     = :ErprobtID "
      );

    $insert->bindValue(':SatzID', $this->ID);  
    $insert->bindValue(':ErprobtID', $ErprobtID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }  

  function print_table_schueler(){
    $query="SELECT schueler_satz.ID 
            , schueler.Name as Schueler
            , schueler_satz.DatumVon as `Datum von`
            , schueler_satz.DatumBis as `Datum bis`
            , `status`.`Name` as `Status`   
            , schueler_satz.Bemerkung
            -- , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN                            
           -- , schueler_satz.SchuelerID                   
          FROM schueler_satz
          left join schueler on  schueler.ID = schueler_satz.SchuelerID 
          LEFT JOIN status on status.ID =  schueler_satz.StatusID
          WHERE schueler_satz.SatzID = :SatzID 
          order by schueler.Name  
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=true; 
      $html->edit_link_table='satz_schueler'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;    

      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_satz_schueler.php'; 
      // $html->del_link_parent_key='SatzID'; 
      // $html->del_link_parent_id= $this->ID;  
      
      // // Link zu Schüler-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='SchuelerID'; 
      // $html->edit2_link_filename='edit_schueler.php'; 
      // $html->edit2_link_title='Schüler';       
       
      $html->table_width='100%'; 
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    
    
  function delete_schuelers(){

    $delete = $this->db->prepare("DELETE FROM `schueler_satz` WHERE SatzID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function print_table_schueler_checklist(){
    $query="select distinct schueler.ID, schueler.Name
            from schueler 
            left join schueler_satz on schueler.ID = schueler_satz.SchuelerID 
                        and schueler_satz.SatzID = :SatzID 
            where schueler_satz.ID is null
            and schueler.Aktiv=1  
            order by schueler.Name 
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->print_table_checklist('schueler'); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function getInfo($info_type=1){

    $strtmp=''; 

    switch ($info_type) {

      case 1: 
        $this->load_row3(); 
        $strtmp.=($this->Sammlung!=''?'Sammlung: '.$this->Sammlung.'<br>':''); 
        $strtmp.=($this->MusikstueckNr!=''?'Musikstueck Nr: '.$this->MusikstueckNr.' ':'');         
        $strtmp.=($this->Musikstueck!=''?''.$this->Musikstueck.'<br>':''); 
        $strtmp.=($this->Nr!=''?'Satz Nr: '.$this->Nr.'':' ');         
        $strtmp.=($this->Name!=''?' '.$this->Name.'<br>':''); 

      break; 
    }
    return $strtmp; 
  }
  

  function print($mode){
    /** 
     *  mode 1: nur eine Zeile
     *  mode 2: mehrere Zeilen  
     *  XXXBETA 
     *  XXXX schwierigkeitsgrad in Subquery stecken 
     * */

    $query="SELECT satz.ID as ID
            , CONCAT(' - '
                  , IF(COALESCE(satz.Name,'') <> '', satz.Name,'')
                  , IF(COALESCE(satz.Tempobezeichnung,'') <> '', concat('; Tempo: ', satz.Tempobezeichnung),'')                 
                  , IF(COALESCE(satz.Bemerkung,'') <> '', concat('; Bemerkung: ', satz.Bemerkung),'')
                  , IF(schwierigkeitsgrad.ID IS NOT NULL, GROUP_CONCAT(DISTINCT concat('; Schwierigkeitsgrad(e): ', instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', '), '')                                          
                  , IF(v_satz_lookuptypes.SatzID IS NOT NULL, CONCAT('; Besonderheiten: ', v_satz_lookuptypes.LookupList), '')                                          
                ) 
                 as RowDesc   
    from satz  
        LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
        LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
        LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
        LEFT JOIN instrument_schwierigkeitsgrad 
            ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
            AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
        LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
        LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
        LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
        LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
        LEFT JOIN schueler_satz on schueler_satz.SatzID = satz.ID
    WHERE satz.ID = :ID
    GROUP BY satz.ID    
    ORDER by satz.Nr"; 

    $select = $this->db->prepare($query); 

    $select->bindValue(':ID', $this->ID);  
      
    try {
      $select->execute(); 
      $result = $select->fetch(PDO::FETCH_ASSOC);
      switch($mode) {
        case 1: 
          echo ' '.$result["RowDesc"].' '. PHP_EOL;  
        break; 
        case 2: 
          echo '<p class="print-satz">'.$result["RowDesc"].'</p>'. PHP_EOL;           
        break; 

      }

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }  

  function is_deletable() {
    return true; // aktuell keine Abängigkeiten berücksichtigt. 
  }

function move_order(int $offset=1 ) {

    $select = $this->db->prepare("SELECT `Nr` FROM `satz` WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();      
    $tmpNummer=$row_data["Nr"];
    $tmpNummer=$tmpNummer + $offset; 

    $update = $this->db->prepare("UPDATE `satz` SET `Nr` = :Nr_Neu WHERE `ID` = :ID");           

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Nr_Neu', $tmpNummer , PDO::PARAM_INT);

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }


   
}

 



?>
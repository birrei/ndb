<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.sqlpart.php");

class Schueler {

  public $table_name='schueler'; 
  public $ID;
  public $Name;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Schüler';
  public $Titles='Schüler';  
  public string $infotext=''; 
  public int $Aktiv=1; // true/false, tinyint 1/0 for mysql 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `schueler` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($selected_SchuelerID='', $SatzID='', $caption='', $nurAktiv=false){

    $query=''; 
 
    if ($nurAktiv) {
      $query='SELECT ID, Name FROM `schueler` WHERE Aktiv=1 ';
    } 
    else {
      $query='SELECT ID, Name FROM `schueler` WHERE 1=1 ';
    }

    if ($SatzID!='') {
      $query.="AND ID NOT IN 
            (SELECT SchuelerID FROM schueler_satz 
            WHERE SatzID=:SatzID ".($selected_SchuelerID!=''?"AND SchuelerID!=:selected_SchuelerID":'').") "; 
    }         
    
    $query.='ORDER BY `Name`'; 

    $stmt = $this->db->prepare($query); 

    if ($SatzID!=''){
      // echo 'ParentID'; // test 
      $stmt->bindParam(':SatzID', $ParentID, PDO::PARAM_INT);

      if ($selected_SchuelerID!=''){
        // echo 'selected_SchuelerID';       
        $stmt->bindParam(':selected_SchuelerID', $selected_SchuelerID, PDO::PARAM_INT);
      }  
    }

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;  
      $html->autofocus=false;      
      $html->print_select("SchuelerID", $selected_SchuelerID, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function update_row($Name, $Bemerkung, $Aktiv) {

    $update = $this->db->prepare("UPDATE `schueler` 
                            SET`Name`     = :Name,
                            Bemerkung = :Bemerkung, 
                            Aktiv = :Aktiv
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Bemerkung', $Bemerkung);    
    $update->bindParam(':Aktiv', $Aktiv);   

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

    $select = $this->db->prepare("SELECT `ID`
                          , `Name`
                          , COALESCE(Bemerkung, '') as Bemerkung
                          , Aktiv  
                          FROM `schueler`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Bemerkung=$row_data["Bemerkung"];       
      $this->Aktiv=$row_data["Aktiv"];             
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

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
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
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  
  
  function add_schwierigkeitsgrad($SchwierigkeitsgradID, $InstrumentID){

    $select = $this->db->prepare("SELECT * FROM schueler_schwierigkeitsgrad   
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
      $insert = $this->db->prepare("INSERT INTO `schueler_schwierigkeitsgrad` SET
      `SchuelerID`     = :SchuelerID,  
      `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
      `InstrumentID`     = :InstrumentID
      ");

      $insert->bindValue(':SchuelerID', $this->ID);  
      $insert->bindParam(':SchwierigkeitsgradID', $SchwierigkeitsgradID, ($SchwierigkeitsgradID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
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
  }

  function delete_schwierigkeitsgrad($ID){

    $delete = $this->db->prepare("DELETE 
                      FROM `schueler_schwierigkeitsgrad` 
                      WHERE ID=:ID"
                    ); 

    $delete->bindValue(':ID', $ID);      

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }
  
  function print_table_saetze(){
      $sql = new SQLPart(); 
      $query="SELECT schueler_satz.ID,  "; 
      // $query.=$sql->select_concat_noten_namen; 
      $query.=$sql->getSQL_COL_CONCAT_Noten(1);       
      $query.="
      , status.Name as `Status`
      -- , schueler_satz.DatumVon as `Datum von` 
      -- , schueler_satz.DatumBis as `Datum bis` 
      , schueler_satz.Bemerkung as `Status Bemerkung` 
    FROM schueler_satz
    LEFT JOIN satz ON satz.ID = schueler_satz.SatzID  
    LEFT JOIN musikstueck ON musikstueck.ID = satz.MusikstueckID
    LEFT JOIN sammlung ON sammlung.ID = musikstueck.SammlungID
    LEFT JOIN status ON status.ID = schueler_satz.StatusID                                
    WHERE schueler_satz.SchuelerID = :ID
    order by status.Name, Noten "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
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
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    
  
  function print_table_saetze_lookups(){
    
      $sql = new SQLPart(); 

      $query="SELECT satz.ID,  "; 
      // $query.=$sql->select_concat_noten_namen; 
      $query.=$sql->getSQL_COL_CONCAT_Noten(1); 
      $query.=", v_satz_lookuptypes.LookupList2 as `Satz Besonderheiten`   
              , status.Name as `Status`       
   FROM schueler_satz
    LEFT JOIN satz ON satz.ID = schueler_satz.SatzID  
    LEFT JOIN musikstueck ON musikstueck.ID = satz.MusikstueckID
    LEFT JOIN sammlung ON sammlung.ID = musikstueck.SammlungID
    LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID    
    LEFT JOIN status ON status.ID = schueler_satz.StatusID                                
    WHERE schueler_satz.SchuelerID = :ID
    order by status.Name, Noten "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 

      // $stmt->debugDumpParams(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=true;   
      $html->edit_link_table='satz'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=true; 

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
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    

   function print_table_lookups(){

    $query="SELECT Status, LookupList2 as `Alle Besonderheiten aus zugeordneten Noten`       
    FROM v_schueler_lookuptypes                                  
    WHERE SchuelerID = :ID "; 
  
    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 

      // $stmt->debugDumpParams(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;   
      // $html->edit_link_table='satz'; 
      // $html->edit_link_title='Schueler'; 
      // $html->edit_link_open_newpage=true; 

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
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    
     
  function delete_satze(){

    $delete = $this->db->prepare("DELETE FROM `schueler_satz` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }


  function delete_schwierigkeitsgrade(){

    $delete = $this->db->prepare("DELETE FROM `schueler_schwierigkeitsgrad` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }       

  function delete_uebungen(){

    $delete = $this->db->prepare("DELETE FROM `uebung` WHERE SchuelerID=:ID"); 
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

    $this->delete_satze(); 
    $this->delete_schwierigkeitsgrade(); 
    $this->delete_uebungen();     
      
    $delete = $this->db->prepare("DELETE FROM `schueler` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Schüler wurde gelöscht.');        
      return true;                
    }
    catch (PDOException $e) {  
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false; 
    }  
  }  

  function is_deletable() {
    
    $select = $this->db->prepare("SELECT * from uebung WHERE SchuelerID=:SchuelerID");
    $select->bindValue(':SchuelerID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Der Schüler ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                  Es existieren '.$select->rowCount().' zugeordnete Übungen.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }


  function copy(){

    $sql="INSERT INTO schueler (Name, Bemerkung)
          SELECT CONCAT(Name, ' (Kopie)') as Name , Bemerkung
          FROM schueler 
          WHERE ID=:ID ";
    // Aktiv nicht kopieren, da default = 1

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    

      $this->copy_schwierigkeitsgrade($ID_New); 
      $this->copy_saetze($ID_New); 

      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  } 

  function copy_schwierigkeitsgrade($ID_new) {

    $sql="INSERT INTO schueler_schwierigkeitsgrad
          (SchuelerID, SchwierigkeitsgradID, InstrumentID) 
        SELECT :SchuelerID_new as SchuelerID
              , SchwierigkeitsgradID
              , InstrumentID
        FROM schueler_schwierigkeitsgrad 
        WHERE SchuelerID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function copy_saetze($ID_new) {

    $sql="INSERT INTO schueler_satz (SchuelerID, SatzID) 
        SELECT :SchuelerID_new as SchuelerID
              , SatzID
        FROM schueler_satz 
        WHERE SchuelerID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   


  function print_select_saetze($selected_SatzID=''){

    $query="
      SELECT satz.ID
          , CONCAT(
            status.Name
            , ' | '
            , CONCAT(
                    sammlung.Name
                    , ' - '
                    , musikstueck.Name
                    , ' - Satz Nr: '
                    , satz.Nr
                    )            
           ) as Name 
        FROM satz  
              inner join musikstueck on satz.MusikstueckID = musikstueck.ID
              inner JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
              inner join schueler_satz on schueler_satz.SatzID = satz.ID
              inner join status on status.ID=schueler_satz.StatusID
        WHERE 1=1 
        AND schueler_satz.SchuelerID = :SchuelerID  
        ORDER BY Name ";

    $stmt = $this->db->prepare($query);      
    
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT);

    // echo $query; // test 

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HTML_Select($stmt); 
      // $html->caption = $caption;  
      $html->autofocus=false;      
      $html->print_select("SatzID", $selected_SatzID, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table_uebungen(){

    $query="SELECT 
              uebung.ID
              , uebungtyp.Name as `Uebung Typ`     
              , uebung.Name as `Uebung Inhalt`
              , uebung.Datum
              , uebung.Anzahl
              , uebungtyp.Einheit
              , uebung.Bemerkung
              , CONCAT(
                    sammlung.Name, ' - ', 
                      -- musikstueck.Nummer, ' - ', 
                      musikstueck.Name, ' - Satz Nr. ',  
                      satz.Nr
                      ) Noten   
          FROM  uebung 
              left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
              left join satz  on satz.ID=uebung.SatzID 
              left join musikstueck on satz.MusikstueckID = musikstueck.ID
              left JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
          WHERE uebung.SchuelerID = :ID 
          ORDER BY uebung.Datum DESC              
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=true;      
      $html->edit_link_table='uebung'; 
      $html->edit_link_title='Übung'; 
      $html->edit_link_open_newpage=true; 
      $html->show_missing_data_message=false;      
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    

  function print_table_auswertung_uebungen($type=1){
    // XXXX 
    switch($type) {
      case 1: 
        $query="
            SELECT 
                -- uebung.ID
                uebungtyp.Name as Typ    
                -- , YEAR(uebung.Datum) as Jahr
                -- , MONTH(uebung.Datum) as Monat          
                , SUM(uebung.Anzahl) as Anzahl 
                , uebungtyp.Einheit            
                , MIN(uebung.Datum) as `Datum Start`
                , MAX(uebung.Datum) as `Datum Zuletzt`         
                , COUNT(DISTINCT uebung.Datum) as Tage     
                -- , uebung.SchuelerID
                -- , uebung.UebungtypID
            FROM  uebung 
                  left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
                  left join satz  on satz.ID=uebung.SatzID     
            WHERE uebung.SchuelerID = :ID 
            AND UebungtypID  is not null 
            GROUP by uebung.SchuelerID
              , uebung.UebungtypID
              , uebungtyp.Einheit
              -- , YEAR(uebung.Datum)
              -- , MONTH(uebung.Datum) 
            ORDER BY `Datum Zuletzt` DESC              
            "; 

      break; 

      case 2: 
      break; 
      
      case 3: 
      break; 
      
      case 4: 
      break; 

    
    }

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;      
      $html->edit_link_table='uebung'; 
      $html->edit_link_title='Übung'; 
      $html->edit_link_open_newpage=true; 
      $html->show_missing_data_message=false;      
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    


  function print_table_saetze_checklist($MaterialtypID='', $checkSchwierigkeitsgrad=false){
    $query="SELECT DISTINCT satz.ID
            , CONCAT(sammlung.Name, '; ', musikstueck.Nummer, ': ', COALESCE(musikstueck.Name, ''), '; ', satz.Nr, ': ', COALESCE(satz.Name, '')) as Name  
            FROM sammlung 
            INNER JOIN musikstueck on musikstueck.SammlungID = sammlung.ID 
            INNER JOIN satz on satz.MusikstueckID = musikstueck.ID  
            LEFT JOIN schueler_satz on satz.ID = schueler_satz.SatzID  
                        AND schueler_satz.SchuelerID = :SchuelerID 
            WHERE 1=1
            ".($MaterialtypID!=""?"AND musikstueck.MaterialtypID=:MaterialtypID ":"")." 
            AND schueler_satz.ID is null "; 

    if($checkSchwierigkeitsgrad) {
          
    $query.="
        AND satz.ID IN (
                  SELECT DISTINCT satz_schwierigkeitsgrad.SatzID 
                  FROM schueler_schwierigkeitsgrad 
                  INNER JOIN  satz_schwierigkeitsgrad 
                  ON schueler_schwierigkeitsgrad.InstrumentID  = satz_schwierigkeitsgrad.InstrumentID 
                  AND schueler_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID
                  WHERE schueler_schwierigkeitsgrad.SchuelerID = :SchuelerID
                )    
        "; 
    }
    $query.="ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr  "; 
    // echo '<pre>'.$query.'</pre>'; 
    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT); 
    if ($MaterialtypID!='') {
      $stmt->bindParam(':MaterialtypID', $MaterialtypID, PDO::PARAM_INT); 
    }

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); 
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=true; 
      $html->edit_link_table='satz'; 
      $html->print_table_checklist('satz'); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

}

 



?>
<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.satz.php");    

class Musikstueck {

  public $table_name='musikstueck'; 

  public $ID;
  public $Nummer;
  public $Name;
  public $SammlungID;
  public $KomponistID;
  public $MaterialtypID; 
  public $Opus;
  public $GattungID;
  public $Bearbeiter;
  public $EpocheID;
  public $Bemerkung; 
  
  public $Title='Musikstück';
  public $Titles='Musikstücke';  
  public $autoupdate = false;

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row($Nummer='', $Name='') { 

    $Nummer=($Nummer==''? $this->get_next_nummer():$Nummer);

    // $Name=($Name==''?'(Musikstück '.$Nummer.')':$Name); // falls Name leer ist,  wird "Musikstück <Nr>" gespeichert 
  
    $update = $this->db->prepare("INSERT INTO `musikstueck` SET
                          `Name`     = :Name,
                          `SammlungID`     = :SammlungID,  
                          `Nummer`     = :Nummer")
                          ;
  
    $update->bindValue(':SammlungID', $this->SammlungID);
    $update->bindValue(':Nummer', $Nummer);
    $update->bindValue(':Name', $Name);
  
    try {
      $update->execute(); 
      $this->ID = $this->db->lastInsertId();
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }  
    
  }

function move_order(int $offset=1 ) {

    $select = $this->db->prepare("SELECT `Nummer` FROM `musikstueck` WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();      
    $tmpNummer=$row_data["Nummer"];
    $tmpNummer=$tmpNummer + $offset; 

    $update = $this->db->prepare("UPDATE `musikstueck` 
                                  SET `Nummer` = :Nummer_Neu WHERE `ID` = :ID");           

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Nummer_Neu', $tmpNummer , PDO::PARAM_INT);

    try {
      $update->execute(); 
      // $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  
    }
  }


  function update_row(
            $Nummer 
            , $Name
            , $SammlungID
            , $KomponistID
            , $Opus
            , $GattungID
            , $Bearbeiter
            , $EpocheID
            , $Bemerkung
            , $MaterialtypID

         ) {
   
    // echo '<p>Nummer: '.$Nummer;   
    // echo '<br>Name: '.$Name;
    // echo '<br>SammlungID: '.$SammlungID;
    // echo '<br>KomponistID: '.$KomponistID;
    // echo '<br>Opus: '.$Opus;
    // echo '<br>Bearbeiter: '.$Bearbeiter;
    // echo '<br>GattungID: '.$GattungID;    
    // echo '<br>EpocheID: '.$EpocheID;    

    $update = $this->db->prepare("UPDATE `musikstueck` 
              SET
              `Nummer`     = :Nummer,             
              `Name`     = :Name,
              `SammlungID`     = :SammlungID,   
              `KomponistID`     = :KomponistID,                              
              `Opus`     = :Opus,   
              `GattungID`     = :GattungID,                               
              `Bearbeiter`     = :Bearbeiter,   
              `EpocheID`     = :EpocheID, 
              `MaterialtypID`     = :MaterialtypID,               
              `Bemerkung`     = :Bemerkung              
              WHERE `ID` = :ID");           

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Nummer', $Nummer );
    $update->bindParam(':Name', $Name);
    $update->bindParam(':SammlungID', $SammlungID);
    $update->bindParam(':KomponistID', $KomponistID, ($KomponistID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':MaterialtypID', $MaterialtypID, ($MaterialtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Opus', $Opus);
    $update->bindParam(':GattungID', $GattungID,($GattungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Bearbeiter', $Bearbeiter);
    $update->bindParam(':EpocheID', $EpocheID,($EpocheID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);    

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
      ,`Name`                       
      ,`Opus`
      ,`SammlungID`
      ,`Nummer`
      ,`KomponistID`
      ,`Bearbeiter`
      ,`EpocheID`
      ,`GattungID`
      ,`MaterialtypID`
      , COALESCE(Bemerkung,'') Bemerkung      
    FROM `musikstueck`
    WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Nummer=$row_data["Nummer"];
      $this->Name=$row_data["Name"];
      $this->Bemerkung=$row_data["Bemerkung"];
      $this->SammlungID=$row_data["SammlungID"];
      $this->KomponistID=$row_data["KomponistID"];
      $this->Opus=$row_data["Opus"];
      $this->GattungID=$row_data["GattungID"];
      $this->MaterialtypID=$row_data["MaterialtypID"];
      $this->Bearbeiter=$row_data["Bearbeiter"];
      $this->EpocheID=$row_data["EpocheID"];   
      return true;    
    } 
    else {
      return false; 
    }
  }

  function print_table_besetzungen($target_file){
    $query="SELECT b.ID
        , b.Name                              
    FROM `musikstueck` m 
    inner join musikstueck_besetzung mb 
      on m.ID=mb.MusikstueckID          
    inner join besetzung b
      on b.ID=mb.BesetzungID  
    WHERE mb.MusikstueckID = :MusikstueckID 
    ORDER by b.Name"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 

      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MusikstueckID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();       

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table_verwendungszwecke($target_file){
    $query="SELECT v.ID
        , v.Name                      
    FROM `musikstueck` m 
    inner join musikstueck_verwendungszweck mb 
      on m.ID=mb.MusikstueckID          
    inner join verwendungszweck v
      on v.ID=mb.VerwendungszweckID 
    WHERE mb.MusikstueckID = :MusikstueckID 
    ORDER by v.Name"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MusikstueckID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function add_besetzung ($BesetzungID){

      $update = $this->db->prepare("INSERT IGNORE INTO `musikstueck_besetzung` SET
                            `MusikstueckID`     = :MusikstueckID,
                            `BesetzungID`     = :BesetzungID");

      $update->bindValue(':MusikstueckID', $this->ID);
      $update->bindValue(':BesetzungID', $BesetzungID);

      try {
        $update->execute(); 
      }
      catch (PDOException $e) {
        include_once("class.htmlinfo.php"); 
        $info = new HTML_Info();      
        $info->print_user_error(); 
        $info->print_error($update, $e);  
      }  

  }

  function add_verwendungszweck ($VerwendungszweckID){

    $update = $this->db->prepare("INSERT IGNORE INTO `musikstueck_verwendungszweck` SET
                          `MusikstueckID`     = :MusikstueckID,
                          `VerwendungszweckID`     = :VerwendungszweckID");

    $update->bindValue(':MusikstueckID', $this->ID);
    $update->bindValue(':VerwendungszweckID', $VerwendungszweckID);

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);   
    }  

  }

  function print_select($value_selected='', $caption=''){
    /***** select box (fake) *****/ 

    $query="SELECT DISTINCT `ID` as MusikstueckID
            , `Name` FROM `musikstueck` 
            WHERE ID=:ID";


    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;       
      $html->print_select("MusikstueckID", $value_selected, false); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }


  function print_table_saetze(){

    $query="SELECT satz.ID
              , satz.Nr
              , satz.Name
              , satz.Tempobezeichnung `Tempo-Bez.`
              , concat(
                  satz.Spieldauer DIV 60
                  ,''''
                  , 
                  satz.Spieldauer MOD 60
                  , ''''''
                ) as Spieldauer                    
              , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`  
              , GROUP_CONCAT(DISTINCT  
                  CASE 
                    when satz_erprobt.Jahr is null 
                    then erprobt.Name 
                    else concat(satz_erprobt.Jahr, ': ', erprobt.Name)
                  end 
                  order by satz_erprobt.Jahr 
                  DESC SEPARATOR ', ') as Erprobt                
              , satz.Orchesterbesetzung
              , v_satz_lookuptypes.LookupList as Besonderheiten              
              , satz.Bemerkung               
            FROM satz 
              LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
              LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID
              left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
              LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
              LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
              left join v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
            WHERE satz.MusikstueckID = :MusikstueckID 
            GROUP by satz.ID 
            ORDER by Nr"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->edit_link_table='satz'; 
      $html->edit_link_title='Satz'; 
      $html->edit_link_open_newpage=true; 
      $html->print_table2();       
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }
  

  function get_next_nummer () {

    $sql="SELECT (coalesce(MAX(Nummer),0)) + 1 as next_nr from `musikstueck` 
             WHERE SammlungID=:SammlungID"; 
    $stmt = $this->db->prepare($sql); 
    $stmt->bindParam(':SammlungID', $this->SammlungID, PDO::PARAM_INT); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  
  
  function delete(){

    $this->delete_verwendungszwecke();   
    $this->delete_besetzungen();
    $this->delete_lookups();      
    $this->delete_saetze();      
 
    $delete = $this->db->prepare("DELETE FROM `musikstueck` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Das Musikstück wurde gelöscht.');            
      return true;          
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);
      return false;  
    }  
  }  

  function delete_verwendungszweck($ID){

    $delete = $this->db->prepare("DELETE 
                          FROM `musikstueck_verwendungszweck` 
                          WHERE MusikstueckID=:MusikstueckID
                          AND VerwendungszweckID=:VerwendungszweckID
                          "); 
    $delete->bindValue(':MusikstueckID', $this->ID);  
    $delete->bindValue(':VerwendungszweckID', $ID);      

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }  

  function delete_verwendungszwecke(){

    $delete = $this->db->prepare("DELETE 
                          FROM `musikstueck_verwendungszweck` 
                          WHERE MusikstueckID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }    

  function delete_besetzung($ID){

    $delete = $this->db->prepare("DELETE FROM `musikstueck_besetzung` 
                          WHERE MusikstueckID=:MusikstueckID
                          AND BesetzungID=:BesetzungID
                          "
                          ); 
    $delete->bindValue(':MusikstueckID', $this->ID);  
    $delete->bindValue(':BesetzungID', $ID);      

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_besetzungen(){

    $delete = $this->db->prepare("DELETE 
                           FROM `musikstueck_besetzung` 
                           WHERE MusikstueckID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_saetze(){

    $select = $this->db->prepare("SELECT ID  
                           FROM `satz` 
                           WHERE MusikstueckID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row=>$value) {
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->delete();  
    }
  }

  function delete_lookups(){

    $delete = $this->db->prepare("DELETE FROM musikstueck_lookup WHERE MusikstueckID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function copy($SammlungID_New=0){

    /*  SammlungID_New > 0 : Musikstück an neuer Sammlung (Sammlung wird auch kopiert)
        SammlungID_New= 0: Musikstück Kopie an gleicher Sammlung
     */

    $sql="INSERT INTO musikstueck (
            `Name`
            , Opus
            , SammlungID
            , Nummer
            , KomponistID
            , Bearbeiter
            , GattungID
            , EpocheID
            , MaterialtypID
            , Bemerkung
        )
        SELECT ".($SammlungID_New>0?"Name":"CONCAT(Name, ' (Kopie)') as Name")." 
            , Opus
            , ".($SammlungID_New>0?':SammlungID':'SammlungID')." as SammlungID
            , ".($SammlungID_New>0?'Nummer':':Nummer')." as Nummer    
            , KomponistID
            , Bearbeiter
            , GattungID
            , EpocheID
            , MaterialtypID
            , Bemerkung            
        FROM  musikstueck 
            where ID=:ID";

    // echo '<pre>'.$sql.'</pre>'; // test 
    
    $insert = $this->db->prepare($sql); 
    
    $insert->bindValue(':ID', $this->ID);  
    
    if ($SammlungID_New>0) {
      $insert->bindValue(':SammlungID', $SammlungID_New);  
    }
    if ($SammlungID_New==0) {
      // "Nummer" hochzählen 
      $this->load_row(); // Ziel: $this->SammlungID einlesen  
      $Nummer=$this->get_next_nummer();  
      // echo 'Nummer: '.$Nummer.'<br>';  // TEST 
      $insert->bindValue(':Nummer', $Nummer);  
    }
        
    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    
     
      $this->copy_saetze($ID_New); 
      $this->copy_verwendungszwecke($ID_New); 
      $this->copy_besetzungen($ID_New); 
      $this->copy_lookups($ID_New); 

      $this->ID = $ID_New; 
               
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }  

  function copy_saetze($ID_New) {
   
    $select = $this->db->prepare("SELECT ID  
                  FROM `satz` 
                  WHERE MusikstueckID=:ID"); 

    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    // echo '<p>Anzahl Sätze: '.count($res); // test 

    foreach ($res as $row=>$value) {
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->copy($ID_New);  
    }  
  }

  function copy_lookups($ID_new) {

    $sql="insert into musikstueck_lookup 
          (MusikstueckID, LookupID) 
    select :MusikstueckID as MusikstueckID
          , LookupID
    from musikstueck_lookup 
    where MusikstueckID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MusikstueckID', $ID_new);  
    $insert->execute();  

  }  
  
  function copy_besetzungen($ID_New) {

    $sql="insert into musikstueck_besetzung
          (MusikstueckID, BesetzungID) 
          select :MusikstueckID_New as MusikstueckID
              , BesetzungID 
          from musikstueck_besetzung 
          where MusikstueckID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MusikstueckID_New', $ID_New);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function copy_verwendungszwecke($ID_New) {

    $sql="insert into musikstueck_verwendungszweck
        (MusikstueckID, VerwendungszweckID) 
        select :MusikstueckID_New as MusikstueckID
            , VerwendungszweckID 
        from musikstueck_verwendungszweck 
        where MusikstueckID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MusikstueckID_New', $ID_New);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  


  }

  function add_schwierigkeitsgrad($InstrumentID, $SchwierigkeitsgradID){
    // dataclearing 

    $select = $this->db->prepare("SELECT ID  
                           FROM `satz` 
                           WHERE MusikstueckID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    // echo '<p>Anzahl Sätze: '.count($res); 

    foreach ($res as $row=>$value) {
      // echo '<p>Ergänze Schwierigkeitsgrad bei Satz ID: '.$value["ID"];
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->add_schwierigkeitsgrad($SchwierigkeitsgradID,$InstrumentID);
    }
  }
  
  function add_satz_lookup($LookupID){
        // dataclearing 

    $select = $this->db->prepare("SELECT ID  FROM `satz` WHERE MusikstueckID=:ID"); 
    
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row=>$value) {
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->add_lookup($LookupID);
    }
  }
    

  function update_komponist ($KomponistID){

    $update = $this->db->prepare("UPDATE musikstueck 
                            SET KomponistID = :KomponistID
                            WHERE ID = :ID");

    $update->bindValue(':ID', $this->ID);
    $update->bindValue(':KomponistID', $KomponistID);

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);   
    }  
  }

  function update_epoche ($EpocheID){

    $update = $this->db->prepare("UPDATE musikstueck 
                            SET EpocheID = :EpocheID
                            WHERE ID = :ID");

    $update->bindValue(':ID', $this->ID);
    $update->bindValue(':EpocheID', $EpocheID);

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);   
    }  
  }

  
  function update_bearbeiter ($Bearbeiter){

    $update = $this->db->prepare("UPDATE musikstueck 
                            SET Bearbeiter = :Bearbeiter
                            WHERE ID = :ID");

    $update->bindValue(':ID', $this->ID);
    $update->bindValue(':Bearbeiter', $Bearbeiter);

    try {
      $update->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);   
    }  
  }


  function add_erprobt($ErprobtID){

    $select = $this->db->prepare("SELECT ID  
                           FROM `satz` 
                           WHERE MusikstueckID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    // echo '<p>Anzahl Sätze: '.count($res); 

    foreach ($res as $row=>$value) {
      // echo '<p>Ergänze Erprobt bei Satz ID: '.$value["ID"];
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->add_erprobt2($ErprobtID);
    }
  }
  
  function print(){
    // echo '<p>musikstueck.print ID '.$this->ID.'</p>'; // test
    // XXXX Bemerkung, MaterialtypID 
    $query="
      SELECT musikstueck.ID as ID
            , CONCAT(musikstueck.Nummer
            , ' '      
            , musikstueck.Name
            , IF(komponist.ID IS NOT NULL, concat('Komponist: ', komponist.Name, '; '), '')
            , IF(v_musikstueck_besetzungen.MusikstueckID IS NOT NULL, Concat('Besetzung(en): ', v_musikstueck_besetzungen.Besetzungen, '; '), '') 
            , IF(v_musikstueck_verwendungszwecke.MusikstueckID IS NOT NULL, Concat('Verwendungszweck(e): ', v_musikstueck_verwendungszwecke.Verwendungszwecke), '') 
            ) 
              as RowDesc   
      FROM musikstueck  
          left join v_komponist as komponist 
            on komponist.ID = musikstueck.KomponistID 
          LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
          LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID              
          LEFT JOIN (
            select musikstueck_besetzung.MusikstueckID         
                , GROUP_CONCAT(DISTINCT besetzung.Name  order by besetzung.Name SEPARATOR ', ') Besetzungen       
            from musikstueck_besetzung 
                left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
            group by musikstueck_besetzung.MusikstueckID 
                    ) v_musikstueck_besetzungen 
                on v_musikstueck_besetzungen.MusikstueckID = musikstueck.ID  
          LEFT JOIN (
            select musikstueck_verwendungszweck.MusikstueckID         
              , GROUP_CONCAT(DISTINCT verwendungszweck.Name  order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke       
            from musikstueck_verwendungszweck 
              left join verwendungszweck  on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID  
            group by musikstueck_verwendungszweck.MusikstueckID 
                  ) v_musikstueck_verwendungszwecke 
              on v_musikstueck_verwendungszwecke.MusikstueckID = musikstueck.ID  
      WHERE musikstueck.ID = :ID   
      ORDER by musikstueck.Nummer
    
    "; 

    $select = $this->db->prepare($query); 

    $select->bindValue(':ID', $this->ID);  
      
    try {
      $select->execute(); 
      $result = $select->fetch(PDO::FETCH_ASSOC);
      $AnzahlSatze=$this->getCountSaetze(); 

      if ($AnzahlSatze == 0 OR $AnzahlSatze ==1 ) {
        // wenn nur 1 Satz, dann Satz = Fortsetzung von Musikstück (keine Unterordnung)
        echo '<p class="print-musikstueck">'.$result["RowDesc"]. PHP_EOL; 
        $this->print_saetze(1); 
        echo '</p>'; 
      } elseif ($AnzahlSatze > 0) {
        echo '<p class="print-musikstueck">'.$result["RowDesc"].'</p>'. PHP_EOL; 
        $this->print_saetze(2);                 
      }


    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }  


  function getCountSaetze() {

    $query="SELECT COUNT(*) Anz from satz WHERE MusikstueckID = :MusikstueckID"; 
  
    $select = $this->db->prepare($query); 

    $select->bindValue(':MusikstueckID', $this->ID);  

    $select->execute(); 

    $anzahl=$select->fetchColumn(); 

    return $anzahl;  
  }

  function print_saetze($mode){

    $query="SELECT ID FROM satz WHERE MusikstueckID = :MusikstueckID ORDER by Nr"; 

    $select = $this->db->prepare($query); 

    $select->bindValue(':MusikstueckID', $this->ID);  

    $select->execute(); 

    $result = $select->fetchAll(PDO::FETCH_ASSOC);

    // echo count($result); 

    foreach ($result as $row) {
      $satz = new Satz(); 
      $satz->ID = $row["ID"]; 
      $satz->print($mode); 
    }
  }

  function is_deletable() {
    return true; // aktuell keine Abängigkeiten berücksichtigt. 
   
  }  


  function add_lookup($LookupID){

    $insert = $this->db->prepare("INSERT INTO `musikstueck_lookup` SET
        `MusikstueckID`     = :MusikstueckID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':MusikstueckID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  } 

  function delete_lookup($LookupID){

    $delete = $this->db->prepare("DELETE FROM `musikstueck_lookup` 
                            WHERE MusikstueckID=:MusikstueckID 
                            AND LookupID=:LookupID"); 
    $delete->bindValue(':MusikstueckID', $this->ID);  
    $delete->bindValue(':LookupID', $LookupID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function print_table_lookups($target_file, $LookupTypeID=0){

    $query="SELECT lookup.ID
             , lookup_type.Name as Typ     
             , lookup.Name  
          FROM musikstueck_lookup          
          INNER JOIN lookup 
            on lookup.ID=musikstueck_lookup.LookupID
          INNER JOIN lookup_type
            on lookup_type.ID = lookup.LookupTypeID
          WHERE musikstueck_lookup.MusikstueckID = :MusikstueckID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 
  
    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MusikstueckID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  } 
  
  function print_table_saetze3($filename_order_link){
    /* einfache auflistung, für Reihenfolge-Verschiebungsaktionen */
    $query="SELECT ID, Nr, Name 
            FROM satz 
            WHERE MusikstueckID=:MusikstueckID 
            ORDER by Nr"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->edit_link_table='satz'; 
      $html->edit_link_title='Satz'; 
      $html->edit_link_open_newpage=true; 
      $html->add_links_order=true; 
      $html->add_link_edit=true; 
      $html->filename_order_link=$filename_order_link; 
      $html->links_order_params='&MusikstueckID='.$this->ID; 

      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  
 
}






?>
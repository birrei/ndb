<?php 
class Musikstueck {

  public $table_name; 

  public $ID;
  public $Nummer;
  public $Name;
  public $SammlungID;
  public $KomponistID;
  public $Opus;
  public $GattungID;
  public $Bearbeiter;
  public $EpocheID;
  
  public $Title='Musikstück';
  public $Titles='Musikstücke';  
  public $autoupdate = false;

  public function __construct(){
    $this->table_name='musikstueck';     
  }

  function insert_row($Nummer='', $Name='') { 
    include_once("dbconn/cl_db.php");

    $Nummer=($Nummer==''? $this->get_next_nummer():$Nummer);

    // $Name=($Name==''?'(Musikstück '.$Nummer.')':$Name); // falls Name leer ist,  wird "Musikstück <Nr>" gespeichert 
    
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $insert = $db->prepare("INSERT INTO `musikstueck` SET
                          `Name`     = :Name,
                          `SammlungID`     = :SammlungID,  
                          `Nummer`     = :Nummer")
                          ;
  
    $insert->bindValue(':SammlungID', $this->SammlungID);
    $insert->bindValue(':Nummer', $Nummer);
    $insert->bindValue(':Name', $Name);
  
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

    // aktuell verworfen 
    // if ($this->autoupdate) {
    //   $this->autoupdate_insert_besetzungen(); 
    //   $this->autoupdate_insert_verwendungszwecke();       
    // }
    
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
         ) {
   
    // echo '<p>Nummer: '.$Nummer;   
    // echo '<br>Name: '.$Name;
    // echo '<br>SammlungID: '.$SammlungID;
    // echo '<br>KomponistID: '.$KomponistID;
    // echo '<br>Opus: '.$Opus;
    // echo '<br>Bearbeiter: '.$Bearbeiter;
    // echo '<br>GattungID: '.$GattungID;    
    // echo '<br>EpocheID: '.$EpocheID;    


    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
            
    $update = $db->prepare("UPDATE `musikstueck` 
              SET
              `Nummer`     = :Nummer,             
              `Name`     = :Name,
              `SammlungID`     = :SammlungID,   
              `KomponistID`     = :KomponistID,                              
              `Opus`     = :Opus,   
              `GattungID`     = :GattungID,                               
              `Bearbeiter`     = :Bearbeiter,   
              `EpocheID`     = :EpocheID
              WHERE `ID` = :ID");           

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Nummer', $Nummer );
    $update->bindParam(':Name', $Name);
    $update->bindParam(':SammlungID', $SammlungID);
    $update->bindParam(':KomponistID', $KomponistID, ($KomponistID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Opus', $Opus);
    $update->bindParam(':GattungID', $GattungID,($GattungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Bearbeiter', $Bearbeiter);
    $update->bindParam(':EpocheID', $EpocheID,($EpocheID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

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
      ,`Name`                       
      ,`Opus`
      ,`SammlungID`
      ,`Nummer`
      ,`KomponistID`
      ,`Bearbeiter`
      ,`EpocheID`
      ,`GattungID`
    FROM `musikstueck`
    WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Nummer=$row_data["Nummer"];
      $this->Name=$row_data["Name"];
      $this->SammlungID=$row_data["SammlungID"];
      $this->KomponistID=$row_data["KomponistID"];
      $this->Opus=$row_data["Opus"];
      $this->GattungID=$row_data["GattungID"];
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

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 

      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MusikstueckID'; 
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

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MusikstueckID'; 
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

  function add_besetzung ($BesetzungID){
      include_once("dbconn/cl_db.php");
      $conn = new DbConn(); 
      $db=$conn->db; 

      $insert = $db->prepare("INSERT IGNORE INTO `musikstueck_besetzung` SET
                            `MusikstueckID`     = :MusikstueckID,
                            `BesetzungID`     = :BesetzungID");

      $insert->bindValue(':MusikstueckID', $this->ID);
      $insert->bindValue(':BesetzungID', $BesetzungID);

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

  function add_verwendungszweck ($VerwendungszweckID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT IGNORE INTO `musikstueck_verwendungszweck` SET
                          `MusikstueckID`     = :MusikstueckID,
                          `VerwendungszweckID`     = :VerwendungszweckID");

    $insert->bindValue(':MusikstueckID', $this->ID);
    $insert->bindValue(':VerwendungszweckID', $VerwendungszweckID);

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

  function print_select($value_selected='', $caption=''){
    /***** select box (fake) *****/ 
    include_once("dbconn/cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT DISTINCT `ID` as MusikstueckID
            , `Name` FROM `musikstueck` 
            WHERE ID=:ID";


  	$conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->caption = $caption;       
      $html->print_select("MusikstueckID", $value_selected, false); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  function print_table_saetze(){

    $query="SELECT satz.ID
              , satz.Nr
              , satz.Name
              , satz.Tonart
              , satz.Taktart
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
                
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->edit_link_table='satz'; 
      $html->edit_link_title='Satz'; 
      $html->edit_link_open_newpage=true; 
      $html->print_table2();       
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }
  

  function get_next_nummer () {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="SELECT (coalesce(MAX(Nummer),0)) + 1 as next_nr from `musikstueck` 
             WHERE SammlungID=:SammlungID"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindParam(':SammlungID', $this->SammlungID, PDO::PARAM_INT); 
    $stmt->execute(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  }  

  function delete_verwendungszweck($ID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
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
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }  

  function delete_verwendungszwecke(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
                          FROM `musikstueck_verwendungszweck` 
                          WHERE MusikstueckID=:ID"); 
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

  function delete_besetzung($ID){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `musikstueck_besetzung` 
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
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
    }  
  }

  function delete_besetzungen(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE 
                           FROM `musikstueck_besetzung` 
                           WHERE MusikstueckID=:ID"); 
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

  function delete_saetze(){
    // echo '<p> delete_saetze von Musikstueck ID: '.$this->ID; 
    
    include_once("dbconn/cl_db.php");
    include_once('cl_satz.php'); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
                           FROM `satz` 
                           WHERE MusikstueckID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    echo '<p>Anzahl Sätze: '.count($res); 

    foreach ($res as $row=>$value) {
      echo '<p>Lösche Satz ID: '.$value["ID"];
      $satz = new Satz(); 
      $satz->ID = $value["ID"]; 
      $satz->delete();  
    }
  }

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>lösche Musikstück ID:'.$this->ID.':</p>';
    $this->delete_verwendungszwecke();   
    $this->delete_besetzungen();
    $this->delete_saetze();      
 
    $delete = $db->prepare("DELETE FROM `musikstueck` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Das Musikstück wurde gelöscht.</p>';    
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

  function copy($include_verwendungszweck=false
                , $include_besetzung=false
                , $include_saetze=false
                , $include_satz_schwierigkeitgrad=false        
                , $include_satz_lookup=false                                                        
                ){
    include_once("dbconn/cl_db.php");
    include_once("cl_satz.php");    

    echo '<p>Starte Kopie Musikstück ID '.$this->ID.'</p>';      

    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="insert into musikstueck (
            Name
            , Opus
            , SammlungID
            , Nummer
            , KomponistID
            , Bearbeiter
            , GattungID
            , EpocheID
        )
        select Name
        , Opus
        , :SammlungID as SammlungID
        , Nummer
        , KomponistID
        , Bearbeiter
        , GattungID
        , EpocheID
        from musikstueck 
        where ID=:ID";
    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SammlungID', $this->SammlungID);  // entspr. Kontext: alte oder neue SammmlungID 
  
    try {
      $insert->execute(); 
      $ID_New = $db->lastInsertId();    


      if ($include_verwendungszweck) {
        // verwendungszwecke kopieren 
        $sql="insert into musikstueck_verwendungszweck
                  (MusikstueckID, VerwendungszweckID) 
            select :MusikstueckID_New as MusikstueckID
                  , VerwendungszweckID 
            from musikstueck_verwendungszweck 
            where MusikstueckID=:ID";

        $insert = $db->prepare($sql); 
        $insert->bindValue(':ID', $this->ID);  
        $insert->bindValue(':MusikstueckID_New', $ID_New);  
        $insert->execute(); 
        echo '<p>Verwendungszwecke wurden kopiert.</p>';         
      }

      // besetzungen kopieren 
      if ($include_besetzung) {
        $sql="insert into musikstueck_besetzung
                  (MusikstueckID, BesetzungID) 
            select :MusikstueckID_New as MusikstueckID
                  , BesetzungID 
            from musikstueck_besetzung 
            where MusikstueckID=:ID";

        $insert = $db->prepare($sql); 
        $insert->bindValue(':ID', $this->ID);  
        $insert->bindValue(':MusikstueckID_New', $ID_New); 
        $insert->execute(); 
        echo '<p>Besetzungen wurden kopiert.</p>';          
      }

      // saetze kopieren  
      if ($include_saetze) {
        
        $select = $db->prepare("SELECT ID  
                      FROM `satz` 
                      WHERE MusikstueckID=:ID"); 

        $select->bindValue(':ID', $this->ID);  

        $select->execute(); 

        $res = $select->fetchAll(PDO::FETCH_ASSOC);

        // echo '<p>Anzahl Sätze: '.count($res); 

        foreach ($res as $row=>$value) {
          $satz = new Satz(); 
          $satz->ID = $value["ID"]; 
          $satz->MusikstueckID = $ID_New; 
          $satz->copy($include_satz_schwierigkeitgrad, $include_satz_lookup);  
        }  
        echo '<p>Sätze wurden kopiert.</p>';        
      }
            
      echo '<p>Musikstück ID '.$this->ID.' wurde kopiert. Neue ID: '.$ID_New.'</p>';  
               
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }  

  function add_schwierigkeitsgrad($InstrumentID, $SchwierigkeitsgradID){
    
    include_once("dbconn/cl_db.php");
    include_once('cl_satz.php'); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
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
  
  // function autoupdate_insert_besetzungen() {
  //   include_once("dbconn/cl_db.php");   
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
    
  //   // automatische Zuordnung pro Standort 
  //   $sql="
  //     insert into musikstueck_besetzung (MusikstueckID, BesetzungID) 
  //     select musikstueck.ID, auto_update.upd_ID as BesetzungID 
  //     from auto_update 
  //         inner join sammlung on sammlung.StandortID = auto_update.ref_ID
  //         inner join musikstueck on musikstueck.SammlungID = sammlung.ID 
  //         left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
  //             and musikstueck_besetzung.BesetzungID = auto_update.upd_ID
  //     where auto_update.ref_colname='StandortID'
  //     and auto_update.upd_colname='BesetzungID'
  //     and musikstueck_besetzung.ID IS NULL
  //     and musikstueck.ID = :ID 
  //       ";

  //   $insert = $db->prepare($sql); 
  //   $insert->bindValue(':ID', $this->ID);  
  //   $insert->execute(); 

  // }

  // function autoupdate_insert_verwendungszwecke() {
  //   include_once("dbconn/cl_db.php");   
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
    
  //   // automatische Zuordnung pro Standort 
  //   $sql="
  //     insert into musikstueck_verwendungszweck (MusikstueckID, VerwendungszweckID) 
  //     select musikstueck.ID, auto_update.upd_ID as VerwendungszweckID 
  //     from auto_update 
  //         inner join sammlung on sammlung.StandortID = auto_update.ref_ID
  //         inner join musikstueck on musikstueck.SammlungID = sammlung.ID 
  //         left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
  //             and musikstueck_verwendungszweck.VerwendungszweckID = auto_update.upd_ID
  //     where auto_update.ref_colname='StandortID'
  //     and auto_update.upd_colname='VerwendungszweckID'
  //     and musikstueck_verwendungszweck.ID IS NULL
  //     and musikstueck.ID = :ID 
  //       ";

  //   $insert = $db->prepare($sql); 
  //   $insert->bindValue(':ID', $this->ID);  
  //   $insert->execute(); 

  // }

  
}





?>
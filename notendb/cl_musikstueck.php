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
  public $JahrAuffuehrung;
  
  public $Title='Musikstück';
  public $Titles='Musikstücke';  

  public function __construct(){
    $this->table_name='musikstueck';     

  }

  function insert_row($Nummer='', $Name='') { 
    include_once("cl_db.php");

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
            , $JahrAuffuehrung
         ) {
   
    // echo '<p>Nummer: '.$Nummer;   
    // echo '<br>Name: '.$Name;
    // echo '<br>SammlungID: '.$SammlungID;
    // echo '<br>KomponistID: '.$KomponistID;
    // echo '<br>Opus: '.$Opus;
    // echo '<br>Bearbeiter: '.$Bearbeiter;
    // echo '<br>GattungID: '.$GattungID;    
    // echo '<br>EpocheID: '.$EpocheID;    
    // echo '<br>JahrAuffuehrung: '.$JahrAuffuehrung;   
    

    include_once("cl_db.php");   
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
              `EpocheID`     = :EpocheID,   
              `JahrAuffuehrung` = :JahrAuffuehrung
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
    $update->bindParam(':JahrAuffuehrung', $JahrAuffuehrung);

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
    include_once("cl_db.php");   
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
      ,`JahrAuffuehrung`
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
      $this->JahrAuffuehrung=$row_data["JahrAuffuehrung"];    
      return true;    
    } 
    else {
      return false; 
    }
  }

  function print_table_besetzungen($target_file){
    $query="SELECT mb.ID
         -- , mb.BesetzungID
        , b.Name                              
    FROM `musikstueck` m 
    inner join musikstueck_besetzung mb 
      on m.ID=mb.MusikstueckID          
    inner join besetzung b
      on b.ID=mb.BesetzungID  
    WHERE mb.MusikstueckID = :MusikstueckID 
    ORDER by b.Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table_with_del_link($target_file, 'MusikstueckID', $this->ID); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table_verwendungszwecke($target_file){
    $query="SELECT mb.ID
       -- , b.ID as VerwID
        , b.Name                      
    FROM `musikstueck` m 
    inner join musikstueck_verwendungszweck mb 
      on m.ID=mb.MusikstueckID          
    inner join verwendungszweck b
      on b.ID=mb.VerwendungszweckID 
    WHERE mb.MusikstueckID = :MusikstueckID 
    ORDER by b.Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      // $html->print_table(); 
      $html->print_table_with_del_link($target_file, 'MusikstueckID', $this->ID); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function add_besetzung ($BesetzungID){
      include_once("cl_db.php");
      $conn = new DbConn(); 
      $db=$conn->db; 

      $insert = $db->prepare("INSERT INTO `musikstueck_besetzung` SET
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
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `musikstueck_verwendungszweck` SET
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

  function print_select($value_selected=''){
    /***** select box (fake) *****/ 
    include_once("cl_db.php");  
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
              , GROUP_CONCAT(DISTINCT concat(schwierigkeitsgrad.Name, ' - ', instrument.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`  
              , erprobt.Name as Erprobt              
              , satz.Lagen
              , satz.Orchesterbesetzung
              , v_satz_lookuptypes.LookupList as Besonderheiten              
              , satz.Bemerkung               
            FrOM satz 
              left JOIN erprobt on erprobt.ID = satz.ErprobtID
              left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
              LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
              LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
              left join v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 
            WHERE satz.MusikstueckID = :MusikstueckID 
            GROUP by satz.ID 
            ORDER by Nr"; 
                
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':MusikstueckID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      // $html->print_table('satz', true,'', 'Satz'); 
      $html->link_table='satz'; 
      $html->link_title='Satz'; 
      $html->open_newpage=true; 
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
    include_once("cl_db.php");
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
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `musikstueck_verwendungszweck` WHERE ID=:ID"); 
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

  function delete_verwendungszwecke(){
    include_once("cl_db.php");
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
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `musikstueck_besetzung` WHERE ID=:ID"); 
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

  function delete_besetzungen(){
    include_once("cl_db.php");
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
    
    include_once("cl_db.php");
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
    include_once("cl_db.php");
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
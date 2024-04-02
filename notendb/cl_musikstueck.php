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
  
  public function __construct(){
    $this->table_name='musikstueck';     

  }

  function print_table_from_sammlung($SammlungID){

    $query="SELECT m.ID, 
            m.Nummer, 
            m.Name, 
            CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist           
    from musikstueck m
    left join komponist k
      on m.KomponistID = k.ID  
    WHERE m.SammlungID = :SammlungID 
    ORDER by m.Nummer"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); // statement-Objekt 
    $stmt->bindParam(':SammlungID', $SammlungID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table($this->table_name, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function insert_row($Nummer, $Name) { 
    include_once("cl_db.php");
    if ($Nummer==1) {
      /* dann wurde evt. default-Wert des Formular übernommen. falls es bereits 
       vorher Nummer =1 gab, soll der Übergabewert korrigiert (hochgezählt) werden.  
      */
      $Nummer = $this->get_next_nummer(); 
    } 
    $Name=($Name==''?'(Musikstück '.$Nummer.')':$Name); // falls Name leer ist,  wird "Musikstück <Nr>" gespeichert 
    
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
      $this->Nummer=$Nummer; 
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
      $this->Nummer =$Nummer ;
      $this->Name=$Name;
      $this->SammlungID=$SammlungID;
      $this->KomponistID=$KomponistID;
      $this->Opus=$Opus;
      $this->GattungID=$GattungID;
      $this->Bearbeiter=$Bearbeiter;
      $this->EpocheID=$EpocheID;
      $this->JahrAuffuehrung=$JahrAuffuehrung;
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
    $row_data= $select->fetch();

    
    $this->Nummer=$row_data["Nummer"];
    $this->Name=$row_data["Name"];
    $this->SammlungID=$row_data["SammlungID"];
    $this->KomponistID=$row_data["KomponistID"];
    $this->Opus=$row_data["Opus"];
    $this->GattungID=$row_data["GattungID"];
    $this->Bearbeiter=$row_data["Bearbeiter"];
    $this->EpocheID=$row_data["EpocheID"];
    $this->JahrAuffuehrung=$row_data["JahrAuffuehrung"];    

  }

  function print_table_besetzungen(){
    $query="SELECT b.ID
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
      $html->print_table(); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table_verwendungszwecke(){
    $query="SELECT b.ID
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
      $html->print_table(); 
      
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
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  function print_table_saetze(){

    $query="SELECT ID, 
              Nr, 
              Name,  
              Tonart,
              Taktart,
              Tempobezeichnung,
              Spieldauer,
              Schwierigkeitsgrad         
            from satz   
            WHERE MusikstueckID = :MusikstueckID 
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
      $html->print_table('satz', true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }
  

  function get_next_nummer () {
    $nummer = 1; 
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
}



?>
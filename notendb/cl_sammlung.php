<?php 
 
class Sammlung {

  public $table_name; 

  
  public $ID;
  public $Name;
  public $VerlagID;
  public $Bestellnummer; 
  // public $Standort; 
  public $StandortID; 
  public $Bemerkung;

  public function __construct(){
    $this->table_name='sammlung'; 
  }


/***** Neue Zeile einfügen ***************/   
  function insert_row($Name) {         
    include_once("cl_db.php");

    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `sammlung` SET
                          `Name`     = :Name");

    $insert->bindValue(':Name', $Name);
    // $insert->bindValue(':VerlagID', $VerlagID);

    try {
      $insert->execute(); 
      $this->ID = $db->lastInsertId();
      $this->Name=$Name; 
      // $this->VerlagID=$VerlagID;  

    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }

  function print_table(){

    $query="SELECT s.ID, s.Name, v.Name as Verlag   
    from sammlung s
    left join verlag v
      on v.ID = s.VerlagID  
    ORDER by s.Name"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $select = $db->prepare($query); 
      
    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->print_table($this->table_name, false); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row(
          $Name
          , $VerlagID
          , $StandortID
          , $Bestellnummer
          , $Bemerkung
         ) 
    {

      include_once("cl_db.php");   
      $conn = new DbConn(); 
      $db=$conn->db; 
          
      $update = $db->prepare("UPDATE `sammlung` 
            SET
            `Name`     = :Name,
            `VerlagID`     = :VerlagID,   
            `StandortID`     = :StandortID,                              
            `Bestellnummer`     = :Bestellnummer,   
            `Bemerkung`     = :Bemerkung                               
            WHERE `ID` = :ID");           

      $update->bindParam(':ID', $this->ID);
      $update->bindParam(':Name', $Name);
      $update->bindParam(':VerlagID', $VerlagID,($VerlagID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
      $update->bindParam(':StandortID', $StandortID,($StandortID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));      
      $update->bindParam(':Bestellnummer', $Bestellnummer);
      $update->bindParam(':Bemerkung', $Bemerkung);



      try {
        $update->execute(); 
        $this->Name=$Name;
        $this->VerlagID=$VerlagID;
        $this->StandortID=$StandortID;
        $this->Bestellnummer=$Bestellnummer;
        $this->Bemerkung=$Bemerkung;
      }
      catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($update, $e); 
      }
  }

  function print_select($value_selected=''){
    /***** select box (fake) *****/ 
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


  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT 
                          ID, 
                          Name, 
                          VerlagID, 
                          Bestellnummer , 
                          StandortID, 
                          COALESCE(Bemerkung, '') as Bemerkung
                        FROM `sammlung`
                        WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data= $select->fetch();

    $this->Name=$row_data["Name"];
    $this->VerlagID=$row_data["VerlagID"];
    $this->Bestellnummer=$row_data["Bestellnummer"];
    $this->StandortID=$row_data["StandortID"];
    $this->Bemerkung=$row_data["Bemerkung"];      
  }

  function print_table_musikstuecke(){

    $query="SELECT musikstueck.ID 
            , musikstueck.Nummer 
            , musikstueck.Name
            , musikstueck.Bearbeiter
            , musikstueck.Opus
            , komponist.Name Komponist
            , gattung.Name as Gattung
            , epoche.Name as Epoche
            , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke                                         
            , GROUP_CONCAT(DISTINCT satz.Name order by satz.Nr SEPARATOR ', ') Sätze                                         
    from musikstueck 
    left join v_komponist komponist on musikstueck.KomponistID = komponist.ID
    left join gattung on gattung.ID = musikstueck.GattungID   
    left join epoche on epoche.ID = musikstueck.EpocheID
    left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID = musikstueck.ID 
    left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
    left join musikstueck_verwendungszweck on musikstueck_verwendungszweck.MusikstueckID = musikstueck.ID 
    left join verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID
    left join satz on satz.MusikstueckID = musikstueck.ID 
    WHERE musikstueck.SammlungID = :SammlungID 
    GROUP BY musikstueck.ID 
    ORDER by musikstueck.Nummer"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SammlungID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table('musikstueck', true); 
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
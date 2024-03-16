<?php 
 
class Komponist {

  public $table_name; 

  public $ID;
  public $Vorname;
  public $Nachname;
  public $Geburtsjahr;
  public $Sterbejahr;
  public $Bemerkung;

  public function __construct(){
    $this->table_name='komponist'; 
  }

  function insert_row (
              $Vorname
              , $Nachname
              , $Geburtsjahr
              , $Sterbejahr
              , $Bemerkung
              ) {
    /***** Zeile einfügen ***************/                 
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `komponist` SET
                          `Vorname`     = :Vorname,
                          `Nachname`     = :Nachname,
                          `Geburtsjahr`     = :Geburtsjahr,
                          `Sterbejahr`     = :Sterbejahr,     
                          `Bemerkung`     = :Bemerkung"
    );

    $insert->bindParam(':Vorname', $Vorname);
    $insert->bindParam(':Nachname', $Nachname);
    $insert->bindParam(':Geburtsjahr', $Geburtsjahr);
    $insert->bindParam(':Sterbejahr', $Sterbejahr);
    $insert->bindParam(':Bemerkung', $Bemerkung);
    

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->Vorname=$Vorname;
      $this->Nachname=$Nachname;
      $this->Geburtsjahr=$Geburtsjahr;
      $this->Sterbejahr=$Sterbejahr;
      $this->Bemerkung=$Bemerkung;
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }

  function load_row($ID) {
    /****** Paramter aus gegebener ID auslesen */     
    $this->ID=$ID;   
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT `ID`
      , `Vorname`
      , `Nachname`
      , `Geburtsjahr`
      , `Sterbejahr`
      , `Bemerkung` 
    FROM `komponist`
    WHERE `ID` = :ID");
    $select->bindParam(':ID', $ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();

    $this->Vorname=$row_data["Vorname"];
    $this->Nachname=$row_data["Nachname"];
    $this->Geburtsjahr=$row_data["Geburtsjahr"];
    $this->Sterbejahr=$row_data["Sterbejahr"];
    $this->Bemerkung=$row_data["Bemerkung"];
    
    
  }  

  function update_row(
      /***** Zeile speichern / updaten ***************/   
     $ID
    , $Vorname
    , $Nachname
    , $Geburtsjahr
    , $Sterbejahr
    , $Bemerkung    
      ) 
    {

    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `komponist` 
                          SET
                          `Vorname`     = :Vorname,
                          `Nachname`     = :Nachname,
                          `Geburtsjahr`     = :Geburtsjahr,
                          `Sterbejahr`     = :Sterbejahr,
                          `Bemerkung` = :Bemerkung
                          WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $ID);
    $update->bindParam(':Vorname', $Vorname);
    $update->bindParam(':Nachname', $Nachname);
    $update->bindParam(':Geburtsjahr', $Geburtsjahr);
    $update->bindParam(':Sterbejahr', $Sterbejahr);
    $update->bindParam(':Bemerkung', $Bemerkung);


    try {
      $update->execute(); 
      $this->ID=$ID;
      $this->Vorname=$Vorname;
      $this->Nachname=$Nachname;
      $this->Geburtsjahr=$Geburtsjahr;
      $this->Sterbejahr=$Sterbejahr;
      $this->Bemerkung=$Bemerkung;

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
      }
  }

  function print_select($value_selected=''){
    /* Auswahl-Element Komponisten */   
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    /* view v_select_komponist verwendet */
    $query="SELECT DISTINCT 
            `ID` as KomponistID
            , Name 
            FROM `v_select_komponist` 
            order by `Nachname`"; 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      $html = new HtmlSelect($select); 
      $html->print_select("KomponistID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function print_table(){
    /***** HTML-Tabelle ausgeben  ***************/ 
    $query="SELECT * from komponist ORDER by ID DESC"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare($query); 

    try {
      $select->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($select); 
      $html->print_table($this->table_name, true); 
      
    }
    catch (PDOException $e) {
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

 
}

?>

<?php 

class Abfrage {

  public $table_name; 
  public $ID;
  public $Name;
  public $Beschreibung;
  public $Abfrage;
  public $Tabelle;

  /*
  CREATE TABLE IF NOT EXISTS `abfrage`   
(`ID` int not null AUTO_INCREMENT 
, Beschreibung VARCHAR(100) NOT NULL 
, Abfrage VARCHAR(1000) NOT NULL 
, Tabelle VARCHAR(100) NOT NULL -- Tabelle, die ueber Bearbeiten-Link geöffnet werden soll 
, PRIMARY KEY (`ID`)
)
;
  */

  public function __construct(){
    $this->table_name='abfrage'; 
  }

  function insert_row ($Name) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `abfrage` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_table(){

    $query="SELECT * from abfrage ORDER by Name"; 

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
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name,$Beschreibung, $Abfrage, $Tabelle ) {

    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 
    
    $update = $db->prepare("UPDATE `abfrage` 
                            SET
                            `Name`     = :Name
                            , Beschreibung = :Beschreibung
                            , Abfrage=:Abfrage
                            , Tabelle = :Tabelle
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Beschreibung', $Beschreibung);
    $update->bindParam(':Abfrage', $Abfrage);    
    $update->bindParam(':Tabelle', $Tabelle);    

    try {
      $update->execute(); 
      $this->load_row(); 
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

    $select = $db->prepare("SELECT ID
                                , COALESCE(Name,'') Name    
                                , COALESCE(Beschreibung,'') Beschreibung
                                , COALESCE(Abfrage,'') Abfrage
                                , COALESCE(Tabelle,'') Tabelle
                          FROM `abfrage`
                          WHERE `ID` = :ID");
 
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->Name=$row_data["Name"];    
    $this->Beschreibung=$row_data["Beschreibung"];
    $this->Abfrage=$row_data["Abfrage"];
    $this->Tabelle=$row_data["Tabelle"];        
  }  



  // function print_select($value_selected='',$referenced_MusikstueckID='') {
      
  //   include_once("cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query='SELECT ID, Name 
  //           FROM `abfrage` ';

  //   if ($referenced_MusikstueckID!=''){
  //     $query.='WHERE ID NOT IN 
  //             (SELECT AbfrageID FROM musikstueck_abfrage 
  //             WHERE MusikstueckID=:MusikstueckID) ';
  //   }

  //   $query.='ORDER BY `Name`'; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query);
    
  //   if ($referenced_MusikstueckID!=''){
  //     $stmt->bindParam(':MusikstueckID', $referenced_MusikstueckID);
  //   }

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->print_select("AbfrageID", $value_selected, true); 
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }

  // function print_select_multi($options_selected=[]){

  //   include_once("cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query="SELECT ID, Name 
  //           FROM `abfrage` 
  //           order by `Name`"; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query); 

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->print_select_multi('Abfrage', 'Abfrageen[]', $options_selected, 'Abfrage(en):'); 
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }



}

 



?>
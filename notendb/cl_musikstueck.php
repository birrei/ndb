<?php 
class Musikstueck {

  public $table_name; 

  public $ID;
  public $Nummer;
  public $Name;
  public $SammlungID;
  public $KomponistID;
  public $Opus;
  public $Gattung;
  public $Bearbeiter;
  public $Epoche;
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

  function insert_row($insert_SammlungID
                    , $insert_Nummer
                    , $insert_Name
                      ) 
                      {         
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $insert = $db->prepare("INSERT INTO `musikstueck` SET
                          `Name`     = :Name,
                          `SammlungID`     = :SammlungID,  
                          `Nummer`     = :Nummer");
  
    $insert->bindValue(':SammlungID', $insert_SammlungID);
    $insert->bindValue(':Nummer', $insert_Nummer);
    $insert->bindValue(':Name', $insert_Name);
  
    try {
      $insert->execute(); 
      $this->ID = $db->lastInsertId();
      $this->Nummer=$insert_Nummer; 
      $this->Name=$insert_Name;  
      $this->SammlungID=$insert_SammlungID;  
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
            , $Gattung
            , $Bearbeiter
            , $Epoche
            , $JahrAuffuehrung
         ) {
   
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
              `Gattung`     = :Gattung,                               
              `Bearbeiter`     = :Bearbeiter,   
              `Epoche`     = :Epoche,   
              `JahrAuffuehrung` = :JahrAuffuehrung
              WHERE `ID` = :ID");           

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Nummer', $Nummer );
    $update->bindParam(':Name', $Name);
    $update->bindParam(':SammlungID', $SammlungID);
    $update->bindParam(':KomponistID', $KomponistID);
    $update->bindParam(':Opus', $Opus);
    $update->bindParam(':Gattung', $Gattung);
    $update->bindParam(':Bearbeiter', $Bearbeiter);
    $update->bindParam(':Epoche', $Epoche);
    $update->bindParam(':JahrAuffuehrung', $JahrAuffuehrung);

    try {
      $update->execute(); 
      $this->Nummer =$Nummer ;
      $this->Name=$Name;
      $this->SammlungID=$SammlungID;
      $this->KomponistID=$KomponistID;
      $this->Opus=$Opus;
      $this->Gattung=$Gattung;
      $this->Bearbeiter=$Bearbeiter;
      $this->Epoche=$Epoche;
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
      ,`Epoche`
      ,`Gattung`
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
    $this->Gattung=$row_data["Gattung"];
    $this->Bearbeiter=$row_data["Bearbeiter"];
    $this->Epoche=$row_data["Epoche"];
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

  
}

 



?>
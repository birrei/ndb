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
      include_once("ctl_html_info.php"); 
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
            $ID
            , $Nummer 
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

    $update->bindParam(':ID', $ID);
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
      $this->ID=$ID;
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
      $info->print_error($stmt, $e); 
    }
  }


  function load_row($ID) {
    $this->ID=$ID;   
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

    $select->bindParam(':ID', $ID, PDO::PARAM_INT);
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

}

 



?>
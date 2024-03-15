<?php 
// include("dbconnect_pdo.php");
include_once("snippets.php");
 

class Musikstueck {

  public $table_name; 
  public $dbconnect;  

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
  
  public $UserErrorInfo; 
  public $ErrorInfo; 
  public $UserInfo; 


  public function __construct(){
    // include("dbconnect_pdo.php");
    $this->table_name='musikstueck';     

  }

  function insert_row($insert_SammlungID
                    , $insert_Nummer
                    , $insert_Name
                      ) 
                      {         
    include_once("dbconnect_pdo.php");

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
      echo get_html_user_action_info($this->table_name, 'insert', 1,$this->ID, true);  

    }
    catch (PDOException $e) {
      $this->UserErrorInfo  = get_html_user_error_info(); 
      $this->ErrorInfo =  get_html_error_info($insert, $e); 
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

    include_once("dbconnect_pdo.php");                 

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
    $update->bindParam(':Nummer ', $Nummer );
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
      // $count_affected_rows= $update->rowCount(); 
      // echo get_html_user_action_info($table, 'update', $count_affected_rows,$ID);  
      // echo get_html_editlink($table,$ID);

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
                  
      echo get_html_user_action_info($this->table_name, 'update', 1,$this->ID, true);  

    }
    catch (PDOException $e) {
      echo get_html_user_error_info(); 
      echo get_html_error_info($update, $e); 
    }
  }

  function load_row($ID) {
    // echo 'TEST'; 
    $this->ID=$ID;       
    include_once("dbconnect_pdo.php");   
    $this->dbconnect = $db; 

   // echo $db->getAttribute(constant("PDO::ATTR_CLIENT_VERSION")) . "\n";

    $select = $this->dbconnect->prepare("SELECT 
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

    // $select = $db->prepare("SELECT 
    //   `ID`
    //   ,`Name`                       
    //   ,`Opus`
    //   ,`SammlungID`
    //   ,`Nummer`
    //   ,`KomponistID`
    //   ,`Bearbeiter`
    //   ,`Epoche`
    //   ,`Gattung`
    //   ,`JahrAuffuehrung`
    // FROM `musikstueck`
    // WHERE `ID` = :ID");

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
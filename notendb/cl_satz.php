<?php 
class Satz {

  public $table_name; 

  public $ID;
  public $Name;
  public $Nr;
  public $MusikstueckID;
  public $Tonart;
  public $Taktart;
  public $Tempobezeichnung;
  public $Spieldauer;
  public $Schwierigkeitsgrad;
  public $Lagen;
  // public $Stricharten;
  public $Notenwerte;
  public $Erprobt;
  public $Bemerkung;
  
  public function __construct(){
    $this->table_name='satz';     

  }

  function print_table_from_musikstueck(){

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
    $stmt->bindParam(':MusikstueckID', $this->MusikstueckID, PDO::PARAM_INT); 
      
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

  function insert_row($Nr, $Name){         
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $insert = $db->prepare("INSERT INTO `satz` SET
                          `Nr`     = :Nr,
                          `Name`     = :Name,  
                          `MusikstueckID`     = :MusikstueckID");
  
    $insert->bindValue(':Nr', $Nr);
    $insert->bindValue(':Name', $Name);
    $insert->bindValue(':MusikstueckID', $this->MusikstueckID);
  
    try {
      $insert->execute(); 
      $this->ID = $db->lastInsertId();
      $this->Nr=$Nr; 
      $this->Name=$Name;  

      // $this->MusikstueckID=$MusikstueckID;  
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e);  
    }  
  }

  function update_row(
            $Name
            , $Nr
            , $MusikstueckID
            , $Tonart
            , $Taktart
            , $Tempobezeichnung
            , $Spieldauer
            , $Schwierigkeitsgrad
            , $Lagen
            // , $Stricharten
            , $Notenwerte
            , $Erprobt
            , $Bemerkung
    
         ) {

    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $update = $db->prepare("UPDATE `satz` 
                          SET
                          Name=:Name, 
                          Nr=:Nr, 
                          MusikstueckID=:MusikstueckID, 
                          Tonart=:Tonart, 
                          Taktart=:Taktart, 
                          Tempobezeichnung=:Tempobezeichnung, 
                          Spieldauer=:Spieldauer, 
                          Schwierigkeitsgrad=:Schwierigkeitsgrad, 
                          Lagen=:Lagen, 
                          Notenwerte=:Notenwerte, 
                          Erprobt=:Erprobt, 
                          Bemerkung=:Bemerkung
                          WHERE `ID` = :ID"); 
  
    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Nr', $Nr);
    $update->bindParam(':MusikstueckID', $MusikstueckID);
    $update->bindParam(':Tonart', $Tonart);
    $update->bindParam(':Taktart', $Taktart);
    $update->bindParam(':Tempobezeichnung', $Tempobezeichnung);
    $update->bindParam(':Spieldauer', $Spieldauer);
    $update->bindParam(':Schwierigkeitsgrad', $Schwierigkeitsgrad);
    $update->bindParam(':Lagen', $Lagen);
    // $update->bindParam(':Stricharten', $Stricharten);
    $update->bindParam(':Notenwerte', $Notenwerte);
    $update->bindParam(':Erprobt', $Erprobt);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->Name=$Name;
      $this->Nr=$Nr;
      $this->MusikstueckID=$MusikstueckID;
      $this->Tonart=$Tonart;
      $this->Taktart=$Taktart;
      $this->Tempobezeichnung=$Tempobezeichnung;
      $this->Spieldauer=$Spieldauer;
      $this->Schwierigkeitsgrad=$Schwierigkeitsgrad;
      $this->Lagen=$Lagen;
//      $this->Stricharten=$Stricharten;
      $this->Notenwerte=$Notenwerte;
      $this->Erprobt=$Erprobt;
      $this->Bemerkung=$Bemerkung;

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
                      ,`Nr`
                      ,`MusikstueckID`
                      ,`Tonart`
                      ,`Taktart`
                      ,`Tempobezeichnung`
                      ,`Spieldauer`
                      ,`Schwierigkeitsgrad`
                      ,`Lagen`
                      ,`Notenwerte`
                      ,`Erprobt`
                      ,`Bemerkung`
    FROM `satz`
    WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data= $select->fetch();


    $this->Name=$row_data["Name"];
    $this->Nr=$row_data["Nr"];
    $this->MusikstueckID=$row_data["MusikstueckID"];
    $this->Tonart=$row_data["Tonart"];
    $this->Taktart=$row_data["Taktart"];
    $this->Tempobezeichnung=$row_data["Tempobezeichnung"];
    $this->Spieldauer=$row_data["Spieldauer"];
    $this->Schwierigkeitsgrad=$row_data["Schwierigkeitsgrad"];
    $this->Lagen=$row_data["Lagen"];
    $this->Notenwerte=$row_data["Notenwerte"];
    $this->Erprobt=$row_data["Erprobt"];
    $this->Bemerkung=$row_data["Bemerkung"];
    

  }

  function print_table_sticharten(){

    $query="SELECT sa.ID
          , sa.Name                              
          FROM satz_strichart ssa         
          inner join strichart sa
            on ssa.StrichartID=sa.ID   
          WHERE ssa.SatzID = :SatzID 
          ORDER by ssa.ID DESC"; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SatzID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      // $html->print_table($this->table_name, true); 
      $html->print_table(); 
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function add_strichart ($StrichartID){
      include_once("cl_db.php");
      $conn = new DbConn(); 
      $db=$conn->db; 

      $insert = $db->prepare("INSERT INTO `satz_strichart` SET
          `SatzID`     = :SatzID,  
          `StrichartID`     = :StrichartID");

      $insert->bindValue(':SatzID', $this->ID);  
      $insert->bindValue(':StrichartID', $StrichartID);  

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
      include_once("ctl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }


  
}

 



?>
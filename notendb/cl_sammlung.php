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

  public $Title='Sammlung';
  public $Titles='Sammlungen';  

  public $mode=1; // bezug dml:  1: nur Sammlung, 2: inkl. Musikstücke +  Sätze

  public function __construct(){
    $this->table_name='sammlung'; 
  }

  function insert_row($Name) {         
    include_once("cl_db.php");

    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `sammlung` SET
                          `Name`     = :Name");

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
      $html->edit_link_table= $this->table_name;
      $html->print_table2(); 
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
         //  , $Bestellnummer
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
            `Bemerkung`     = :Bemerkung                               
            WHERE `ID` = :ID");           

      $update->bindParam(':ID', $this->ID);
      $update->bindParam(':Name', $Name);
      $update->bindParam(':VerlagID', $VerlagID,($VerlagID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
      $update->bindParam(':StandortID', $StandortID,($StandortID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));      
      // $update->bindParam(':Bestellnummer', $Bestellnummer);
      $update->bindParam(':Bemerkung', $Bemerkung);



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

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];
      $this->VerlagID=$row_data["VerlagID"];
      $this->Bestellnummer=$row_data["Bestellnummer"];
      $this->StandortID=$row_data["StandortID"];
      $this->Bemerkung=$row_data["Bemerkung"];    
      return true; 
    } 
    else {
      return false; 
    }
  
  } 

  function print_table_musikstuecke2(){

    $query="SELECT musikstueck.ID 
            , musikstueck.Nummer 
            , musikstueck.Name
            , komponist.Name Komponist            
            , musikstueck.Bearbeiter
            , musikstueck.Opus
            , gattung.Name as Gattung
            , epoche.Name as Epoche
            , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke                                         
            , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Saetze                                         
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
      $html->edit_link_table='musikstueck'; 
      $html->edit_link_title='Musikstück'; 
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

  function print_table_links(){

    $query="select link.ID
          , linktype.Name as Link_Typ
          , link.Bezeichnung
          , link.URL
        from link left join linktype 
          on link.LinktypeID = linktype.ID 
          where link.SammlungID= :ID
      "; 
                      
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 
      
    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      // $html->add_link_delete=true; 
      // $html->edit_link_table='link'; 
      $html->edit_link_filename='edit_sammlung_link.php'; 
      $html->edit_link_title='Link'; 
      $html->edit_link_open_newpage=false; 
      $html->print_table2(); 

      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }
  
  function delete_musikstuecke(){
    include_once("cl_db.php");
    include_once('cl_musikstueck.php'); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
                           FROM `musikstueck` 
                           WHERE SammlungID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    echo '<p>Anzahl Musikstücke: '.count($res); 

    foreach ($res as $row=>$value) {
      echo '<p>Lösche  Musikstück ID: '.$value["ID"];
      $musikstueck = new Musikstueck(); 
      $musikstueck->ID = $value["ID"]; 
      $musikstueck->delete();  
    }
  }

  function delete_links(){
    include_once("cl_db.php");
    include_once('cl_link.php'); 

    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
                           FROM `link` 
                           WHERE SammlungID=:ID"); 
    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    echo '<p>Anzahl Links: '.count($res); 

    foreach ($res as $row=>$value) {
      $link = new Link(); 
      $link->ID = $value["ID"]; 
      $link->delete();  
    }
  }

  function delete(){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    echo '<p>Lösche Sammlung ID:'.$this->ID.':</p>';

    $this->delete_links();
    $this->delete_musikstuecke();  
    $this->delete_lookups();          
 
    $delete = $db->prepare("DELETE FROM `sammlung` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      echo '<p>Die Sammlung wurde gelöscht. </p>'; 
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


  function print_table_lookups($target_file, $LookupTypeID=0){

    $query="SELECT lookup.ID
             , lookup_type.Name as Typ     
             , lookup.Name  
          FROM sammlung_lookup          
          INNER JOIN lookup 
            on lookup.ID=sammlung_lookup.LookupID
          INNER JOIN lookup_type
            on lookup_type.ID = lookup.LookupTypeID
            and lookup_type.Relation='sammlung' 
          WHERE sammlung_lookup.SammlungID = :SammlungID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':SammlungID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SammlungID'; 
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
    
  function add_lookup($LookupID){

    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `sammlung_lookup` SET
        `SammlungID`     = :SammlungID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':SammlungID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

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
  
  function delete_lookup($ID){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `sammlung_lookup` 
                            WHERE SammlungID=:SammlungID 
                            AND LookupID=:LookupID"); 
    $delete->bindValue(':SammlungID', $this->ID);  
    $delete->bindValue(':LookupID', $ID);  

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


  function copy(
        $include_musikstuecke=false
        , $include_verwendungszwecke=false
        , $include_besetzung=false
        , $include_saetze=false  
        , $include_satz_schwierigkeitgrad=false        
        , $include_satz_lookup=false                        
        , 
      ){

    include_once("cl_db.php");
    include_once('cl_musikstueck.php'); 

    
    echo '<p>Starte Kopie Sammlung ID '.$this->ID.'</p>';      

    $conn = new DbConn(); 
    $db=$conn->db; 

    $sql="
      INSERT INTO sammlung (Name, VerlagID, StandortID, Bemerkung)
      SELECT CONCAT(Name, ' (Kopie)') as Name , VerlagID, StandortID, Bemerkung
      from sammlung 
      where ID=:ID 
    ";
    $insert = $db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $db->lastInsertId();    
  
      echo '<p>Sammlung Kopie ID: '.$ID_New.'</p>';        
      
      if ($include_musikstuecke) {
        // musikstücke kopieren 
        $select = $db->prepare("SELECT ID  
        FROM `musikstueck` 
        WHERE SammlungID=:ID"); 

        $select->bindValue(':ID', $this->ID);  

        $select->execute(); 

        $res = $select->fetchAll(PDO::FETCH_ASSOC);

        // echo '<p>Anzahl Musikstücke: '.count($res); 

        foreach ($res as $row=>$value) {
          $musikstueck = new Musikstueck(); 
          $musikstueck->ID = $value["ID"]; 
          $musikstueck->SammlungID = $ID_New; 
          $musikstueck->copy(
             $include_verwendungszwecke
            , $include_besetzung
            , $include_saetze  
            , $include_satz_schwierigkeitgrad        
            , $include_satz_lookup  
          );  
        }
        echo '<p>Musikstücke wurden kopiert.</p>';              
      }
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  }  

  function add_besetzung($BesetzungID){
    // dataclearing: Besetzung bei allen Musikstücken ergänzen  
   include_once("cl_db.php");
   include_once("cl_musikstueck.php");    
   $conn = new DbConn(); 
   $db=$conn->db; 

   $select = $db->prepare("SELECT ID  
   FROM `musikstueck` 
   WHERE SammlungID=:ID"); 

   $select->bindValue(':ID', $this->ID);  

   $select->execute(); 

   $res = $select->fetchAll(PDO::FETCH_ASSOC);

   echo '<p>Anzahl Musikstücke: '.count($res); 

   foreach ($res as $row=>$value) {
     $musikstueck = new Musikstueck(); 
     $musikstueck->ID = $value["ID"]; 
     $musikstueck->add_besetzung($BesetzungID);
    }    

  } 

  function delete_besetzung($BesetzungID){
    // dataclearing: eine Besetzung bei allen Musikstücken entfernen 

    include_once("cl_db.php");
    include_once("cl_musikstueck.php");    
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
    FROM `musikstueck` 
    WHERE SammlungID=:ID"); 

    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    echo '<p>Anzahl Musikstücke: '.count($res); 

    foreach ($res as $row=>$value) {
      $musikstueck = new Musikstueck(); 
      $musikstueck->ID = $value["ID"]; 
      $musikstueck->delete_besetzung($BesetzungID);
    }    
  } 

  
  function add_verwendungszweck($VerwendungszweckID){
      // dataclearing: Verwendungszweck bei allen Musikstücken ergänzen  
      include_once("cl_db.php");
      include_once("cl_musikstueck.php");    
      $conn = new DbConn(); 
      $db=$conn->db; 
   
      $select = $db->prepare("SELECT ID  
      FROM `musikstueck` 
      WHERE SammlungID=:ID"); 
   
      $select->bindValue(':ID', $this->ID);  
   
      $select->execute(); 
   
      $res = $select->fetchAll(PDO::FETCH_ASSOC);
   
      echo '<p>Anzahl Musikstücke: '.count($res); 
   
      foreach ($res as $row=>$value) {
        $musikstueck = new Musikstueck(); 
        $musikstueck->ID = $value["ID"]; 
        $musikstueck->add_verwendungszweck($VerwendungszweckID);
       }    
   
  } 

  function delete_verwendungszweck($VerwendungszweckID){
    // dataclearing: einen Verwendungszeck bei allen Musikstücken entfernen 

    include_once("cl_db.php");
    include_once("cl_musikstueck.php");    
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID  
    FROM `musikstueck` 
    WHERE SammlungID=:ID"); 

    $select->bindValue(':ID', $this->ID);  

    $select->execute(); 

    $res = $select->fetchAll(PDO::FETCH_ASSOC);

    echo '<p>Anzahl Musikstücke: '.count($res); 

    foreach ($res as $row=>$value) {
      $musikstueck = new Musikstueck(); 
      $musikstueck->ID = $value["ID"]; 
      $musikstueck->delete_verwendungszweck($VerwendungszweckID);
    }    
  } 

  function delete_lookups(){
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $delete = $db->prepare("DELETE FROM `sammlung_lookup` 
                            WHERE SammlungID=:SammlungID "); 
    $delete->bindValue(':SammlungID', $this->ID);  

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


}


?>
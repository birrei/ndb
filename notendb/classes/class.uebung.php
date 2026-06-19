<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.kalender.php"); 
include_once("class.kalendertag.php"); 

class Uebung {

  public $ID;
  public string $Name=''; // Anwender Anzeige: "Inhalt" 
  public $Bemerkung=''; 
  public $UebungtypID; 
  public $SchuelerID='';
  public string $SchuelerName=''; 
  public $SatzID=''; 
  public $Datum=''; 
  public $Anzahl=''; 
  public $Reihenfolge=0; // Sortierung innerhalb SchuelerID / Datum 
  public $BewertungID; 
  public string $Bewertung; 
  public $Typ=''; 

  public $titles_selected_list; 
  public $Title='Übung';
  public $Titles='Übungen';  
  public $table_name='uebung'; 
  public bool $Fehler=false; 

  public string $infotext=''; 

  private $db; 
  private $info; 



  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row (string $SchuelerID, string $Datum) {

    // if($Datum=='') {
    //   $this->Fehler=true;       
    //   $this->info->print_user_error('Das Datum darf nicht leer sein! Das Datum wird auf den letzten gültigen Übungstag gesetzt.'); 
    //   $Datum = $this->lastUebungsdatum($SchuelerID, $Datum); 
    // }

    // if($Datum!='') {
    //   $datum_date = new Datetime($Datum);
    //   $Datum_DE= $datum_date->format('d.m.Y');   
    //   if (!$this->UebungsdatumExists($SchuelerID, $Datum)) {
    //     $this->Fehler=true;    
    //     $this->info->print_user_error('Das Datum "'.$Datum_DE.'" ist kein gültiger Übungstag für den Schüler. 
    //                                   Es wird auf den letzten gültigen Übungstag gesetzt.');            
    //     $Datum = $this->lastUebungsdatum($SchuelerID, $Datum);     
    //   }
    // } 
    
    $insert = $this->db->prepare("INSERT INTO `uebung` 
              SET `SchuelerID`= :SchuelerID, Datum = :Datum " 
          );
          
    $insert->bindParam(':SchuelerID', $SchuelerID,PDO::PARAM_INT);
    $insert->bindParam(':Datum', $Datum);
  
    try {
      $insert->execute(); 
      // $insert->debugDumpParams(); 
      $this->ID=$this->db->lastInsertId(); 
      $this->load_row();        
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  
  
  function load_row() {  

    $select = $this->db->prepare("SELECT 
                              uebung.ID
                            , uebung.Name
                            , uebungtyp.Name as Typ
                            , COALESCE(uebung.Bemerkung, '') as Bemerkung
                            , uebung.UebungtypID
                            , uebung.SchuelerID
                            , uebung.Datum
                            , uebung.Anzahl 
                            , uebung.SatzID
                            , uebung.Reihenfolge
                            , schueler.Name as SchuelerName
                            , COALESCE(uebung.BewertungID, '') as BewertungID  
                            , COALESCE(bewertung.Name, '') as Bewertung  
                          FROM  uebung 
                                left join uebungtyp on uebung.UebungtypID = uebungtyp.ID 
                                left join schueler on uebung.SchuelerID = schueler.ID 
                                left join bewertung on bewertung.ID = uebung.BewertungID 
                          WHERE uebung.ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    // echo $select->rowCount(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Name=$row_data["Name"];       
      $this->SchuelerName=$row_data["SchuelerName"];       
      $this->UebungtypID=$row_data["UebungtypID"];      
      $this->SchuelerID=$row_data["SchuelerID"];        
      $this->SatzID=$row_data["SatzID"];       
      $this->Bemerkung=$row_data["Bemerkung"]; 
      $this->Datum=$row_data["Datum"];      
      $this->Anzahl=$row_data["Anzahl"];           
      $this->Typ=$row_data["Typ"];       
      $this->Reihenfolge=$row_data["Reihenfolge"];       
      $this->BewertungID=$row_data["BewertungID"];       
      $this->Bewertung=$row_data["Bewertung"];       
      return true; 
    } 
    else {
      return false; 
      $this->info->print_error('Die Anzeige ist nicht möglich'); 
    }  
  }  

  function load_row_Datum() {  

    $select = $this->db->prepare("SELECT uebung.Datum
                          FROM  uebung 
                          WHERE uebung.ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    // echo $select->rowCount(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Datum=$row_data["Datum"];            
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  private function UebungsdatumExists(int $SchuelerID, string $Datum):bool {

    $uebungskalender = new SchuelerKalender(); 
    $uebungskalender->SchuelerID= $SchuelerID; 

    if (!$uebungskalender->date_exists($Datum)) {
      // echo 'UebungsdatumExists: Datum '.$Datum.' existiert nicht <br>' ; // test
      return false; 
    } else {
      // echo 'UebungsdatumExists: Datum '.$Datum.' existiert <br>' ; // test
      return true; 
    }
  }

  private function lastUebungsdatum(int $SchuelerID, string $Datum) {

    $uebungskalender = new SchuelerKalender(); 
    $uebungskalender->SchuelerID= $SchuelerID; 

    $retDate = $uebungskalender->getLastdate($Datum); 
    
    return $retDate; 

  }

  function update_row ( $SchuelerID  
                      , $Datum
                      , $Name
                      , $Bemerkung
                      , $UebungtypID                                                      
                      , $Anzahl
                      , $SatzID
                      , $Reihenfolge
                      , $BewertungID   
                    ) {

    $update = $this->db->prepare("UPDATE uebung  
              SET UebungtypID= :UebungtypID
                , `Name`=:Name
                , Bemerkung=:Bemerkung 
                , SchuelerID=:SchuelerID 
                , Datum=:Datum               
                , Anzahl=:Anzahl
                , SatzID=:SatzID
                , Reihenfolge=:Reihenfolge 
                , BewertungID = :BewertungID 
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);    
    $update->bindParam(':UebungtypID', $UebungtypID, ($UebungtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':SchuelerID', $SchuelerID, ($SchuelerID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);
    $update->bindParam(':Datum', $Datum);      
    $update->bindParam(':Anzahl', $Anzahl);
    $update->bindParam(':Reihenfolge', $Reihenfolge);
    $update->bindParam(':SatzID', $SatzID, ($SatzID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':BewertungID', $BewertungID, ($BewertungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

    try {
      $update->execute(); 
      // $this->load_row();   
    }
      catch (PDOException $e) {  
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  ; 
    }
  }  

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `uebung` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $this->delete_lookups(); 
      $delete->execute(); 
      $this->info->print_info('Die Übung wurde gelöscht.');             
      return true;          
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false ; 
    }  
  }   

  function is_deletable() {
    // aktuell keine abhängigen Objekte 
    return true; 
  }

  function copy(){

    $sql="INSERT INTO uebung (Name
                            , Bemerkung
                            , UebungtypID
                            , SchuelerID
                            , Datum
                            , Anzahl
                            , SatzID
                            -- , BewertungID -- AG: nicht mitkopieren
                            )
          SELECT CONCAT(Name, ' (Kopie)') as Name 
                            , Bemerkung
                            , UebungtypID
                            , SchuelerID
                            , Datum 
                            , Anzahl
                            , SatzID
                            -- , BewertungID 
          FROM uebung  
          WHERE ID=:ID 


          ";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    
      $this->copy_lookups($ID_New); 
      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
      $this->infotext='Der Datensatz wurde kopiert.';
      $this->info->print_info($this->infotext);        
    }
    catch (PDOException $e) {     
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }  
  
  function print_table_lookups($target_file, $LookupTypeID=0){
    $query="SELECT lookup.ID
             , lookup_type.Name as Typ     
             , lookup.Name  
          FROM uebung_lookup          
          INNER JOIN lookup 
            on lookup.ID=uebung_lookup.LookupID
          INNER JOIN lookup_type
            on lookup_type.ID = lookup.LookupTypeID
          WHERE uebung_lookup.UebungID = :UebungID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':UebungID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='UebungID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();       
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    

  function add_lookup($LookupID){
    // echo 'Zuordnung LookupID: '.$LookupID.'<br>'; 
    $insert = $this->db->prepare("INSERT IGNORE INTO `uebung_lookup` SET
        `UebungID`     = :UebungID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':UebungID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }


  function delete_lookup($ID){

    $delete = $this->db->prepare("DELETE FROM `uebung_lookup` 
          WHERE UebungID=:UebungID
          AND LookupID=:LookupID "); 
    $delete->bindValue(':UebungID', $this->ID);            
    $delete->bindValue(':LookupID', $ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_lookups(){

    $delete = $this->db->prepare("DELETE FROM `uebung_lookup` WHERE UebungID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }  

  function copy_lookups($ID_new) {

    $sql="insert into uebung_lookup
          (UebungID, LookupID) 
    select :UebungID_new as UebungID
          , LookupID
    from uebung_lookup 
    where UebungID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':UebungID_new', $ID_new);  
    $insert->execute();  

  }


  function print_table_satz_lookups_checklist(){
    // lookups aus dem der Übung zugeordneten Satz 

    $query="select lookup.ID
          , CONCAT(lookup_type.Name, ': ', lookup.Name) as Name 
          FROM satz_lookup 
          INNER join lookup on lookup.ID = satz_lookup.LookupID 
          INNER JOIN lookup_type ON lookup_type.ID = lookup.LookupTypeID 
          INNER JOIN uebung on uebung.SatzID=satz_lookup.SatzID 
          LEFT JOIN uebung_lookup on uebung_lookup.UebungID = uebung.ID 
              AND uebung_lookup.LookupID = satz_lookup.LookupID 
          WHERE uebung.ID =  :ID
          AND uebung_lookup.ID IS NULL 
          order by Name"; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->print_table_checklist('lookups'); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }
  
  function update_Order($Datum) {

    $Reihenfolge = $this->get_Order($Datum); 
       
    $update = $this->db->prepare("UPDATE `uebung` 
                        SET Reihenfolge = :Reihenfolge 
                        WHERE ID=:ID " );
          
    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Reihenfolge', $Reihenfolge);

    try {
      $update->execute(); 
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  ; 
    }    
  }

  function get_Order ($Datum) {
    // nächste Reihenfolge innerhalb Schüler / Datum ermitteln (nur bei insert, copy)
    // echo 'Datum: '.$Datum.'<br>'; // TEST  
    $this->load_row(); 
    $sql="SELECT (coalesce(MAX(Reihenfolge),0)) + 1 as Reihenfolge_Neu from `uebung` 
             WHERE SchuelerID=:SchuelerID 
             AND Datum=:Datum 
             AND ID != :ID"; // akt. ID ausklammern, sonst wird bei jedem Update weiter hochgezählt 
    $stmt = $this->db->prepare($sql); 
    $stmt->bindParam(':SchuelerID', $this->SchuelerID, PDO::PARAM_INT); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 
    $stmt->bindParam(':Datum', $this->Datum); 
    $stmt->execute(); 
    // $stmt->debugDumpParams(); 
    $col=$stmt->fetchColumn(); 
    return $col;  
  } 
}

 



?>
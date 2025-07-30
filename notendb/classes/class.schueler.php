<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Schueler {

  public $table_name='schueler'; 
  public $ID;
  public $Name;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Schüler';
  public $Titles='Schüler';  
  public $Ref = ''; // "Satz" oder "Material" 
  public string $infotext=''; 
  public int $Aktiv=1; // true/false, tinyint 1/0 for mysql 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `schueler` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();  
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function print_select($selected_SchuelerID='', $ParentID='', $caption='', $nurAktiv=false){
    // $ParentID: MaterialID oder SatzID 
    // echo '<p>selected_SchuelerID: '.$selected_SchuelerID.', ParentID: '.$ParentID.'<p>'; // test 

    if ($nurAktiv) {
      $query='SELECT ID, Name FROM `schueler` WHERE Aktiv=1 ';
    } 
    else {
      $query='SELECT ID, Name FROM `schueler` WHERE 1=1 ';
    }
    
    switch ($this->Ref) {
      case 'Satz': 
        if ($ParentID!='') {
          $query.="AND ID NOT IN 
                (SELECT SchuelerID FROM schueler_satz 
                WHERE SatzID=:ParentID ".($selected_SchuelerID!=''?"AND SchuelerID!=:selected_SchuelerID":'').") "; 
        }  
        break; 
      case 'Material': 
        if ($ParentID!='') {
          $query.="AND ID NOT IN 
                (SELECT SchuelerID FROM schueler_material  
                WHERE MaterialID=:ParentID ".($selected_SchuelerID!=''?"AND SchuelerID!=:selected_SchuelerID":'').") "; 
        } 
                               
        break;       
    }

    $query.='ORDER BY `Name`'; 

    // echo $query; // test 

    $stmt = $this->db->prepare($query); 

    if ($ParentID!=''){
      // echo 'ParentID'; 
      $stmt->bindParam(':ParentID', $ParentID, PDO::PARAM_INT);

      if ($selected_SchuelerID!=''){
        // echo 'selected_SchuelerID';       
        $stmt->bindParam(':selected_SchuelerID', $selected_SchuelerID, PDO::PARAM_INT);
      }  
    }

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HTML_Select($stmt); 
      $html->caption = $caption;  
      $html->autofocus=false;      
      $html->print_select("SchuelerID", $selected_SchuelerID, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function update_row($Name, $Bemerkung, $Aktiv) {

    $update = $this->db->prepare("UPDATE `schueler` 
                            SET`Name`     = :Name,
                            Bemerkung = :Bemerkung, 
                            Aktiv = :Aktiv
                            WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Bemerkung', $Bemerkung);    
    $update->bindParam(':Aktiv', $Aktiv);   

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

    $select = $this->db->prepare("SELECT `ID`
                          , `Name`
                          , COALESCE(Bemerkung, '') as Bemerkung
                          , Aktiv  
                          FROM `schueler`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Bemerkung=$row_data["Bemerkung"];       
      $this->Aktiv=$row_data["Aktiv"];             
      return true; 
    } 
    else {
      return false; 
    }    
  }  
 
  function print_table_schwierigkeitsgrade($target_file){
    $query="SELECT
    schueler_schwierigkeitsgrad.ID 
          , instrument.Name as Instrument 
          , schwierigkeitsgrad.Name as Schwierigkeitsgrad
          -- , instrument.ID 
          -- , schueler_schwierigkeitsgrad.SchwierigkeitsgradID as ID2          
          FROM schueler_schwierigkeitsgrad 
          left join schwierigkeitsgrad 
              on  schwierigkeitsgrad.ID = schueler_schwierigkeitsgrad.SchwierigkeitsgradID
          left join instrument
          on instrument.ID = schueler_schwierigkeitsgrad.InstrumentID 
          WHERE schueler_schwierigkeitsgrad.SchuelerID = :SchuelerID 
          ORDER BY instrument.Name, schwierigkeitsgrad.Name 
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='SchuelerID'; 
      $html->del_link_parent_id= $this->ID; 
      // $html->del_link_count_params=2; 
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
  
  function add_schwierigkeitsgrad($SchwierigkeitsgradID, $InstrumentID){

    $select = $this->db->prepare("SELECT * FROM schueler_schwierigkeitsgrad   
                        WHERE 
                        `SchuelerID`     = :SchuelerID AND 
                        `SchwierigkeitsgradID`     = :SchwierigkeitsgradID AND 
                        `InstrumentID`     = :InstrumentID
        ");

    $select->bindValue(':SchuelerID', $this->ID);  
    $select->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
     $select->bindValue(':InstrumentID', $InstrumentID);  


    $select->execute(); 

    if ($select->rowCount()>0 ) {
        echo '<p>Die gewählte Kombination exisitiert bereits!</p>'; 
    } 
    else {
      $insert = $this->db->prepare("INSERT INTO `schueler_schwierigkeitsgrad` SET
      `SchuelerID`     = :SchuelerID,  
      `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
      `InstrumentID`     = :InstrumentID
      ");

      $insert->bindValue(':SchuelerID', $this->ID);  
      $insert->bindParam(':SchwierigkeitsgradID', $SchwierigkeitsgradID, ($SchwierigkeitsgradID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
      $insert->bindValue(':InstrumentID', $InstrumentID);      

      try {
        $insert->execute(); 
        include_once("classes/class.instrument_schwierigkeitsgrad.php");
        $instrument_schwierigkeitsgrad=new InstrumentSchwierigkeitsgrad(); 
        $instrument_schwierigkeitsgrad->insert_row($InstrumentID, $SchwierigkeitsgradID); 
      }
        catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($insert, $e);  
      }  
    }
  }

  function delete_schwierigkeitsgrad($ID){

    $delete = $this->db->prepare("DELETE 
                      FROM `schueler_schwierigkeitsgrad` 
                      WHERE ID=:ID"
                    ); 

    $delete->bindValue(':ID', $ID);      

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
  
  function print_table_saetze(){
      $query="SELECT schueler_satz.ID
      , sammlung.Name as `Sammlung`
      , musikstueck.Nummer as `Nr`    
      , musikstueck.Name as `Musikstück`
      , satz.Nr as `Satz Nr`    
      , satz.Name as `Satz Name`
      , status.Name as `Status`
      , schueler_satz.DatumVon as `Datum von` 
      , schueler_satz.DatumBis as `Datum bis` 
      , schueler_satz.Bemerkung

     -- , schueler_satz.SatzID           
    FROM schueler_satz
    LEFT JOIN satz ON satz.ID = schueler_satz.SatzID  
    LEFT JOIN musikstueck ON musikstueck.ID = satz.MusikstueckID
    LEFT JOIN sammlung ON sammlung.ID = musikstueck.SammlungID
    LEFT JOIN status ON status.ID = schueler_satz.StatusID                                
    WHERE schueler_satz.SchuelerID = :ID
    order by satz.Name "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=true;   
      $html->edit_link_table='schueler_satz'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false; 

      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_schueler_satz.php'; 
      // $html->del_link_parent_key='SchuelerID'; 
      // $html->del_link_parent_id= $this->ID;             
      
      // // Link zu Satz-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='SatzID'; 
      // $html->edit2_link_filename='edit_satz.php'; 
      // $html->edit2_link_title='Satz';       

      
      $html->print_table2(); 

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }    
  
  function print_table_materials(){
    $query="SELECT schueler_material.ID
            , material.Name 
            , sammlung.Name as Sammlung  
            , materialtyp.Name  as `Materialtyp`
            , schueler_material.DatumVon as `Datum von`
            , schueler_material.DatumBis as `Datum bis` 
            , status.Name as Status      
            , schueler_material.Bemerkung                   
          FROM schueler_material
          LEFT JOIN status on status.ID =  schueler_material.StatusID          
          LEFT JOIN material ON material.ID = schueler_material.MaterialID  
          LEFT JOIN materialtyp ON materialtyp.ID = material.MaterialtypID  
          LEFT JOIN sammlung on sammlung.ID = material.SammlungID                            
          WHERE schueler_material.SchuelerID = :ID
          order by material.Name  
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=true;      
      $html->edit_link_table='schueler_material'; 
      $html->edit_link_title='Schueler'; 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;      
      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_schueler_materials.php'; 
      // $html->del_link_parent_key='SchuelerID'; 
      // $html->del_link_parent_id= $this->ID;  
      
      // // Link zu Material-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='MaterialID'; 
      // $html->edit2_link_filename='edit_material.php'; 
      // $html->edit2_link_title='Material';       

      $html->print_table2(); 

    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }    

  function delete_satze(){

    $delete = $this->db->prepare("DELETE FROM `schueler_satz` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

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

  function delete_materials(){

    $delete = $this->db->prepare("DELETE FROM `schueler_material` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

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

  function delete_schwierigkeitsgrade(){

    $delete = $this->db->prepare("DELETE FROM `schueler_schwierigkeitsgrad` WHERE SchuelerID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

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

  function delete(){

    $this->delete_materials(); 
    $this->delete_satze(); 
    $this->delete_schwierigkeitsgrade(); 
      
    $delete = $this->db->prepare("DELETE FROM `schueler` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Der Schüler wurde gelöscht. </p>';  
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

  function copy(){

    $sql="INSERT INTO schueler (Name, Bemerkung)
          SELECT CONCAT(Name, ' (Kopie)') as Name , Bemerkung
          FROM schueler 
          WHERE ID=:ID ";
    // Aktiv nicht kopieren, da default = 1

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    

      $this->copy_schwierigkeitsgrade($ID_New); 
      $this->copy_saetze($ID_New); 
      $this->copy_materials($ID_New); 

      $this->ID =  $ID_New; // Stabübergabe (Objekt-Instanz übernimmt neue ID-Kopie )
    }
    catch (PDOException $e) {
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  
    }  
  } 

  function copy_schwierigkeitsgrade($ID_new) {

    $sql="INSERT INTO schueler_schwierigkeitsgrad
          (SchuelerID, SchwierigkeitsgradID, InstrumentID) 
        SELECT :SchuelerID_new as SchuelerID
              , SchwierigkeitsgradID
              , InstrumentID
        FROM schueler_schwierigkeitsgrad 
        WHERE SchuelerID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function copy_saetze($ID_new) {

    $sql="INSERT INTO schueler_satz (SchuelerID, SatzID) 
        SELECT :SchuelerID_new as SchuelerID
              , SatzID
        FROM schueler_satz 
        WHERE SchuelerID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function copy_materials($ID_new) {

    $sql="INSERT INTO schueler_material(SchuelerID, MaterialID) 
        SELECT :SchuelerID_new as SchuelerID
              , MaterialID
        FROM schueler_material 
        WHERE SchuelerID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':SchuelerID_new', $ID_new);  
    $insert->execute();  

  }   

  function print_table_material_checklist(){
    // Auswahl im Screen "Übung" 
    $query="select distinct material.ID, material.Name
            from material 
            left join schueler_material on material.ID = schueler_material.MaterialID 
                        and schueler_material.SchuelerID = :SchuelerID 
            where schueler_material.ID is null 
            order by material.Name 
        "; 
  
    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->print_table_checklist('material'); 


    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_select_saetze($selected_SatzID=''){

    $query="
      SELECT satz.ID
          , CONCAT(
                sammlung.Name, ' - ', 
                  -- musikstueck.Nummer, ' - ', 
                  musikstueck.Name, ' - Satz Nr: ',  
                  satz.Nr
                  ) Name 
          -- , schueler_satz.SchuelerID
        FROM satz  
              inner join musikstueck on satz.MusikstueckID = musikstueck.ID
              inner JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
              inner join schueler_satz on schueler_satz.SatzID = satz.ID
              inner join status on status.ID=schueler_satz.StatusID
        WHERE 1=1 
        AND schueler_satz.SchuelerID = :SchuelerID  ";

          
    $query.=$selected_SatzID!=''?"AND satz.ID=:SatzID OR status.Name LIKE '%Aktiv%'":"AND status.Name LIKE '%Aktiv%'"; 

    $stmt = $this->db->prepare($query);      
    
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT);

    if ($selected_SatzID!='') {
      $stmt->bindParam(':SatzID', $selected_SatzID, PDO::PARAM_INT);
    }

    $query.='ORDER BY `Name`'; 

    // echo $query; // test 

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HTML_Select($stmt); 
      // $html->caption = $caption;  
      $html->autofocus=false;      
      $html->print_select("SatzID", $selected_SatzID, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_select_materials($selected_MaterialID=''){

    $query=" SELECT material.ID
          , CONCAT(material.Name, ' (' , materialtyp.Name, ') ', sammlung.Name) as Name 
    FROM material  
            inner JOIN materialtyp on materialtyp.ID = material.MaterialtypID 
            inner JOIN schueler_material on schueler_material.MaterialID = material.ID 
            inner JOIN status on status.ID = schueler_material.StatusID         
            inner JOIN sammlung on sammlung.ID = material.SammlungID   
        WHERE 1=1 
        AND schueler_material.SchuelerID = :SchuelerID  ";

    $query.=$selected_MaterialID!=''?"AND material.ID=:MaterialID OR status.Name LIKE '%Aktiv%'":"AND status.Name LIKE '%Aktiv%'"; 

    $stmt = $this->db->prepare($query);      
    
    $stmt->bindParam(':SchuelerID', $this->ID, PDO::PARAM_INT);

    if ($selected_MaterialID!='') {
      $stmt->bindParam(':MaterialID', $selected_MaterialID, PDO::PARAM_INT);
    }

    $query.='ORDER BY `Name`'; 

    // echo $query; // test 

    try {
      $stmt->execute(); 
      // $stmt->debugDumpParams(); // Test 
      $html = new HTML_Select($stmt); 
      // $html->caption = $caption;  
      $html->autofocus=false;      
      $html->print_select("MaterialID", $selected_MaterialID, true); 
      
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($stmt, $e); 
    }
  }

  function print_table_uebungen(){

    $query="SELECT 
              uebung.ID
              , uebungtyp.Name as Typ    
              , uebung.Name 
              , uebung.Datum
              , uebung.Anzahl
              , uebungtyp.Einheit
              , uebung.Bemerkung
              , CONCAT(
                    sammlung.Name, ' - ', 
                      -- musikstueck.Nummer, ' - ', 
                      musikstueck.Name, ' - Satz Nr. ',  
                      satz.Nr
                      ) Notenstueck  
              , CONCAT(material.Name, ' (' , materialtyp.Name, ') ', sammlung2.Name) as Material 	         
          FROM  uebung 
              left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
              left join satz  on satz.ID=uebung.SatzID 
              left join musikstueck on satz.MusikstueckID = musikstueck.ID
              left JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
              left join material  on material.ID=uebung.MaterialID
              left JOIN materialtyp on materialtyp.ID = material.MaterialtypID      
              left join sammlung as sammlung2  on sammlung2.ID=material.SammlungID
          WHERE uebung.SchuelerID = :ID 
          ORDER BY uebung.Datum DESC              
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=true;      
      $html->edit_link_table='uebung'; 
      $html->edit_link_title='Übung'; 
      $html->edit_link_open_newpage=true; 
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

  function print_table_auswertung_uebungen(){
    $query="
        SELECT 
            -- uebung.ID
            uebungtyp.Name as Typ    
            , YEAR(uebung.Datum) as Jahr
            , MONTH(uebung.Datum) as Monat          
            , SUM(uebung.Anzahl) as Anzahl 
            , uebungtyp.Einheit            
            , MIN(uebung.Datum) as `Datum Start`
            , MAX(uebung.Datum) as `Datum Zuletzt`         
            , COUNT(DISTINCT uebung.Datum) as Tage     
            -- , uebung.SchuelerID
            -- , uebung.UebungtypID
        FROM  uebung 
              left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
              left join satz  on satz.ID=uebung.SatzID 
              left join musikstueck on satz.MusikstueckID = musikstueck.ID
              left JOIN sammlung on sammlung.ID = musikstueck.SammlungID      
              left join material  on material.ID=uebung.MaterialID
              left JOIN materialtyp on materialtyp.ID = material.MaterialtypID      
              left join sammlung as sammlung2  on sammlung2.ID=material.SammlungID
        WHERE uebung.SchuelerID = :ID 
        AND UebungtypID  is not null 
        GROUP by uebung.SchuelerID
          , uebung.UebungtypID
          , uebungtyp.Einheit
          , YEAR(uebung.Datum)
          , MONTH(uebung.Datum) 
        ORDER BY `Datum Zuletzt` DESC              
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      include_once("cl_html_table.php");      
      $html = new HtmlTable($stmt); 
      $html->add_link_edit=false;      
      $html->edit_link_table='uebung'; 
      $html->edit_link_title='Übung'; 
      $html->edit_link_open_newpage=true; 
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

}

 



?>
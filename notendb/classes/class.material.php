<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.satz.php");    

class Material {

  public $table_name='material'; 
  public $ID;
  public $Name='';
  public $Bemerkung=''; 
  public $MaterialtypID; 
  public $SammlungID;   
  public $titles_selected_list; 
  public $Title='Material';
  public $Titles='Materialien';  

  public int $anzahl_schueler=0; 

  public string $infotext=''; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($MaterialtypID='', $SammlungID='') {
    // echo '<p>SammlungID: '.$SammlungID.', MaterialtypID: '.$MaterialtypID.'</p>'; // test 

    $insert = $this->db->prepare("INSERT INTO `material` 
          SET MaterialtypID = :MaterialtypID, 
               SammlungID = :SammlungID
          ");
          
    $insert->bindParam(':MaterialtypID', $MaterialtypID, ($MaterialtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $insert->bindParam(':SammlungID', $SammlungID, ($SammlungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

    try {
      $insert->execute(); 
      $this->ID=$this->db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

  function update_row ($MaterialtypID, $Name, $Bemerkung, $SammlungID='') {

    if ($this->ID=='') {
      $this->insert_row(); 
    } 
    $update = $this->db->prepare("UPDATE `material` 
              SET MaterialtypID= :MaterialtypID
                , `Name`=:Name
                , Bemerkung=:Bemerkung
                , SammlungID=:SammlungID
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':MaterialtypID', $MaterialtypID, ($MaterialtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':SammlungID', $SammlungID, ($SammlungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Name', $Name);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);   ; 
    }
  }  
 
  function load_row() {

    $select = $this->db->prepare("SELECT ID
                            , `Name`
                            , COALESCE(Bemerkung, '') as Bemerkung
                            , MaterialtypID
                            , SammlungID 
                          FROM `material`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Name=$row_data["Name"];       
      $this->MaterialtypID=$row_data["MaterialtypID"];  
      $this->SammlungID=$row_data["SammlungID"];        
      $this->Bemerkung=$row_data["Bemerkung"]; 
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function count_schueler() {

    $select = $this->db->prepare("SELECT ID from schueler_material WHERE MaterialID=:ID");
    $select->bindValue(':ID', $this->ID); 
    $select->execute();  

    $this->anzahl_schueler= $select->rowCount();  

  }

  function is_deletable() {
    $this->infotext=''; 
    $this->count_schueler(); 
    if ( $this->anzahl_schueler > 0 ) {
      $this->infotext.='Das Material ist nicht löschbar, da '.$this->anzahl_schueler.' Schüler-Verknüpfung(en) vorhanden sind .'; 
      return false; 
    }
    return true; 
  }

  function delete(){

    $this->delete_lookups();     
    $this->delete_schuelers(); 

    $delete = $this->db->prepare("DELETE FROM `material` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Das Material wurde gelöscht.');      
      return true;          
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false ; 
    }  
  }   

  function delete_lookups(){

    $delete = $this->db->prepare("DELETE FROM material_lookup WHERE MaterialID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }
 
  function delete_schuelers(){

    $delete = $this->db->prepare("DELETE FROM `schueler_material` WHERE MaterialID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  } 

  function insert_material_tmp ($URL, $Title) {

    $insert = $this->db->prepare("INSERT INTO `material_tmp` 
              SET URL = :URL, Title=:Title "       
           );

    $insert->bindParam(':URL', $URL);
    $insert->bindParam(':Title', $Title);    

    try {
      $insert->execute(); 
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  ; 
    }
  }  

  function truncate_material_tmp () {

    $stmt = $this->db->prepare("TRUNCATE TABLE material_tmp");

    try {
      $stmt->execute(); 
    }
      catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e);  ; 
    }
  }
  
  function print_material_tmp () {
    $query="SELECT * FROM material_tmp"; 
    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=false;
      // $html->del_material_filename=$target_file; 
      $html->show_missing_data_message=false; 
      $html->print_table2();           
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }

  }

  function print_table_schueler(){
    $query="SELECT schueler_material.ID 
            , schueler.Name as Schueler
            , schueler_material.DatumVon as `Datum von`
            , schueler_material.DatumBis as `Datum bis`
            , `status`.`Name` as `Status`   
            , schueler_material.Bemerkung
            , IF(schueler.Aktiv=1, 'Ja', 'Nein') as Aktiv_JN                             
           -- , schueler_satz.SchuelerID 
          FROM schueler_material
          LEFT JOIN schueler on  schueler.ID = schueler_material.SchuelerID  
          LEFT JOIN status on status.ID =  schueler_material.StatusID
          WHERE schueler_material.MaterialID = :MaterialID 
          order by schueler.Name  
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MaterialID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=true;       
      $html->edit_link_table='material_schueler'; 
      // $html->edit_link_title='Schueler'; #obsolete 
      $html->edit_link_open_newpage=false; 
      $html->show_missing_data_message=false;    

      // $html->add_link_delete=true; // XXX 
      // $html->del_link_filename='edit_material_schueler.php'; 
      // $html->del_link_parent_key='MaterialID'; 
      // $html->del_link_parent_id= $this->ID;    
      
      // // Link zu Schüler-Formular 
      // $html->add_link_edit2=true; 
      // $html->edit2_link_colname='SchuelerID'; 
      // $html->edit2_link_filename='edit_schueler.php'; 
      // $html->edit2_link_title='Schüler';       

      $html->print_table2(); 

    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    

  function print_select( $selected_MaterialID='', $ParentID='', $MaterialtypID=''){

    // XXX Material für einen ausgewählten Typ   

    $query="
    SELECT material.ID
		   , CONCAT(
		   	   IF(sammlung.ID is not null, 
		   	   		CASE WHEN LENGTH(sammlung.Name) > 50
	            	THEN LEFT(sammlung.Name, 50)
	            	ELSE sammlung.Name
	            	END 
		   	   	, '') ,
		   	   CASE WHEN LENGTH(material.Name) > 50
            	THEN CONCAT(LEFT(material.Name, 50), ' (...) (', materialtyp.Name, ')') 
            	ELSE CONCAT(material.Name, ' (',  materialtyp.Name, ')')
            	END 
		   ) as Material
            FROM material 
            INNER JOIN materialtyp ON materialtyp.ID=material.MaterialtypID
            LEFT JOIN sammlung ON sammlung.ID = material.SammlungID  
            WHERE 1=1 
    " ;

    if ($selected_MaterialID!='') {
        $query.=($ParentID!=''?'AND material.ID NOT IN 
              (SELECT MaterialID FROM schueler_material 
              WHERE SchuelerID=:ParentID
              AND MaterialID!=:selected_MaterialID) ':''); 
    } else {
        $query.=($ParentID!=''?'AND material.ID NOT IN 
            (SELECT MaterialID FROM schueler_material 
            WHERE SchuelerID=:ParentID) ':''); 
    }
    
    if ($MaterialtypID!=''){
        $query.="AND MaterialtypID=:MaterialtypID "; 
    }

    $query.='ORDER BY material.Name'; 

    // echo $query; // Test 

    $stmt = $this->db->prepare($query); 

    if ($MaterialtypID!=''){
      $stmt->bindParam(':MaterialtypID', $MaterialtypID, PDO::PARAM_INT);   
    }
    if ($ParentID!=''){
      $stmt->bindParam(':ParentID', $ParentID, PDO::PARAM_INT); 
    }
    if ($selected_MaterialID!=''){
      $stmt->bindParam(':selected_MaterialID', $selected_MaterialID, PDO::PARAM_INT); 
    }


    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      // $stmt->debugDumpParams(); // Test 
      // $html->caption = $caption;       
      $html->print_select("MaterialID", $selected_MaterialID, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function copy($SammlungID_New=0){
    // SammlungID_New > 0 : Material Kopie zu Sammlung Kopie 
    // SammlungID_New= 0: Material Kopie an gleicher Sammlung, Funktion "Kopieren" an Material 
    // SammlungID_New=-1: Material Kopie Material ohne Sammlungs-Verknüpfung 

    if ($SammlungID_New>0) {
      $sql="INSERT INTO material (SammlungID, MaterialtypID, `Name`, Bemerkung) 
            SELECT :SammlungID as SammlungID, MaterialtypID, `Name`, Bemerkung 
            FROM material 
            WHERE ID=:ID";
    } elseif($SammlungID_New==0) {
      $sql="INSERT INTO material (SammlungID, MaterialtypID, `Name`, Bemerkung) 
            SELECT SammlungID, MaterialtypID, CONCAT(`Name`, ' (Kopie)') as Name, Bemerkung 
            FROM material 
            WHERE ID=:ID";
    } elseif($SammlungID_New<0) {
      $sql="INSERT INTO material (MaterialtypID, `Name`, Bemerkung) 
            SELECT MaterialtypID, `Name`, Bemerkung 
            FROM material 
            WHERE ID=:ID";
    }

    // echo '<pre>'.$sql.'</pre>'; // test 
    
    $insert = $this->db->prepare($sql); 
    
    $insert->bindValue(':ID', $this->ID);  
    
    if ($SammlungID_New>0) {
      $insert->bindValue(':SammlungID', $SammlungID_New);  
    }

    try {
      $insert->execute(); 
      $ID_New = $this->db->lastInsertId();    
        
      $this->copy_lookups($ID_New); 

      $this->copy_schwierigkeitsgrade($ID_New); 

      $this->copy_schueler($ID_New); 

      $this->ID= $ID_New; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function copy_schueler($ID_new) {

    $sql="insert into schueler_material 
          (MaterialID, SchuelerID) 
    select :MaterialID as MaterialID
          , SchuelerID
    from schueler_material 
    where MaterialID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MaterialID', $ID_new);  
    $insert->execute();  

  }

  function copy_lookups($ID_new) {

    $sql="insert into material_lookup 
          (MaterialID, LookupID) 
    select :MaterialID as MaterialID
          , LookupID
    from material_lookup 
    where MaterialID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MaterialID', $ID_new);  
    $insert->execute();  

  }  

  function print_table_schueler_checklist(){
    $query="select distinct schueler.ID, schueler.Name
            from schueler 
            left join schueler_material on schueler.ID = schueler_material.SchuelerID 
                        and schueler_material.MaterialID = :MaterialID 
            where schueler_material.ID is null 
            and schueler.Aktiv=1
            order by schueler.Name 
        "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MaterialID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
      $html = new HTML_Table($stmt); 
      $html->print_table_checklist('schueler'); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function add_lookup($LookupID){

    $insert = $this->db->prepare("INSERT INTO `material_lookup` SET
        `MaterialID`     = :MaterialID,  
        `LookupID`     = :LookupID");

    $insert->bindValue(':MaterialID', $this->ID);  
    $insert->bindValue(':LookupID', $LookupID);  

    try {
      $insert->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  } 

  function delete_lookup($LookupID){

    $delete = $this->db->prepare("DELETE FROM `material_lookup` 
                            WHERE MaterialID=:MaterialID 
                            AND LookupID=:LookupID"); 
    $delete->bindValue(':MaterialID', $this->ID);  
    $delete->bindValue(':LookupID', $LookupID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function print_table_lookups($target_file, $LookupTypeID=0){

    $query="SELECT lookup.ID
             , lookup_type.Name as Typ     
             , lookup.Name  
          FROM material_lookup          
          INNER JOIN lookup 
            on lookup.ID=material_lookup.LookupID
          INNER JOIN lookup_type
            on lookup_type.ID = lookup.LookupTypeID
          WHERE material_lookup.MaterialID = :MaterialID";
          $query.=($LookupTypeID>0?" AND lookup.LookupTypeID = :LookupTypeID":""); 
          $query.=" ORDER by lookup_type.Name, lookup.Name"; 

    // echo $query; 
  
    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MaterialID', $this->ID, PDO::PARAM_INT);
    if ($LookupTypeID>0) {
      $stmt->bindParam(':LookupTypeID', $LookupTypeID, PDO::PARAM_INT);
    } 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MaterialID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function print_table_schwierigkeitsgrade($target_file){
    $query="SELECT instrument.ID 
        , instrument.Name as Instrument 
        , schwierigkeitsgrad.Name as Grad
        FROM material_schwierigkeitsgrad 
        inner join schwierigkeitsgrad 
            on  schwierigkeitsgrad.ID = material_schwierigkeitsgrad.SchwierigkeitsgradID
        inner join instrument
        on instrument.ID = material_schwierigkeitsgrad.InstrumentID 
        WHERE material_schwierigkeitsgrad.MaterialID = :MaterialID 
        ORDER BY instrument.Name, schwierigkeitsgrad.Name 
      "; 

    $stmt = $this->db->prepare($query); 
    $stmt->bindParam(':MaterialID', $this->ID, PDO::PARAM_INT); 

    try {
      $stmt->execute(); 
            
      $html = new HTML_Table($stmt); 
      $html->add_link_edit=false;
      $html->add_link_delete=true;
      $html->del_link_filename=$target_file; 
      $html->del_link_parent_key='MaterialID'; 
      $html->del_link_parent_id= $this->ID; 
      $html->show_missing_data_message=false; 
      $html->print_table2();           
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

  function add_schwierigkeitsgrad($SchwierigkeitsgradID, $InstrumentID){

    $insert = $this->db->prepare("INSERT INTO `material_schwierigkeitsgrad` SET
                        `MaterialID`     = :MaterialID,  
                        `SchwierigkeitsgradID`     = :SchwierigkeitsgradID,
                        `InstrumentID`     = :InstrumentID
        ");

    $insert->bindValue(':MaterialID', $this->ID);  
    $insert->bindValue(':SchwierigkeitsgradID', $SchwierigkeitsgradID);  
    $insert->bindValue(':InstrumentID', $InstrumentID);      

    try {
      $insert->execute(); 
      include_once("class.instrument_schwierigkeitsgrad.php");
      $instrument_schwierigkeitsgrad=new InstrumentSchwierigkeitsgrad(); 
      $instrument_schwierigkeitsgrad->insert_row($InstrumentID, $SchwierigkeitsgradID); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($insert, $e);  
    }  
  }

  function delete_schwierigkeitsgrade(){

    $delete = $this->db->prepare("DELETE FROM `material_schwierigkeitsgrad` WHERE MaterialID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function delete_schwierigkeitsgrad($ID){

    $delete = $this->db->prepare("DELETE 
                          FROM `material_schwierigkeitsgrad` 
                          WHERE MaterialID=:MaterialID
                          AND InstrumentID=:InstrumentID"
                        ); 
    $delete->bindValue(':MaterialID', $this->ID);  
    $delete->bindValue(':InstrumentID', $ID);      

    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }  
  }

  function copy_schwierigkeitsgrade($ID_new) {

    // schwierigkeitsgrade 
    $sql="insert into material_schwierigkeitsgrad
          (MaterialID, SchwierigkeitsgradID, InstrumentID) 
    select :MaterialID_new as MaterialID
          , SchwierigkeitsgradID
          , InstrumentID
    from material_schwierigkeitsgrad 
    where MaterialID=:ID";

    $insert = $this->db->prepare($sql); 
    $insert->bindValue(':ID', $this->ID);  
    $insert->bindValue(':MaterialID_new', $ID_new);  
    $insert->execute();  

  }  

}

 



?>
<?php 
 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Komponist {

  public $table_name='komponist'; 

  public $ID;
  public $Vorname;
  public $Nachname;
  public $Name; 
  public $Geburtsjahr;
  public $Sterbejahr;
  public $Bemerkung;
  public $titles_selected_list; 
  public $Title='Komponist';
  public $Titles='Komponisten';  
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Vorname, $Nachname) {                

    $insert = $this->db->prepare("INSERT INTO `komponist` SET
                          `Vorname`     = :Vorname,
                          `Nachname`     = :Nachname
                          "
    );

    $insert->bindParam(':Vorname', $Vorname);
    $insert->bindParam(':Nachname', $Nachname);

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

  function load_row() {

    $select = $this->db->prepare("SELECT `ID`
      , `Vorname`
      , `Nachname`
      , `Geburtsjahr`
      , `Sterbejahr`
      , `Bemerkung` 
    FROM `komponist`
    WHERE `ID` = :ID");
    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Vorname=$row_data["Vorname"];
      $this->Nachname=$row_data["Nachname"];
      $this->Name = $row_data["Vorname"].' '.$row_data["Nachname"];
      $this->Geburtsjahr=$row_data["Geburtsjahr"];
      $this->Sterbejahr=$row_data["Sterbejahr"];
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } 
    else {
      return false; 
    }
  }  

  function update_row(
              $Vorname
                , $Nachname
                , $Geburtsjahr
                , $Sterbejahr
                , $Bemerkung    
                  ) {

    $update = $this->db->prepare("UPDATE `komponist` 
                          SET
                          `Vorname`     = :Vorname,
                          `Nachname`     = :Nachname,
                          `Geburtsjahr`     = :Geburtsjahr,
                          `Sterbejahr`     = :Sterbejahr,
                          `Bemerkung` = :Bemerkung
                          WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Vorname', $Vorname);
    $update->bindParam(':Nachname', $Nachname);
    $update->bindParam(':Geburtsjahr', $Geburtsjahr);
    $update->bindParam(':Sterbejahr', $Sterbejahr);
    $update->bindParam(':Bemerkung', $Bemerkung);


    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e); 
      }
  }

  function print_select($value_selected='', $caption=''){
    /* Auswahl-Element Komponisten */   

    /* view v_select_komponist verwendet */
    $query="SELECT DISTINCT 
            `ID` as KomponistID
            , Name 
            FROM `v_komponist` 
            order by `Nachname`"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      $html = new HTML_Select($select); 
      $html->caption = $caption;       
      $html->print_select("KomponistID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }

  function print_table(){

    $query="SELECT * from v_komponist ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
            
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($select, $e);
    }
  }


  function print_select_multi($options_selected=[]){

    $query="SELECT ID, Name 
            FROM `v_komponist` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->print_select_multi('Komponist', 'Komponisten[]', $options_selected, 'Komponist(en):'); 
      $this->titles_selected_list = $html->titles_selected_list;      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }    

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `komponist` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Komponist wurde gelöscht');        
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }      
  }

  function is_deletable() {

    $select = $this->db->prepare("SELECT * from musikstueck WHERE KomponistID=:KomponistID");
    $select->bindValue(':KomponistID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Der Komponist ID: '.$this->ID.', Name: "'.$this->Vorname.' '.$this->Nachname.'"  
            kann nicht gelöscht werden da noch eine Zuordnung auf '.$select->rowCount().' 
            Musikstücke existiert. '); 
      return false;       
    } else {
      return true; 
    }
  }

}

?>
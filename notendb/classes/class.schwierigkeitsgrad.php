<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Schwierigkeitsgrad {

  public $table_name='schwierigkeitsgrad'; 
  public $ID;
  public $Name;
  public $titles_selected_list; 
  public $Title='Schwierigkeitsgrad';
  public $Titles='Schwierigkeitsgrade';  
  public $Parent=''; // Material oder Schueler (Satz nicht)
  public $Ref=''; 
  public string $infotext=''; 
  
  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {

    $insert = $this->db->prepare("INSERT INTO `schwierigkeitsgrad` 
              SET `Name`     = :Name"
           );

    $insert->bindParam(':Name', $Name);

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
 
  function print_select($value_selected=''){


    $query='SELECT ID, Name 
            FROM `schwierigkeitsgrad` ';

    $query.='ORDER BY `Name`'; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      // $html->caption = $this->Title;       
      $html->print_select("SchwierigkeitsgradID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }

  function is_deletable() {
    
    $select = $this->db->prepare("SELECT * from satz_schwierigkeitsgrad WHERE SchwierigkeitsgradID=:SchwierigkeitsgradID");
    $select->bindValue(':SchwierigkeitsgradID', $this->ID); 
    $select->execute();  

    if ($select->rowCount() > 0 ){
      $this->load_row(); 
      $this->info->print_warning('Der Schwierigkeitsgrad ID '.$this->ID.', Name: "'.$this->Name.'" kann nicht gelöscht werden. 
                                 Es existieren '.$select->rowCount().' zugeordnete Sätze.<br>'); 
      return false;       
    } else {
      return true; 
    }
  }

  function print_table(){

    $query="SELECT * from schwierigkeitsgrad ORDER by Name"; 

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

  function update_row($Name) {
    
    $update = $this->db->prepare("UPDATE `schwierigkeitsgrad` 
                            SET
                            `Name`     = :Name
                            WHERE `ID` = :ID"); 
    $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $update->bindParam(':Name', $Name);

    try {
      $update->execute(); 
      $this->load_row();  
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e); 
    }
  }

  function load_row() {

    $select = $this->db->prepare("SELECT `ID`, `Name` 
                          FROM `schwierigkeitsgrad`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      return true; 
    } 
    else {
      return false; 
    }    
  }  
  
  function print_select_multi($options_selected=[]){

    switch($this->Parent) {

      // case 'Material': 
      //     $formInputName='Schwierigkeitsgrad_Material[]'; 
      //     $formInputID='Schwierigkeitsgrad_Material'; 
      //     $caption='Schwierigkeitsgrad Material: '; 
      //   break; 

      case 'Schueler': 
        $formInputName='Schwierigkeitsgrad_Schueler[]'; 
          $formInputID='Schwierigkeitsgrad_Schueler';         
          // $caption='Schwierigkeitsgrad Schüler: ';           
          $caption='Schwierigkeitsgrad: '; // Zusatz verworfen, da Suche- Auswahlfeld in gekennzeichnetem  Bereich angezeigt wird.           
        break; 
    }    

    $query="SELECT ID, Name 
            FROM `schwierigkeitsgrad` 
            order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HTML_Select($stmt); 
      $html->visible_rows=5; 
      $html->print_select_multi( $formInputID, $formInputName, $options_selected,$caption); 
      $this->titles_selected_list = $html->titles_selected_list; 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e); 
    }
  }  

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `schwierigkeitsgrad` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      $this->info->print_info('Der Schwierigkeitsgrad wurde gelöscht.');  
      return true;         
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false;  
    }  
  }   

}

 



?>
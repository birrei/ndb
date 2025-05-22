<?php 
include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 

class UebungTyp {

  public $ID;
  public $Name='';
  public $Einheit=''; // Einheit für uebung.Anzahl z.B. Ausführungen, Minuten, Schritte 

  public $titles_selected_list; 
  public $Title='Übung Typ';
  public $Titles='Übung Typen';  
  public $table_name='uebungtyp'; 

  public string $infotext=''; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {
    $insert = $this->db->prepare("INSERT INTO uebungtyp 
                                  SET `Name`= :Name
                                      , Einheit=''");
          
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

  function load_row() {  

    $select = $this->db->prepare("SELECT ID, Name, Einheit 
                          FROM  uebungtyp 
                          WHERE ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    // echo $select->rowCount(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Name=$row_data["Name"];           
      $this->Einheit=$row_data["Einheit"];           
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function update_row ($Name, $Einheit) {

    $update = $this->db->prepare("UPDATE uebungtyp  
              SET `Name`=:Name, Einheit=:Einheit             
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);    
    $update->bindParam(':Einheit', $Einheit);    

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {  
      $this->info->print_user_error(); 
      $this->info->print_error($update, $e);  ; 
    }
  }  

  function delete(){

    $delete = $this->db->prepare("DELETE FROM `uebungtyp` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      return true;          
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
      return false ; 
    }  
  }   

  function print_select($value_selected=''){

    $query="SELECT ID, Name FROM `uebungtyp` order by `Name`"; 

    $stmt = $this->db->prepare($query); 

    try {
      $stmt->execute(); 
      // $html->caption = $caption;       
      $select=new HTML_Select($stmt); 
      $select->print_select('UebungtypID',$value_selected); 
    }
    catch (PDOException $e) {  
      $this->info->print_user_error(); 
      $this->info->print_error($stmt, $e);  ;
    }
  }


}

 



?>
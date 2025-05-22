<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 

class Uebung {

  public $ID;
  public $Name='';
  public $Bemerkung=''; 
  public $UebungtypID; 
  public $SchuelerID='';
  public $Datum=''; 
  public $Anzahl=''; 
  
  public $Typ=''; 

  public $titles_selected_list; 
  public $Title='Übung';
  public $Titles='Übungen';  
  public $table_name='uebung'; 

  public string $infotext=''; 

  private $db; 
  private $info; 

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function insert_row ($Name) {
    $insert = $this->db->prepare("INSERT INTO `uebung` 
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
                          FROM  uebung left join uebungtyp on uebung.UebungtypID = uebungtyp.ID 
                          WHERE uebung.ID = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    // echo $select->rowCount(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->Name=$row_data["Name"];       
      $this->UebungtypID=$row_data["UebungtypID"];      
      $this->SchuelerID=$row_data["SchuelerID"];        
      $this->Bemerkung=$row_data["Bemerkung"]; 
      $this->Datum=$row_data["Datum"];      
      $this->Anzahl=$row_data["Anzahl"];           
      $this->Typ=$row_data["Typ"];       
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function print_select_typ($value_selected=''){

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

  function update_row ($Name
                    , $Bemerkung
                    , $UebungtypID
                    , $SchuelerID                                                            
                    , $Datum
                    , $Anzahl                                                   
                    ) {

    $update = $this->db->prepare("UPDATE uebung  
              SET UebungtypID= :UebungtypID
                , `Name`=:Name
                , Bemerkung=:Bemerkung 
                , SchuelerID=:SchuelerID 
                , Datum=:Datum               
                , Anzahl=:Anzahl               
              WHERE ID=:ID"           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':Name', $Name);    
    $update->bindParam(':UebungtypID', $UebungtypID, ($UebungtypID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':SchuelerID', $SchuelerID, ($SchuelerID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));
    $update->bindParam(':Bemerkung', $Bemerkung);
    $update->bindParam(':Datum', $Datum);      
    $update->bindParam(':Anzahl', $Anzahl);
  

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

    $delete = $this->db->prepare("DELETE FROM `uebung` WHERE ID=:ID"); 
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

}

 



?>
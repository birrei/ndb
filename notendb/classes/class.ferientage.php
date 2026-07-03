<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 

class Ferientage {

  public $table_name='ferien'; 
  public int $ID;
  public string $Name;
  public string $Datum_Start;
  public string $Datum_Ende;
  public int $SchuljahrID; 


  // public $titles_selected_list; 
  public string $Title='Ferientage';
  public string $infotext=''; 
  
  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }

  function print_table(){

    $query="SELECT * from ferien ORDER by Name"; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      $html = new HTML_Table($select); 
      $html->edit_link_table= $this->table_name;
      $html->print_table2();  

      
    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }

  function update_row($Name) {

    $update = $this->db->prepare("UPDATE `ferien` 
                            SET
                            `Bezeichnung`     = :Name
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

    $select = $this->db->prepare("SELECT ID, Bezeichnung, Datum_Start, Datum_Ende, Bundesland 
                          FROM `ferien` 
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    if ($select->rowCount()==1) {
      $row_data=$select->fetch();      
      $this->Name=$row_data["Name"];    
      $this->Name=$row_data["Datum_Start"];    
      $this->Name=$row_data["Datum_Ende"];    
      $this->Name=$row_data["Bundesland"];    
      return true; 
    } 
    else {
      return false; 
    }
    
  }  

  function delete_ics_data() {
    $delete = $this->db->prepare("DELETE FROM ferien_ics"); 
    try {
      $delete->execute(); 
    }
    catch (PDOException $e) {
      $this->info->print_user_error(); 
      $this->info->print_error($delete, $e);  
    }      
  }

  function insert_ics_data (array $arr_ics_data) {

      // uasort($arr_ics_data_akt, function ($a, $b) {
      //     return $a['start'] <=> $b['start'];
      // });

      foreach ($arr_ics_data as $arr_eintrag) {
          // echo "<pre>";
          // print_r($arr_eintrag);
          // echo "</pre>";
          $start = $arr_eintrag["start"];  
          $end = $arr_eintrag["end"];  
          $title = $arr_eintrag["title"]; 
          $location = $arr_eintrag["location"]; 
          $description =  $arr_eintrag["description"]; 

          // echo '<br>start: '.$start.', end: '.$end.', location: '.$location.', description: '.$description; 

          $insert = $this->db->prepare("INSERT INTO ferien_ics 
                                          SET title = :title
                                            , start = :start 
                                            , end = :end 
                                            , location = :location
                                            , description = :description 
                                            ");
          $insert->bindParam(':title', $title);
          $insert->bindParam(':start', $start);
          $insert->bindParam(':end', $end);
          $insert->bindParam(':location', $location);
          $insert->bindParam(':description', $description);

          try {
            $insert->execute(); 
          }
            catch (PDOException $e) {
            $this->info->print_user_error(); 
            $this->info->print_error($insert, $e);  ; 
          }          

          // $Datum_Start = DateTime::createFromFormat('Ymd', $start)->format('Y-m-d');
          // $Datum_Ende = DateTime::createFromFormat('Ymd', $end)->format('Y-m-d');

          // $Bezeichnung = $title;

          // // prüfen, ob location "BW" enthält  
          // $Bundesland = $location; 
      }
  }  

  function print_table_ics_data(){

    $query="SELECT * from ferien_ics ORDER by start "; 

    $select = $this->db->prepare($query); 

    try {
      $select->execute(); 
      $html = new HTML_Table($select); 
      // $html->edit_link_table= $this->table_name;
      $html->add_link_edit=false; 
      $html->print_table2();  

    }
    catch (PDOException $e) {
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }
  }


}

 



?>
<?php 

class Link {

  public $table_name; 
  public $ID;
  public $Name;
  public $Bezeichnung; 
  public $URL; 
  public $LinktypeID; 
  public $SammlungID; 

  public function __construct(){
    $this->table_name='link'; 
  }

  function insert_row ($LinktypeID, $Bezeichnung, $URL) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $insert = $db->prepare("INSERT INTO `link` 
              SET SammlungID = :SammlungID
              , LinktypeID= :LinktypeID
              , Bezeichnung=:Bezeichnung
              , `URL` = :URL"           
           );

    $insert->bindParam(':SammlungID', $this->SammlungID);
    $insert->bindParam(':LinktypeID', $LinktypeID);
    $insert->bindParam(':Bezeichnung', $Bezeichnung);
    $insert->bindParam(':URL', $URL);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  
  function update_row ($LinktypeID, $Bezeichnung, $URL) {
    include_once("cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    $update = $db->prepare("UPDATE `link` 
              SET 
                LinktypeID= :LinktypeID
              , Bezeichnung=:Bezeichnung
              , `URL` = :URL
              WHERE ID=:ID
              "           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':LinktypeID', $LinktypeID);
    $update->bindParam(':Bezeichnung', $Bezeichnung);
    $update->bindParam(':URL', $URL);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 

  function load_row() {
    include_once("cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                          , COALESCE(Bezeichnung, '') as Bezeichnung
                          , COALESCE(URL, '') as URL
                          , LinktypeID
                          , SammlungID 
                          FROM `link`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 
    $row_data=$select->fetch();
    $this->SammlungID=$row_data["SammlungID"]; 
    $this->LinktypeID=$row_data["LinktypeID"];  
    $this->Bezeichnung=$row_data["Bezeichnung"];
    $this->URL=$row_data["URL"];  
     
       
  }  

  // function print_select($value_selected='',$referenced_SatzID=''){
      
  //   include_once("cl_db.php");  
  //   include_once("cl_html_select.php");

  //   $query="SELECT Lookup.ID
  //           , concat(lookup_type.Name, ': ', lookup.Name) as Besonderheit
  //           FROM lookup 
  //           INNER JOIN lookup_type 
  //           ON lookup_type.ID=lookup.LookupTypeID 
  //           WHERE 1=1 ";

  //   if ($referenced_SatzID!=''){
  //       $query.='AND lookup.ID NOT IN 
  //             (SELECT LookupID FROM satz_lookup 
  //              WHERE SatzID=:SatzID) ';
  //   }

  //   $query.='ORDER BY Besonderheit'; 

  //   $conn = new DbConn(); 
  //   $db=$conn->db; 

  //   $stmt = $db->prepare($query); 

  //   if ($referenced_SatzID!=''){
  //     $stmt->bindParam(':SatzID', $referenced_SatzID);
  //   }  

  //   try {
  //     $stmt->execute(); 
  //     $html = new HtmlSelect($stmt); 
  //     $html->print_select("LookupID", $value_selected, true); 
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }




  // function print_table($LookupTypeID=''){

  //   $query="SELECT * from v_lookup WHERE 1=1 "; 
  //   $query.=($LookupTypeID!=''?"AND LookupTypeID = :LookupTypeID ":"");
  //   $query.="ORDER by Name"; 

  //   include_once("cl_db.php");
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
  //   // echo $query; 
  //   $select = $db->prepare($query); 

  //   if($LookupTypeID!='') {
  //     $select->bindParam(':LookupTypeID', $LookupTypeID);
  //   }    

  //   try {
  //     $select->execute(); 
  //     include_once("cl_html_table.php");      
  //     $html = new HtmlTable($select); 
  //     $html->print_table($this->table_name, true); 
      
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($select, $e); 
  //   }
  // }

  // function update_row($Name, $LookupTypeID) {
  //   include_once("cl_db.php");   
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
    
  //   $update = $db->prepare("UPDATE `lookup` 
  //                           SET Name     = :Name
  //                               , LookupTypeID=:LookupTypeID
  //                           WHERE `ID` = :ID"); 

  //   $update->bindParam(':ID', $this->ID, PDO::PARAM_INT);
  //   $update->bindParam(':Name', $Name);
  //   $update->bindParam(':LookupTypeID', $LookupTypeID);    

  //   try {
  //     $update->execute(); 
  //     $this->load_row(); 
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($stmt, $e); 
  //   }
  // }



  // function print_select_multi($type_key, $options_selected=[]){

  //   include_once("cl_db.php");  
  //   include_once("cl_html_select.php");
    
  //   // $this->ID_List=implode(',', $options_selected); 

  //   $query="SELECT ID, Name from lookup 
  //         WHERE 1=1 
  //         AND LookupTypeID = :LookupTypeID 
  //         ORDER BY Name 
  //         "; 

  //   include_once("cl_db.php");
  //   $conn = new DbConn(); 
  //   $db=$conn->db; 
  //   // echo $query; 
  //   $select = $db->prepare($query); 
  //   $select->bindParam(':LookupTypeID', $this->LookupTypeID);

  //   try {
  //     $select->execute(); 
  //     $html = new HtmlSelect($select); 
  //     $html->print_select_multi($type_key, $type_key.'[]', $options_selected); 
  //   }
  //   catch (PDOException $e) {
  //     include_once("cl_html_info.php"); 
  //     $info = new HtmlInfo();      
  //     $info->print_user_error(); 
  //     $info->print_error($select, $e); 
  //   }
  // }  



}

 



?>
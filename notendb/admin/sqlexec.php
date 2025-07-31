
<?php 

include_once('head.php');
include("../dbconn/cl_db.php"); 
include("../cl_html_info.php"); 
include("../cl_html_table.php");  


if (isset($_POST['abfrage'])) {
     $sql = trim($_POST['abfrage']);
}
else {
    $sql=""; 
}

?>

<form action="" method="post">
    <textarea name="abfrage" id="abfrage" cols="120" rows="10"><?php echo $sql; ?></textarea>
    <input type="hidden" name="aktion" value="ausfuehren">    
    <input class="btnSave" type="submit" value="SQL ausfuehren">
</form>



<?php 
if (isset($_POST['aktion']) and $_POST['aktion']=='ausfuehren') {
    if (isset($_POST['abfrage'])) {

        $sqltext = trim($_POST['abfrage']); 

        $cmds = explode(';', $sqltext);

        $conn = new DbConn(); 
        $db=$conn->db; 
        
        foreach($cmds as $cmd){
          $sql= trim($cmd); 
          if (!empty($sql)) {
            $stmt = $db->prepare($sql); 
            echo '<pre>'.$sql.'</pre>'; 
            try {    
                $stmt->execute(); 
                $html = new HTML_Table($stmt); 
                // $html->edit_link_table= $this->table_name;
                $html->add_link_edit=false; 
                $html->show_row_count=true; 
                $html->print_table2();           
            }
            catch (PDOException $e) {
                $info = new HTML_Info();      
                $info->print_user_error(); 
                $info->print_error($stmt, $e); 
            }
            // echo '<p>/********************************************/<br />';              
          }   
        }        
    }
}


include_once('foot.php');
?>






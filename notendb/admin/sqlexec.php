
<?php 
include('../head_raw.php');
include("../cl_db.php");
include("../cl_html_table.php");  
include("../cl_html_info.php"); 

if (isset($_POST['abfrage'])) {
     $sql = trim($_POST['abfrage']);
}
else {
    $sql=""; 
}

?>
<table> 
<tr>
<td>
    <form action="" method="post">
        <label>SQL: 
            <textarea name="abfrage" id="abfrage" cols="120" rows="20"><?php echo $sql; ?></textarea>
        </label>
        <input type="hidden" name="aktion" value="ausfuehren">    
        <input class="btnSave" type="submit" value="ausfuehren">
    </form>
</td>
</tr>
</table>


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
                echo '<p>'.$stmt->rowCount().' Zeilen betroffen</p>'; 
                if ($stmt->columnCount() > 0 ) {
                    $html = new HtmlTable($stmt); 
                    // $html->edit_link_table= $this->table_name;
                    $html->print_table2(); 
                }           
            }
            catch (PDOException $e) {

                $info = new HtmlInfo();      
                $info->print_user_error(); 
                $info->print_error($stmt, $e); 
            }
            echo '<p>/********************************************/<br />';              
          }   
        }        
    }
}

include('../foot_raw.php');
?>






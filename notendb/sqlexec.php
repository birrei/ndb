
<?php 
include('head.php');
include("cl_db.php");


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
            <textarea name="abfrage" id="abfrage" cols="70" rows="10"><?php echo $sql; ?></textarea>
        </label>
        <input type="hidden" name="aktion" value="ausfuehren">    
        <input type="submit" value="ausfuehren">
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
                    include_once("cl_html_table.php");      
                    $html = new HtmlTable($stmt); 
                    $html->print_table();  
                }           
            }
            catch (PDOException $e) {
                include_once("cl_html_info.php"); 
                $info = new HtmlInfo();      
                $info->print_user_error(); 
                $info->print_error($stmt, $e); 
            }
            echo '<p>/********************************************/<br />';              
          }   
        }        
    }
}

include('foot.php');
?>






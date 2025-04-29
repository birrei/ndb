<?php 
include('../../head_raw.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php"); 

/* 
Script führt die SQL-Commands aus allen *.sql-Dateien (die im gleichen Ordner liegen) aus. 
Eine Datei kan mehrere SQL-Commands enthalten, diese müssen dann durch ein Semikolon ";" getrennt sein. 
*/

?> 

<div style="padding: 50px"> 
<h3>Views installieren</h3>    
<?php 

$dir='.'; 

if ( is_dir ( $dir )){
  if ( $handle = opendir($dir) )
  {
    while (($file = readdir($handle)) !== false)
    {
      if (pathinfo($file)['extension']=='sql') {
        // echo '<p>Datei: '.$file.'</p>'; 

        $sqltext = file_get_contents($file, true);
        $cmds = explode(';', $sqltext);

        $conn = new DbConn(); 
        $db=$conn->db; 

        foreach($cmds as $cmd){
          $sql= trim($cmd); 
          // echo '<p>SQL:<br /><pre>'.$sql.'</pre></p>'; 
          $stmt = $db->prepare($sql); 
          try {    
            $stmt->execute(); 
            echo '<p>Datei '.$file.' wurde erfolgreich ausgeführt.</p>';
          }
          catch (PDOException $e) {
            // include_once("cl_html_info.php"); 
            $info = new HtmlInfo();      
            $info->print_user_error(); 
            $info->print_error($stmt, $e); 
            echo '<br>Datei '.$file.' wurde nicht erfolgreich ausgeführt. SQL:<br/>';
            echo '<pre>'.$sql.'</pre>'; 
          }
          // echo '<p>/********************************************/<br />'; 
        }
      }
    }
    closedir($handle);
  }
}
echo "</div>";

?> 
</div>
<?php 


include('../../foot_raw.php');

?>


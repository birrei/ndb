<?php 
include('head.php');
include("cl_db.php"); 

/* 
Script führt die SQL-Commands aus allen *.sql-Dateien (die im gleichen Ordner liegen) aus. 
Mehrere SQL-Commands in einer Datei müssen durch ein Semikolon ";" getrennt sein. 
*/

$dir='.'; 

if ( is_dir ( $dir )){
  if ( $handle = opendir($dir) )
  {
    while (($file = readdir($handle)) !== false)
    {
      if (pathinfo($file)['extension']=='sql') {
        echo '<p>Datei: '.$file.'</p>'; 

        $sqltext = file_get_contents($file, true);
        $cmds = explode(';', $sqltext);

        $conn = new DbConn(); 
        $db=$conn->db; 

        foreach($cmds as $cmd){
          $sql= trim($cmd); 
          echo '<p>SQL:<br /><pre>'.$sql.'</pre></p>'; 
          $stmt = $db->prepare($sql); 
          try {    
            $stmt->execute(); 
            echo '<p>SQL wurde erfolgreich ausgeführt.</p>';
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
    closedir($handle);
  }
}
echo "</ol>";

include('foot.php');

?>

<?php 

$title_base='Notendatenbank'; 
$title_page=''; 

if (isset($PageTitle)) {
 // Paramter $PageTitle in aufrufender Datei vor den include-Aufruf setzen. Vorlage: dataclearing.php XXX 
  $title_page=$PageTitle; 
} 

if ( isset($_REQUEST["title"]) ){
  $title_page=$_REQUEST["title"]; 
}
if ( isset($_GET["Name"]) ){
  $title_page=$_GET["Name"]; 
}

// echo '$title_page: '.$title_page; 
// echo basename($_SERVER['SCRIPT_FILENAME']); 

if ($title_page=='') 
{
  switch(basename($_SERVER['SCRIPT_FILENAME'])) {
    case 'index.php':
      $title_page='Start'; 
      break; 
    case 'admin.php':
      $title_page='Admin'; 
      break; 
    case 'hilfe.php':
      $title_page='Hilfe'; 
      break; 
    case 'suche.php':
      $title_page='Suche'; 
      break; 
    case 'suche_schueler.php':
        $title_page='Suche Schüler'; 
        break;       
    case 'abfragen.php':
      $title_page='Abfragen'; 
      break; 
    case 'list_tables.php':
      $title_page='Objekte'; 
      break; 
    case 'sqlexec.php':
      $title_page='SQL Query Box'; 
      break;                                                                                       
    case 'test.php':
      $title_page='Test'; 
      break;                                                                                       
    case 'dataclearing.php':
        $title_page='Sammel-Updates'; 
        break;                   
    } 
}

// echo '$title_page: '.$title_page; 

$title_complete=($title_page!=''?$title_page.' - '.$title_base:$title_base); 

// echo '$title_complete: '.$title_complete; 


?> 
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="pragma" content="no-cache">  
  <script src="javascript.js"></script>
  <link rel="icon" type="image/vnd.icon" href="favicon.ico" />
    <title><?php echo $title_complete;  ?></title>
    <link rel='stylesheet' type='text/css' href='style.css'/>
</head>
<body>
    
    
<a href="index.php?title=Start" tabindex="-1">Startseite</a> | 
    <a href="suche.php?title=Suche" tabindex="-1">Suche</a> | 
    <a href="help.php?title=Hilfe" tabindex="-1">Hilfe</a>

<hr>
<?php 

?>


<?php 
?> 

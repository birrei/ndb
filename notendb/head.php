<?php 
 $title_base='Notendatenbank'; 

 $title_page=''; 

if ( isset($_REQUEST["title"]) ){
  $title_page=$_REQUEST["title"]; 
}
if ( isset($_GET["Name"]) ){
  $title_page=$_GET["Name"]; 
}

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
        $title_page='Dataclearing'; 
        break;                   
    } 
}

$title_complete=($title_page!=''?$title_page.' - '.$title_base:$title_base); 


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

    
<a href="index.php?title=Start">Startseite</a> | 
    <a href="suche.php?title=Suche">Suche</a> | 
    <a href="help.php?title=Hilfe">Hilfe</a>    

<hr>
<?php 


?>


<?php 
?> 

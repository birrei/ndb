<?php 
 $title_base='Notendatenbank'; 

 $title_page=''; 

if ( isset($_GET["title"]) ){
  $title_page=$_GET["title"]; 
}
if ( isset($_POST["title"]) ){
  $title_page=$_POST["title"]; 
}
if ( isset($_GET["table"]) ){
  $title_page=$_GET["table"];
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
<?php 
?> 

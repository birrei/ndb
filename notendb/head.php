<?php 
 $title='Notendatenbank'; 

if ( isset($_GET["table"]) ){
  $title=$_GET["table"].' - '.$title; 
}

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

  <link rel="icon" type="image/vnd.icon" href="favicon.ico" />
    <title><?php echo $title;  ?></title>
    <link rel='stylesheet' type='text/css' href='style.css'/>
</head>
<body>
<?php 
?> 

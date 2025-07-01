<?php

include ('cl_sammlung.php'); 

$PageTitle='Sammlung Druck'; 

include('head.php');

$sammlung=new Sammlung(); 
$sammlung->ID= $_GET['ID']; 
$sammlung->print(); 


include('foot.php');
?>

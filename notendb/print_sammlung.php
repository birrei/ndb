<?php

include ('cl_sammlung.php'); 

$PageTitle='Sammlung Druck'; 

include('head.php');

$Ansicht=isset($_GET["Ansicht"])?$_GET["Ansicht"]:'Einfach';

?> <p>
<form action="" method="get">
   Ansicht: <select id="Ansicht" name="Ansicht" onchange="this.form.submit()">
      <option value="Einfach" <?php echo ($Ansicht=='Einfach'?'selected':'');?>>Einfach</option>   
                                         
  </select>
</form>
   </p>

<?php 

$sammlung=new Sammlung(); 
$sammlung->ID= $_GET['ID']; 
$sammlung->print($Ansicht); 



include('foot.php');
?>

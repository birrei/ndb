<?php 

include('head.php');
include('cl_html_info.php');

// $info=new HtmlInfo(); 

// // $info->print_link_edit('komponist',3,'Komponist','',false);


echo '<p>Parameter ID fehlt: <a href="edit_verlag.php?option=edit&title=Verlag">Bearbeiten</a></p>'; 

echo '<p>Leere ID: <a href="edit_verlag.php?ID=&option=edit&title=Verlag">Bearbeiten</a></p>'; 

echo '<p>Nicht existierende ID: <a href="edit_verlag.php?ID=999&option=edit&title=Verlag">Bearbeiten</a></p>'; 



?>

<?php 
include('foot.php');
?>


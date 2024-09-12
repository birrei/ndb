
<?php 
include('head_raw.php');
include("cl_sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  

echo '<table>
     <tr>
     <td>'; 
$sammlung->print_table_links();        
echo '</td>
      <td> <a href="edit_link.php?SammlungID='.$sammlung->ID.'&option=insert" class="form-link">[hinzufügen]</a></td>
     </tr>
    </table>'; 

include('foot_raw.php');
?>

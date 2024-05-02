
<?php 
include('head_raw.php');
include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        $satz->add_uebung($_GET["UebungID"]); 
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_uebung($_GET["ID"]); // ID = satz_uebung.ID 
    } 
}

echo '<table>
     <tr>
     <td>'; 
        $satz->print_table_uebungen(basename(__FILE__)); 
echo '</td>
          <td>
        <a href="edit_satz_add_uebung.php?SatzID='.$satz->ID.'">[hinzufügen]</a>
        </td>
        </tr>
    </table>'; 

include('foot_raw.php');

?>

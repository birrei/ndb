
<?php 
include('head_raw.php');

include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
            $satz->add_schwierigkeitsgrad($_GET["SchwierigkeitsgradID"], $_GET["InstrumentID"]); 
        }
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_schwierigkeitsgrad($_GET["ID"]); // ID = satz_schwierigkeitsgrad.ID 
    } 
}


echo '<table>
     <tr>
     <td>'; 
        $satz->print_table_schwierigkeitsgrade(basename(__FILE__)); 
echo '</td>
          <td>
        <a href="edit_satz_add_schwierigkeitsgrad.php?SatzID='.$satz->ID.'" class="form-link">[hinzufügen]</a>
        </td>
        </tr>
    </table>'; 

include('foot_raw.php');

?>

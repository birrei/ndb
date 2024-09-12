
<?php 
include('head_raw.php');

include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
            $satz->add_erprobt(''); 
        }
    } 
    // if($_GET["option"]=='delete') {
    //     $satz->delete_schwierigkeitsgrad($_GET["ID"]); // ID = satz_schwierigkeitsgrad.ID 
    // } 
}

echo '<table>
     <tr>
      <td>'; 
        // $satz->print_table_erprobte(basename(__FILE__)); 
        $satz->print_table_erprobte(); 
echo '</td>
    <td>
    <a href="edit_satz_erprobt.php?SatzID='.$satz->ID.'&option=insert" class="form-link">[hinzufügen]</a>
    </td>
    </tr>
    </table>'; 

include('foot_raw.php');

?>

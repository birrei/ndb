
<?php 
include('head_raw.php');

include_once("cl_musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["VerwendungszweckID"])) {
        if ($_GET["VerwendungszweckID"]!='') {
         $musikstueck->add_verwendungszweck($_GET["VerwendungszweckID"]); 
        }
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_verwendungszweck($_GET["ID"]); // ID = musikstueck_verwendungszweck.ID 
    } 
}


echo '<table>
     <tr>
     <td>'; 
        $musikstueck->print_table_verwendungszwecke(basename(__FILE__)); 
echo '</td>
          <td>
          <a href="edit_musikstueck_add_verwendungszweck.php?MusikstueckID='.$musikstueck->ID.'" class="form-link">[hinzufügen]</a>
        </td>
        </tr>
    </table>'; 



include('foot_raw.php');

?>

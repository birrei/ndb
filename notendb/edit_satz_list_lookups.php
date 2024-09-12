
<?php 
include('head_raw.php');
include_once("cl_satz.php");
include_once("cl_lookuptype.php");  

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $satz->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_lookup($_GET["ID"]); // ID = satz_lookup.ID 
    } 
}

echo '<table>
     <tr>
     <td>'; 
        $satz->print_table_lookups(basename(__FILE__), 0); // XXX 
echo '</td>
          <td>
        <a href="edit_satz_add_lookup.php?SatzID='.$satz->ID.'" class="form-link">[hinzufügen]</a>'; 

        
echo '</td>
        </tr>
    </table>'; 

include('foot_raw.php');

?>

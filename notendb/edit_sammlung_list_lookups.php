
<?php 
include('head_raw.php');
include_once("cl_sammlung.php");
include_once("cl_lookuptype.php");  

$sammlung=new Sammlung();
$sammlung->ID=$_GET["SammlungID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $sammlung->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $sammlung->delete_lookup($_GET["ID"]); 
    } 
}

echo '<table>
     <tr>
     <td>'; 
        $sammlung->print_table_lookups(basename(__FILE__), 0); // XXX 
echo '</td>
          <td>
        <a href="edit_sammlung_add_lookup.php?SammlungID='.$sammlung->ID.'" class="form-link">[hinzufügen]</a>'; 

        
echo '</td>
        </tr>
    </table>'; 

include('foot_raw.php');

?>

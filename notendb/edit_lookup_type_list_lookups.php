
<?php 
include('head_raw.php');
include_once("cl_lookuptype.php");
include_once("cl_lookup.php");

$lookuptype=new Lookuptype();
$lookuptype->ID=$_GET["LookupTypeID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["LookupTypeID"])) {
        $lookup=new Lookup();
        $lookup->LookupTypeID=$_GET["LookupTypeID"]; 
        $lookup->insert_row($_GET["Name"]); 
    } 
}

$lookuptype->print_table_lookups('edit_lookup_type_edit_lookup.php');


include('foot_raw.php');


?>

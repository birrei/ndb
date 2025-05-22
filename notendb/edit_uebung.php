
<?php 
$PageTitle='Übung'; 
include('head.php');
// include("cl_html_info.php");
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebung.php");
include_once("classes/class.uebungtyp.php");
include_once("cl_schueler.php");


$info= new HTML_Info(); 
$option=$_REQUEST["option"];
$show_data=true; 


switch($option) {

  case 'insert': 
    $uebung = new Uebung();    
    $uebung->insert_row('');
    $option='update'; 
    break; 

  case 'edit': // über "Bearbeiten"-Link
    $uebung = new Uebung();       
    $uebung->ID=$_REQUEST["ID"];
    $uebung->load_row();  
    $option='update';     
    break; 
  
  case 'update': 
    $uebung = new Uebung();       
    $uebung->ID=$_POST["ID"]; 
    $uebung->update_row(
      $_POST["Name"], 
      $_POST["Bemerkung"], 
      $_POST["UebungtypID"], 
      $_POST["SchuelerID"], 
      $_POST["Datum"], 
      $_POST["Anzahl"]
    );  
    break; 

  case 'delete_1': 
    $uebung = new Uebung();       
    $uebung->ID = $_REQUEST["ID"];  
    $uebung->load_row(); 
    $Name=$uebung->Name; 
    $info->print_form_confirm('edit_uebung.php',$uebung->ID,'delete_2','Löschung'); 

    // if($uebung->is_deletable()) {
    //   $info->print_form_confirm('edit_uebung.php',$ID,'delete_2','Löschung'); 
    // } else {
    //   $info->print_warning($uebung->infotext); 
    // }
    $show_data=true;      
    break; 

  case 'delete_2': 
    $uebung = new Uebung();       
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->delete(); 
    $info->print_info($uebung->infotext); 
    $show_data=false; 
    break; 
}

// test
// echo '<pre>
// option: '.$option.' 
// ID: '.$uebung->ID.' 
// Name: '.$uebung->Name.' 
// UebungtypID: '.$uebung->UebungtypID.' 
// SchuelerID: '.$uebung->SchuelerID.' 
// Datum: '.$uebung->Datum.' 
// Anzahl: '.$uebung->Anzahl.' 
// Bemerkung: '.$uebung->Bemerkung.' 
// </pre>'; 


$info->print_screen_header($uebung->Title.' bearbeiten'); 

$info->print_link_table('v_uebung', 'sortcol=Datum&sortorder=DESC', $uebung->Titles,false);


$info->print_form_inline('delete_1',$uebung->ID,$uebung->Title, 'löschen'); 

$info->print_form_inline('copy',$uebung->ID,$uebung->Title, 'kopieren'); 


if (!$show_data) {goto pagefoot;}


echo '</p>
<form action="edit_uebung.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$uebung->ID.'</td>
    </label>
  </tr> 


  <tr>    
  <label>  
  <td class="form-edit form-edit-col1">Uebungtyp:</td>  
  <td class="form-edit form-edit-col2">  
        '; 
        $typ=new UebungTyp(); 
        $typ->print_select($uebung->UebungtypID); 

    echo ' </label>  (XXX)  &nbsp;
      '; 
    // XXX 
      // $info->print_link_edit($uebungtypen->table_name, $uebung->UebungtypID,$uebungtypen->Title, true); 
      // $info->print_link_table($uebungtypen->table_name,'sortcol=Name',$uebungtypen->Titles,true,'');    
      // $info->print_link_insert($uebungtypen->table_name,$uebungtypen->Title,true); 


  echo '</td>
    </tr> 




  <tr>    
  <label>  
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2">  
        '; 
      $schueler = new Schueler(); 
      // $schueler->Ref='Satz'; 
      $schueler->print_select($uebung->SchuelerID); 
       echo ' </label> ';             
      $info->print_link_edit('schueler',$uebung->SchuelerID,true);   
      $info->print_link_table('v_schueler','sortcol=Name',$schueler->Titles,true,'');    
      $info->print_link_insert($schueler->table_name,$schueler->Title,true);

   echo '</td>
    </tr> 




  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($uebung->Name).'" size="40%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     


  <tr>    
    <td class="eingabe2 eingabe2_1">Datum: </td>  
    <td class="eingabe2 eingabe2_2"> <input type="date" name="Datum" value="'.$uebung->Datum.'" oninput="changeBackgroundColor(this)"></td>
  </tr> 

  <tr>    
    <td class="eingabe2 eingabe2_1">Anzahl: </td>  
    <td class="eingabe2 eingabe2_2"> <input type="number" name="Anzahl" value="'.$uebung->Anzahl.'" oninput="changeBackgroundColor(this)"></td>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="'.htmlentities($uebung->Bemerkung).'" size="40%" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     '; 
      
    echo '
      <tr> 
        <td class="form-edit form-edit-col1"></td> 
        <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
        </td>
      </tr> '; 

  ?>


  </table> 
  <input type="hidden" name="option" value="<?php echo $option; ?>"> 
  <input type="hidden" name="ID" value="<?php echo $uebung->ID; ?>">
  </form>
  <br>

<?php 
   
// $info->print_link_delete_row2($uebung->table_name, $uebung->ID,'Uebung'); 

pagefoot: 

include('foot.php');


?>

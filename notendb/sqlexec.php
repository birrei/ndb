
<?php 
include("dbconnect.php");
include('head.php');

if (isset($_POST['abfrage'])) {
     $sql = trim($_POST['abfrage']);
}
else {
    $sql=""; 
}


?>

<table> 
<tr>
<td>
    <form action="" method="post">
        <label>SQL: 
            <textarea name="abfrage" id="abfrage" cols="70" rows="10"><?php echo $sql; ?></textarea>
        </label>
        <input type="hidden" name="aktion" value="ausfuehren">    
        <input type="submit" value="ausfuehren">
    </form>
</td>
</tr>
</table>


<?php 


if (isset($_POST['aktion']) and $_POST['aktion']=='ausfuehren') {
    if (isset($_POST['abfrage'])) {
 
        // $sql=explode(';', $trim($_POST['abfrage']));

        // echo '<p>'.$sql .'</p>';

        if ($res = mysqli_query($db, $sql)) {
            echo '<p>'.$db->affected_rows . ' Zeilen betroffen</p>';
        }

        $sqlstring = strtolower($sql);

        // echo '<p>' . $sqlstring ; 

        if(substr($sqlstring, 0,6)=="select" or substr($sqlstring, 0,4)=="show")
        {
            // echo '$res OK ';
            $data = $res->fetch_all(MYSQLI_ASSOC);
       
            echo '<table>';
            // Display table header
            echo '<thead>';
            echo '<tr>';
            foreach ($res->fetch_fields() as $column) {
                echo '<th>'.htmlspecialchars($column->name).'</th>';
            }
            echo '</tr>';
            echo '</thead>';    

            foreach ($data as $row) {
                echo '<tr>';
                foreach ($row as $cell) {
                    echo '<td>'.htmlspecialchars($cell).'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';

        }
         else {
            // echo '<p>'.$res->field_count.'">No records in the table!</p>';
        }


    }
}

include('foot.php');
?>







<?php 
include("dbconnect.php");
include('head.php');

?>

<table> 
<tr>
<td>
    <form action="" method="post">
        <label>SQL: 
            <textarea name="abfrage" id="abfrage" cols="50" rows="10"></textarea>
        </label>
        <input type="hidden" name="aktion" value="ausfuehren">    
        <input type="submit" value="speichern">
    </form>
</td>
</tr>
</table>


<?php 

if (isset($_POST['aktion']) and $_POST['aktion']=='ausfuehren') {
    $sql = "";
    if (isset($_POST['abfrage'])) {
        $sql = trim($_POST['abfrage']);
        echo '<p>'.$sql .'</p>';

        if ($res = mysqli_query($db, $sql)) {
            echo '<p>'.$db->affected_rows . ' Zeilen betroffen</p>';
        }

        $sqlstring = substr($sql, 0,6); 
        $sqlstring = strtolower($sqlstring);

        // echo '<p>' . $sqlstring ; 

        if($sqlstring=="select" )
        {
            echo '$res OK ';
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
        //  else {
        //     echo '<p>'.$res->field_count.'">No records in the table!</p>';
        // }


    }
}


?>
</body>
</html>






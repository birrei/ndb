<?php 
include("dbconnect.php");
include('head.php');

if (isset($_POST['aktion']) and $_POST['aktion']=='ausfuehren') {
    $sql = "";
    if (isset($_POST['abfrage'])) {
        $sql = trim($_POST['abfrage']);
        echo $sql;

        // $res = mysqli_query($db, $sql);
        // $data = $res->fetch_all(MYSQLI_ASSOC);
                    
        $db->query($sql);
        echo '<p> Abfrage wurde ausgefuehrt, '.$db->affected_rows . ' Zeilen betroffen';

        // INSERT INTO verlag (Name) VALUES("TEST")

    }
}

?>

<table> 
<tr>
<td>
    <form action="" method="post">
        <label>SQL: 
            <textarea name="abfrage" id="abfrage"></textarea>
        </label>
        <input type="hidden" name="aktion" value="ausfuehren">    
        <input type="submit" value="speichern">
    </form>
</td>
</tr>
</table>



<?php
// $db = mysqli_connect("dbmy-rdbng3231-eu-rw-geo.mysql.webhosting-database.com", "dbu3653575", "birweb26343", "dbs8693768");
// $db = mysqli_connect("dbmy-rdbng638-eu-rw-geo.mysql.webhosting-database.com", "dbu1595425", "kuhundschwein6366", "dbs12499392");
$db = mysqli_connect("localhost", "root", "", "test");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
?>

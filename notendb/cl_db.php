<?php

class DbConn {

  // protected $DB_HOST; 
  // protected $DB_NAME; 
  // protected $DB_BENUTZER; 
  // protected $DB_PASSWORT; 
  public $db; 

  function __construct() {
  
    // PHP Fehlermeldungen anzeigen
    error_reporting(E_ALL);
    ini_set('display_errors', true);
  
    // // Zugangsdaten zur Datenbank
    // $this->DB_HOST = "localhost"; // Host-Adresse
    // $this->DB_NAME = "test"; // Datenbankname
    // $this->DB_BENUTZER = "root"; // Benutzername
    // $this->DB_PASSWORT = ""; // Passwort

    $DB_HOST = "localhost"; // Host-Adresse
    $DB_NAME = "test"; // Datenbankname
    $DB_BENUTZER = "root"; // Benutzername
    $DB_PASSWORT = ""; // Passwort
    
    $OPTION = [
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    try {
      $this->db = new PDO(
        "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME,
        $DB_BENUTZER,
        $DB_PASSWORT,
        $OPTION
      );
    } catch (PDOException $e) {
      // Bei einer fehlerhaften Verbindung eine Nachricht ausgeben
      exit("Verbindung fehlgeschlagen! " . $e->getMessage());
    }    
  }
  
}

?>

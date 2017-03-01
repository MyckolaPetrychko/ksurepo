<?php
  namespace ksu\db;

  use \PDO;

  class DbConnection {
    private $pdo;

    public function __construct(){
      require("settings.php");
      $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
      $opt = array(
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      );
      $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public function getPDO(){
      return $this->pdo;
    }

  }

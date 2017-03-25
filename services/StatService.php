<?php
  namespace ksu\controllers;
  require('../services/HomeService.php');
  require('../domain/PieData.php');

  use ksu\db as DbConnection;
  class StatService{

      public function __construct(){
        $this->dbConnection = new DbConnection\DbConnection();
      }

      public function getYearDistribution(){
          $pdo = $this->dbConnection->getPDO();

          $uniqueYearQuery = "select distinct year from repo order by year asc";

          $res = $pdo->query($uniqueYearQuery);

          $year = array();

          while($row = $res->fetch()){
            $year[$row['year']] = 0;
          }

          $yearCountQuery = "select count(id) from repo where year=?";
          $stm = $pdo->prepare($yearCountQuery);
          $countYear = array();
          foreach($year as $key => $value){
              $stm->execute(array($key));
              $row = $stm->fetch();
              $year[$key] = $row['count(id)'];
              array_push($countYear, array($key => $row["count(id)"]));
          }
          return array($countYear);
      }

  }

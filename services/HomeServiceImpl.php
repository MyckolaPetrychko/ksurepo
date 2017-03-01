<?php
  namespace ksu\services\implement;

  require('../services/HomeService.php');
  require('../domain/PieData.php');

  use ksu\services as HomeService;
  use ksu\db as DbConnection;
  use ksu\domain\PieData as domain;

  class HomeServiceImpl implements HomeService\HomeService {

    private $dbConnection;

    public function __construct(){
      $this->dbConnection = new DbConnection\DbConnection();
    }

    /**
    * Return data for setting pie
    * data = { labels: [],
    *         datasets: [{
    *         data: [],
    *         backgroundColor: [],
    *         hoverBackgroundColor: []
    *     }]}
    **/
    function getCountRepo(){
      // Get connection to database
      $pdo = $this->dbConnection->getPDO();

      // Get count of types disertation
      $queryForCountTypeOfRepo = "select * from `allList`";

      $res = $pdo->query($queryForCountTypeOfRepo);

      $pdo->exec('SET NAMES utf8');

      $datas = array();
      $labels = array();
      $backgroundColor = array();
      $hoverBackgroundColor = array();

      while($row = $res->fetch()){
        // Get count for specific type of disertations
        $query1 = "select count(*) as total from repo where type = (select id from `allList` where id = {$row['id']})";
        $res1 = $pdo->query($query1);
        $count = $res1->fetch();
        $datas[$row['name']] = $count["total"];
        $labels[$row['name']] = $row['name'];
        array_push($backgroundColor, "#" . $this->random_color());
        array_push($hoverBackgroundColor, "#" . $this->random_color());
      }
      $p = ($this->utf8ize(array("labels" => $labels, "datasets" => ["data" => $datas,
          "backgroundColor" => $backgroundColor,
        "hoverBackgroundColor" => $hoverBackgroundColor])));
      return ($p);

    }

    /**
    * Return the amount of all disertations
    */
    function getAmountOfRepo($repo, $column, $query){
      // Get connection to database
      $pdo = $this->dbConnection->getPDO();
      $query1 = "select count(id) from `repo`";
      if ($column == "" || $query == ""){
        if ($repo == ""){
          $query1 = "select count(id) from `repo`";
        }else{
          $query1 = "select count(id) from `repo` where type = (select id from allList where name = '$repo')";
        }
      }else{
        if ($repo == ""){
          $query1 = "select count(id) from `repo` where $column like '%$query%'";
        }else{
          $query1 = "select count(id) from `repo`  where type = (select id from allList where name = '$repo') and $column like '%$query%'";
        }
      }

      $res = $pdo->query($query1);

      $row = $res->fetch();

      return $row['count(id)'];
    }

    function getConcretePage($from, $amount, $repo, $column, $query){
        // Get connection to database
        $pdo = $this->dbConnection->getPDO();

        $amountOfRepo = $this->getAmountOfRepo($repo, $column, $query);

        if ($from + $amount > $amountOfRepo){
          $amount = $amountOfRepo - $from;
        }

        // Get $amount disertation starting with $from
        if ($column == "" || $query == ""){
          if ($repo == ""){
            $queryForConcretePage = "select * from `repo` limit $from, $amount";
          }else{
            $queryForConcretePage = "select * from `repo` where type = (select id from allList where name = '$repo') limit $from, $amount";
          }
        }else{
          if ($repo == ""){
            $queryForConcretePage = "select * from `repo` where $column like '%$query%' limit $from, $amount";
          }else{
            $queryForConcretePage = "select * from `repo` where type = (select id from allList where name = '$repo') and $column like '%$query%' limit $from, $amount";
          }
        }
      
        $res = $pdo->query($queryForConcretePage);

        $all = array();

        while($row = $res->fetch()){
            $all[$row['id']] = array($row['author'], $row['title'], $row['speciality'], $row['year'], $row['info'], $row['download'], $row['added'], $row['type']);
        }

        return $all;
    }

    private function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

  }

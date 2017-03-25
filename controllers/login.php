<?php
  namespace ksu\controllers;

/* use \PDO;
  $host = "localhost";
  $db = "ksu_upd";
  $user = "dbuser";
  $pass = "123";
  $charset = "utf8";

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $opt = array(
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  );
  $pdo = new PDO($dsn, $user, $pass, $opt);
  $res = $pdo->query("select * from `repo_nbuv_math`");
  var_dump($res->fetch());
  $admin = 'admin';
  $type = 6;
  $date = date("Y-m-d H:i:s");
  while($s = $res->fetch()){
    $stm = $pdo->prepare("insert into `repo` (id, author, title, speciality, year, info, download, added, type, date)
    values(null, :author, :title, :speciality, :year, :info, :download, (select id from `users` where type = (select id from role where type = :added)), (select id from allList where id = :type), :date)");
    $stm->bindParam(':author', $s['author']);
    $stm->bindParam(':title', $s['title']);
    $stm->bindParam(':speciality', $s['speciality']);
    $stm->bindParam(':year', $s['year']);
    $stm->bindParam(':info', $s['info']);
    $stm->bindParam(':download', $s['download']);
    $stm->bindParam(':added', $admin);
    $stm->bindParam(':type', $type);
    $stm->bindParam(':date',  $date);
    $stm->execute();
  }
  echo 'login';
*/

<?php
  namespace ksu\controllers;
  $res = $pdo->query("select * from `repo_nbuv_math`");
  var_dump($res->fetch());
  $admin = 'admin';
  $type = 3;
  $date = date("Y-m-d H:i:s");
  while($s = $res->fetch()){
    $stm = $pdo->prepare("insert into `repo` (id, author, title, speciality, year, info, download, added, type, date)
    values(null, :author, :title, :speciality, :year, :info, :download, (select id from `admin` where login = :added), (select id from allList where id = :type), :date)");
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

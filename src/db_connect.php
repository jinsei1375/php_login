<?php 

  require_once('db_connect.php');

  $dsn = 'mysql:dbname=yt_dev;host=mysql;port=3306';
  $user = 'root';
  $password = 'root';
  try {
      $dbh = new PDO( $dsn, $user, $password);
      return $dbh;
  } catch (PDOException $e) {
      echo "データベース接続エラー:" . $e->getMessage();
  }
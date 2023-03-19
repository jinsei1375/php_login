<?php 

  require_once('log.php');
  function db_connect() 
  {
    $dns = 'mysql:dbname=yt_dev;host=mysql;port=3306';
    $user = 'root';
    $pass = 'root';
    try { 
      $dbh = new PDO($dns, $user, $pass);
      return $dbh;
    } catch(PDOException $e) {
      print('Error:' . $e->getMessage());
      die();
    }
  }

  function userInsert($request)
  {
    if( empty($request)){
        print('wrong access!');
        return false;
    }
    $pdo = db_connect();

    try{
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $name = !empty($request['name']) ? $request['name'] : '';
        $email = !empty($request['email']) ? $request['email'] : '';
        $password = !empty($request['password']) ? password_hash($request['password'], PASSWORD_DEFAULT) : '';

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        $res = $stmt->execute();
        logToFile($res, __FILE__, __LINE__);
        if ($res == 1) {
          $response = userGetInfo($request);
        }

        $pdo = null;

        return $response;

    }catch(Exception $e){
        return $e;
    }
  }

  function userGetInfo($request)
  {
    if (empty($request)) {
        print('wrong access!');
        return false;
    } 
    try{
        $pdo = db_connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');

        $stmt->bindParam(':email', $request['email'], PDO::PARAM_STR);
        $res = $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($request['password'], $response['password'])) {
            return false;
        }
        $pdo = null;
        return $response;
    }catch(Exception $e){
        logToFile($e, __FILE__, __LINE__);
        return $e;
    }
  }

?>
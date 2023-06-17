<?php 

    function db_connect()
    {
        $dsn = 'mysql:dbname=yt_dev;host=mysql;port=3306';
        $user = 'root';
        $password = 'root';
        try {
            $dbh = new PDO( $dsn, $user, $password);
            return $dbh;
        } catch (PDOException $e) {
            echo "データベース接続エラー:" . $e->getMessage();
        }
    }

    function getUserInfo($request)
    {
        if (empty($request)) {
            print('wrong access!');
            return false;
        } 
        try{
            $pdo = db_connect();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    
            $stmt->bindParam(':email', $request['email']);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!password_verify($request['password'], $response['password'])) {
                return false;
            }
            $pdo = null;
            return $response;
        }catch(Exception $e){
            return $e;
            print('error');
        }
    }
    
    function setSessionUser($user)
    {   
        if (isset($user["email"]) && isset($user["name"])) {
            if(isset($_SESSION)){
                $_SESSION = array();
            }
            
            $_SESSION["id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["is_login"] = 1;
        }
    }
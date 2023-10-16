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
    
    function createOrInsertUserToken($user_id)
    {
        $dbh = db_connect();
        $sql = "SELECT count(*) FROM user_tokens WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $user_token = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user_token['count(*)'] == 1) {
            $sql = 'UPDATE user_tokens SET update_datetime = :update_datetime WHERE user_id = :user_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':update_datetime', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
        } else {
            $sql = 'INSERT INTO user_tokens (user_id, token, update_datetime, created_at, update_at) VALUES (:user_id, :token, :update_datetime, :created_at, :update_at)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':token', bin2hex(random_bytes(32)));
            $stmt->bindValue(':update_datetime', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':created_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':update_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    function updateUserTokenDatetime($user_id)
    {
        
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
    
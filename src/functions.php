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

    //user_tokensにデータ登録 or データ追加
    function createOrInsertUserToken($userId)
    {
        $dbh = db_connect();
        $sql = "SELECT * FROM user_tokens WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        $userToken = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        $token = bin2hex(random_bytes(32));

        if ($count == 1) {
            $sql = 'UPDATE user_tokens SET update_datetime = :update_datetime WHERE user_id = :user_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':update_datetime', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();

            $_SESSION['user_token'] = $userToken['token'];
        } 
        else {
            $sql = 'INSERT INTO user_tokens (user_id, token, update_datetime) VALUES (:user_id, :token, :update_datetime)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':update_datetime', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['user_token'] = $token;
        }

    }
    
    // メールアドレスからユーザー情報取得
    function getUserInfoByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $dbh = db_connect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    function getUserInfoByUserToken($userToken)
    {
        $sql = "SELECT * FROM user_tokens WHERE token = :token";
        $dbh = db_connect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $userToken);
        $stmt->execute();
        $userToken = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userToken;
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
    
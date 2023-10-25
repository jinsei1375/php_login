<?php 
    require_once 'vendor/autoload.php';
    use Carbon\Carbon;  

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
    function insertOrUpdateUserToken($userId)
    {
        $dbh = db_connect();
        $sql = "SELECT * FROM user_tokens WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();
        $user_token = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        $token = bin2hex(random_bytes(32));

        if ($count == 1) {
            $sql = 'UPDATE user_tokens SET update_datetime = :update_datetime WHERE user_id = :user_id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':update_datetime', Carbon::now(), \PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $userId);
            $stmt->execute();

            $_SESSION['user_token'] = $user_token['token'];
        } else {
            $sql = 'INSERT INTO user_tokens (user_id, token, update_datetime) VALUES (:user_id, :token, :update_datetime)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':update_datetime', Carbon::now(), \PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION['user_token'] = $token;
        }
    }

    function insertUser($email)
    {
        // register token生成
        $register_token = bin2hex(random_bytes(32));

        $dbh = db_connect();
        $stmt = $dbh->prepare("INSERT INTO users (email, register_token, register_token_sent_at) VALUES (:email, :register_token, :register_token_sent_at)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':register_token', $register_token, PDO::PARAM_STR);
        $stmt->bindValue(':register_token_sent_at', Carbon::now(), \PDO::PARAM_STR);
        $stmt->execute();

        $url = "http://localhost:8888/register/show_register_form.php?token={$register_token}";
        $subject =  '仮登録が完了しました';
        $body = <<<EOD
            会員登録ありがとうございます！

            24時間以内に下記URLへアクセスし、本登録を完了してください。
            {$url}
            EOD;

        $headers = "From : hoge@hoge.com\n";
        $headers .= "Content-Type : text/plain";

        if(mb_send_mail($email, $subject, $body, $headers)) {
            header('Location: /email_sent.php');
            exit();
        } else {
            exit('メール送信に失敗しました。');
        }
    }
    
    
    function checkUserLoginStatus($token)
    {
        if(!isLogin($token)) {
            header('Location: /login.php');
            exit();
        }
        insertOrUpdateUserToken(getUserByUserToken($token)['id']);
    }
    
    function isLogin($token)
    {
        $effective_time = 1;
        $user_token = getUserTokenByToken($token);
        $now = Carbon::now();
        $expirationDatetime = Carbon::parse($user_token['update_datetime'])->addMinutes($effective_time);
        if ($expirationDatetime->gt($now)) {
            return true;
        }
    }
    
    // ユーザートークンからユーザー情報取得
    function getUserByUserToken($token)
    {
        $user_token = getUserTokenByToken($token);
        $user = getUserById($user_token['user_id']);
        return $user;
    }
    
    // トークンからユーザートークン取得
    function getUserTokenByToken($token)
    {
        $sql = "SELECT * FROM user_tokens WHERE token = :token";
        $dbh = db_connect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $user_token = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user_token;
    }
    
    // メールアドレスからユーザー情報取得
    function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email and status = :status";
        $dbh = db_connect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':status', 1);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        if ($count == 1) {
            return $user;
        }
    }

    // ユーザーIDからユーザー情報取得
    function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id and status = :status";
        $dbh = db_connect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':status', 1);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        if ($count == 1) {
            return $user;
        }
    }
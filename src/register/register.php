<?php
    use Carbon\Carbon;
    require_once('../functions.php');
    session_start();

    $request = filter_input_array(INPUT_POST);

    // csrf tokenが正しいか確認
    if (empty($request['_csrf_token']) 
        || empty($_SESSION['_csrf_token']) 
        || $request['_csrf_token'] !== $_SESSION['_csrf_token']) {
        exit('不正なリクエストです');
    }

    // ユーザー情報取得
    $user = getUserByEmail($request['email']);
    $backUrl = "http://localhost:8888/register/show_register_form.php?token=" . $request['register_token'];
    // todo 既存に登録されているメアド入力されたら通っちゃう
    if (!$user || $user['register_token'] !== $request['register_token']) {
        $_SESSION['error'] = 'メールアドレスが正しくありません。';
        header('Location: ' . $backUrl);
        exit();
    } else {
        // パスワード確認用が一致しているか、8文字以上か確認
        $password = $request['password'];
        $passwordConfirm = $request['passwordConfirm'];
        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = "パスワードが一致しません";
            header('Location: ' . $backUrl);
            exit();
        } elseif (strlen($password) < 8) {
            $_SESSION['error'] =  "パスワードは8文字以上である必要があります";
            header('Location: ' . $backUrl);
            exit();
        } else {
            $sql = 'UPDATE users SET password = :password, register_token_verified_at = :register_token_verified_at, status = :status WHERE register_token = :register_token and email = :email';
            
            // テーブルに登録するパスワードをハッシュ化
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // 仮登録ユーザーを本登録（パスワードを登録し、ステータスを本登録ステータスにする）
            $dbh = db_connect();
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
            $stmt->bindValue(':register_token_verified_at', Carbon::now(), \PDO::PARAM_STR);
            $stmt->bindValue(':status', 1, \PDO::PARAM_STR);
            $stmt->bindValue(':register_token', $user['register_token'], \PDO::PARAM_STR);
            $stmt->bindValue(':email', $user['email'], \PDO::PARAM_STR);
            $stmt->execute();

            if(isset($_SESSION['error'])) {
                unset($_SESSION['error']);
            }
    
            header('Location: ./registered.php');
            exit();
        }
    }

    require_once '../parts/header.php';
    require_once './register_form.php';
    require_once '../parts/footer.php';
?>

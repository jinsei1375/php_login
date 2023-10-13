<?php
require_once('./db_connect.php');
session_start();

$request = filter_input_array(INPUT_POST);

// csrf tokenが正しいか確認
if (
    empty($request['_csrf_token'])
    || empty($_SESSION['_csrf_token'])
    || $request['_csrf_token'] !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

$sql = 'UPDATE users SET password = :password, register_token_verified_at = :register_token_verified_at, status = :status  WHERE register_token = :register_token';

// テーブルに登録するパスワードをハッシュ化
$hashedPassword = password_hash($request['password'], PASSWORD_BCRYPT);

// 仮登録ユーザーを本登録（パスワードを登録し、ステータスを本登録ステータスにする）
$dbh = db_connect();
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
$stmt->bindValue(':register_token_verified_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
$stmt->bindValue(':status', 1, \PDO::PARAM_STR);
$stmt->bindValue(':register_token', $request['register_token'], \PDO::PARAM_STR);
$stmt->execute();


echo '本会員登録が完了しました。';

// ユーザー情報セッションに登録
$sql = "SELECT * FROM users WHERE register_token = :register_token";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':register_token', $request['register_token'], \PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION["id"] = $user["id"];
$_SESSION["email"] = $user["email"];
$_SESSION["name"] = $user["name"];
$_SESSION["is_login"] = 1;
?>
<p>
    <a href="/mypage/index.php">マイページへ</a>
</p>
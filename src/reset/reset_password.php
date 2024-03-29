<?php
session_start();
require_once('../functions.php');

$request = filter_input_array(INPUT_POST);

// csrf tokenが正しければOK
if (
    empty($request['_csrf_token'])
    || empty($_SESSION['_csrf_token'])
    || $request['_csrf_token'] !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

$sql = 'UPDATE users SET password = :password, reset_token_verified_at = :reset_token_verified_at WHERE reset_token = :reset_token';

// テーブルに登録するパスワードをハッシュ化
$hashedPassword = password_hash($request['password'], PASSWORD_BCRYPT);

// 仮登録ユーザーを本登録（パスワードを登録し、ステータスを本登録ステータスにする）
$dbh = db_connect();
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
$stmt->bindValue(':reset_token_verified_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
$stmt->bindValue(':reset_token', $request['reset_token'], \PDO::PARAM_STR);
$stmt->execute();

?>
<p>
    パスワード再設定が完了しました。<br>
    <a href="../login.php">ログインページへ</a>
</p>
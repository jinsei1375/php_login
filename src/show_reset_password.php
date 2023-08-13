<?php
session_start();

require_once('./db_connect.php');

// クエリからreset_tokenを取得
$passwordResetToken = filter_input(INPUT_GET, 'token');

// tokenに合致するユーザーを取得
$sql = 'SELECT * FROM `users` WHERE `reset_token` = :reset_token AND `status` = :status';

// reset_tokenが合致するユーザーを取得
$dbh = db_connect();
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':reset_token', $passwordResetToken, \PDO::PARAM_STR);
$stmt->bindValue(':status', 1, \PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$user) exit('無効なURLです');

// tokenの有効期間を30分
$tokenValidPeriod = (new \DateTime())->modify("-30 minute")->format('Y-m-d H:i:s');

// 30分以上前の場合、有効期限切れにする
if ($user['reset_token_sent_at'] < $tokenValidPeriod) exit('有効期限切れです');

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

require_once './parts/header.php';
require_once './reset_password_form.php';
echo $tokenValidPeriod . '  ' . $user['reset_token_sent_at'];
require_once './parts/footer.php';
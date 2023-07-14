<?php 

  require_once('./db_connect.php');
  // session_start();

  // formに埋め込むcsrf tokenの生成
  if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
  }

  // csrf tokenを取得
  $csrfToken = filter_input(INPUT_POST, '_csrf_token');
  $email = filter_input(INPUT_POST, 'email');


  if(!empty($_POST)) {
    $sql = "select count(id) from users where email=:email";
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count['count(id)'] > 0 ) {
      $error['email'] = 'このメールアドレスはすでに使われています。';
    }
    if(!isset($error)) {
      // $_SESSION['user'] = $_POST;

      // register token生成
      $registerToken = bin2hex(random_bytes(32));

      $dbh = db_connect();
      $stmt = $dbh->prepare("INSERT INTO users (email, register_token, register_token_sent_at) VALUES (:email, :register_token, :register_token_sent_at)");
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':register_token', $registerToken, PDO::PARAM_STR);
      $stmt->bindValue(':register_token_sent_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
      $stmt->execute();

      // URLはご自身の環境に合わせてください
      $url = "http://localhost/show_register_form.php?token={$registerToken}";

      $subject =  '仮登録が完了しました';

      $body = <<<EOD
          会員登録ありがとうございます！

          24時間以内に下記URLへアクセスし、本登録を完了してください。
          {$url}
          EOD;

      $headers = "From : hoge@hoge.com\n";
      $headers .= "Content-Type : text/plain";

      if(mb_send_mail($email, $subject, $body, $headers)) {
        header('Location: email_sent.php');
        exit();
      }

      // header('Location: confirm.php');
      // exit();
    }
  }
?>

<?php 
  // $to = "to@example.com";
  // $subject = "TEST";
  // $message = "This is TEST.\r\nHow are you?";
  // $headers = "From: from@example.com";
  // mail($to, $subject, $message, $headers);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>登録ページ</title>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">TOP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <!-- <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/"></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="/login.php">ログイン</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/tmp_register.php">登録</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="wrapper">
      <h1 class="text-center">仮登録</h1>
      <div class="form-wrap row justify-content-center">
        <form action="tmp_register.php" method="POST" class="p-4 col-6">
          <div class="mb-3">
            <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?php echo (isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''); ?>" required>
            <?php if(!empty($error['email'])): ?>
              <p class="text-danger"><?php echo $error['email']; ?></p>
            <?php endif; ?>
          </div>
          <button type="submit" class="btn btn-primary">仮登録する</button>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
<?php 

  require_once('./db_connect.php');
  session_start();

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
      $_SESSION['user'] = $_POST;
      header('Location: confirm.php');
      exit();
    }
  }



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
              <a class="nav-link" href="/register.php">登録</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="wrapper">
      <h1 class="text-center">登録</h1>
      <div class="form-wrap row justify-content-center">
        <form method="POST" class="p-4 col-6">
          <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?php echo (isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''); ?>" required>
            <?php if(!empty($error['email'])): ?>
              <p class="text-danger"><?php echo $error['email']; ?></p>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo (isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : ''); ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>
          <button type="submit" class="btn btn-primary">確認する</button>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
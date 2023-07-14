<?php 

  require_once('./db_connect.php');
  session_start();

  if(!isset($_SESSION['user'])) {
    header('Location: ./register.php');
    exit();
  }

  if(!empty($_POST['check'])) {
    $hash = password_hash($_SESSION['user']['password'], PASSWORD_DEFAULT);

    $dbh = db_connect();
    $stmt = $dbh->prepare("INSERT INTO users (email, name, password) VALUES (:email, :name, :password)");
    $stmt->bindParam(':email', $_SESSION['user']['email'], PDO::PARAM_STR);
    $stmt->bindParam(':name', $_SESSION['user']['name'], PDO::PARAM_STR);
    $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
    $stmt->execute();

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_SESSION['user']['email']);
    $stmt->execute();
    $user = $stmt->fetch();

    $_SESSION["id"] = $user["id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["is_login"] = 1;
    header('Location: ./mypage/index.php');
    exit();
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
  <title>確認ページ</title>
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
      <h1 class="text-center">登録確認画面</h1>
      <div class="form-wrap row justify-content-center">
        <form method="POST" class="p-4 col-6">
          <input type="hidden" name="check" value="checked">
          <div class="mb-3">
            <p>メールアドレス</p>
            <p><span class="fas fa-angle-double-right"></span><span class="check-info"><?php echo htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES); ?></span></p>
          </div>
          <div class="mb-3">
            <p>ユーザー名</p>
            <p><span class="fas fa-angle-double-right"></span><span class="check-info"><?php echo htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES); ?></span></p>
          </div>
          <a href="./register.php" class="btn btn-outline-dark">変更する</a>
          <!-- <button type="submit" class="btn btn-primary">変更する</button> -->
          <button type="submit" class="btn btn-primary">登録</button>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
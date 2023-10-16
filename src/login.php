<?php 

  require_once('./functions.php');
  session_start();

  if (isset($_POST['email']) && isset($_POST['password'])) {
    $dbh = db_connect();
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo var_dump($user);
    if(!$user) {
      $message = "メールアドレスもしくはパスワードが間違っています";
    } else {
      if (password_verify($_POST['password'], $user['password'])) {
        //DBのユーザー情報をセッションに保存
        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["is_login"] = 1;
        header('Location: ./mypage/index.php');
        exit();
      } else {
        $message = "メールアドレスもしくはパスワードが間違っています";
      }
    }
  }
  require_once './parts/header.php';

?>
  <main>
    <div class="wrapper">
      <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ログイン</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
          </div>
          <form class="lg:w-1/2 md:w-2/3 mx-auto" method="POST">
            <div class="flex-wrap -m-2">
              <!-- <?php
                if(isset($message)) {
              ?> -->
              <p class="text-center"><?php echo $message ?? ''; ?></p>
              <!-- <?
                }
              ?> -->
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                  <input type="email" id="email" name="email" value="<?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : ''); ?>" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                  <input type="password" id="password" name="password" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
              </div>
              <p class="">パスワードをお忘れの方は<a href="./show_forget_password.php" class="text-red-400 hover:opacity-70">こちら</a></p>
              <div class="p-2 w-full mt-4">
                <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">ログイン</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </main>
<?php require_once './parts/footer.php'; ?>
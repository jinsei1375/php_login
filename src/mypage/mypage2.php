<?php 
  require_once '../vendor/autoload.php';
  require_once('../functions.php');
  use Carbon\Carbon;

  session_start();

  // ログイン状態か確認
  checkUserLoginStatus($_SESSION['user_token']);

  $user = getUserByUserToken($_SESSION['user_token']);
  require_once '../parts/header.php';
?>
  <main>
    <div class="wrapper">
      <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ユーザー情報</h1>
            <p>ユーザーID：<?php echo $user['id']; ?></p>
            <p>メールアドレス：<?php echo $user['email']; ?></p>
            <p>本登録日時：<?php echo Carbon::parse($user['register_token_verified_at'])->isoFormat('YYYY/MM/DD HH:mm'); ?></p>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php require_once '../parts/footer.php'; ?>
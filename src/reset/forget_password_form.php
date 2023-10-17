<section class="text-gray-600 body-font relative">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">パスワード再設定</h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">登録しているメールアドレスを入力してください。</p>
    </div>
    <form class="lg:w-1/2 md:w-2/3 mx-auto" method="POST" action="./forget_password.php">
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
          <!-- <?php
          if(isset($message)) {
            ?> -->
            <p class="text-center"><?php echo $message ?? ''; ?></p>
            <!-- <?
              }
            ?> -->
        <div class="p-2 w-full">
          <div class="relative">
            <label for="password" class="leading-7 text-sm text-gray-600">メールアドレス</label>
            <input type="email" id="email" name="email" value="<?php echo (isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''); ?>" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
        </div>
        <div class="p-2 w-full">
          <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">再設定する</button>
        </div>
      </div>
    </form>
  </div>
</section>
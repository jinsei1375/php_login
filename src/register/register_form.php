<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">会員登録</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
        </div>
        <?php
        if(isset($_SESSION['error'])) {
        ?>
            <p class="text-center"><?php echo $_SESSION['error'] ?? ''; ?></p>
        <?php
        }
        ?>
        <form class="lg:w-1/2 md:w-2/3 mx-auto" method="POST" action="./register.php" onsubmit="return confirmPassword()">
            <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
            <input type="hidden" name="register_token" value="<?= $registerToken; ?>">
            <div class="p-2 w-full">
                <div class="relative">
                    <label for="password" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                    <input type="email" id="email" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            </div>
            <div class="p-2 w-full">
                <div class="relative">
                    <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                    <input type="password" id="password" name="password" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            </div>
            <div class="p-2 w-full">
                <div class="relative">
                    <label for="password" class="leading-7 text-sm text-gray-600">パスワード(確認用)</label>
                    <input type="password" id="password" name="passwordConfirm" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            </div>
            <div class="p-2 w-full">
                <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
            </div>
        </div>
        </form>
    </div>
</section>
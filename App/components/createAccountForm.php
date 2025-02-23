<?php
  function createAccountForm($errors , $filledData, $notice) {
?>
  <div class="flex container max-w-xl mx-auto justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-500 mx-6">
      <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
      <?php if ($notice): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
          <?= $notice ?>
        </div>
      <?php endif; ?>
      <form method="POST" action="/auth/register">
        <div class="mb-4">
          <div class="<?= isset($errors['name']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['name'] ?? '') ?></div>
          <input type="text" name="name" placeholder="Full Name" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['name']) ? 'outline outline-red-500 outline-1': ''?>" value="<?= $filledData['name'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <div class="<?= isset($errors['email']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['email'] ?? '') ?></div>
          <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['email']) ? 'outline outline-red-500 outline-1': ''?>" value="<?= $filledData['email'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <div class="<?= isset($errors['city']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['city'] ?? '') ?></div>
          <input type="text" name="city" placeholder="City" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['city']) ? 'outline outline-red-500 outline-1': ''?>" value="<?= $filledData['city'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <div class="<?= isset($errors['state']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['state'] ?? '') ?></div>
          <input type="text" name="state" placeholder="State" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['state']) ? 'outline outline-red-500 outline-1': ''?>" value="<?= $filledData['state'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <div class="<?= isset($errors['password']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['password'] ?? '') ?></div>
          <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['password']) ? 'outline outline-red-500 outline-1': ''?>" />
        </div>
        <div class="mb-4">
          <div class="<?= isset($errors['confirmPassword']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['confirmPassword'] ?? '') ?></div>
          <input type="password" name="confirmPassword" placeholder="Confirm Password" class="w-full px-4 py-2 border rounded focus:outline-none <?= isset($errors['confirmPassword']) ? 'outline outline-red-500 outline-1': ''?>" />
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">
          Register
        </button>

        <p class="mt-4 text-gray-500">
          Already have an account?
          <a class="text-blue-900" href="/auth/login">Login</a>
        </p>
      </form>
    </div>
  </div>

<?php
  }
?>
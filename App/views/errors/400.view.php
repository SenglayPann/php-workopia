<?php
  loadComponent('header');
  loadComponent('navbar');
?>

<?=
  headComp('workopia/ unauthorized/ Errors');
?>
<?=
  navbar();
?>

<section>
<div class="container mx-auto p-4 mt-4">
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">400 Error</div>
    <p class="text-center text-2xl mb-4">
      <?= $message ?? 'Bad Request' ?>
    </p>
    <a href="/auth/login" class="block text-xl text-center">Go back to Login</a>
</div>
</section>
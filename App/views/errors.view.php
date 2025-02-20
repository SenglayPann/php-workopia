<?php
  loadComponent('header');
  loadComponent('navbar');
?>

<?=
  headComp('workopia/ page not found/ Errors');
?>
<?=
  navbar();
?>

<section>
<div class="container mx-auto p-4 mt-4">
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3"><?= $errorCode?> Error</div>
    <p class="text-center text-2xl mb-4">
      <?= $message ?>
    </p>
    <button id="test">test div</button>
</div>
</section>
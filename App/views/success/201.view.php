<?php
  loadComponent('header');
  loadComponent('navbar');
?>

<?= headComp('workopia/success step 1'); ?>
<?= navbar(); ?>

<section>
<div class="container mx-auto p-4 mt-4">
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">
      <i class="fa fa-check-circle text-green-500"></i><?= $message ?>
    </div>
    <a href="/" class="block text-xl text-center">Go back to Homepage</a>
</div>
</section>
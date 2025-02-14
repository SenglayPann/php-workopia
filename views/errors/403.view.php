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
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">404 Error</div>
    <p class="text-center text-2xl mb-4">
      you have no permission to view this page
    </p>
</div>
</section>
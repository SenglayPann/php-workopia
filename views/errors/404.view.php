<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('banner');
  loadComponent('createJobListForm');
  loadComponent('buttom_banner');
  loadComponent('footer');
?>

<?=
  headComp('workopia/ page not found/ Errors');
?>
<?=
  navbar();
?>

<section>
<div class="container mx-auto p-4 mt-4">
    <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">404 Error</div>
    <p class="text-center text-2xl mb-4">
      This page does not exist
    </p>
</div>
</section>
<?php
  loadComponent('header');
  loadComponent('loginForm');
  loadComponent('footer');
?>

<?=
  headComp('workopia/register');
?>

<?=
  loginForm($errors ?? [], $filledData ?? [], $notice ?? null);
?>

<?=
  foot();
?>
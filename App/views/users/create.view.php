<?php
  loadComponent('header');
  loadComponent('createAccountForm');
  loadComponent('footer');
?>

<?=
  headComp('workopia/register');
?>

<?=
  createAccountForm($errors ?? [], $filledData ?? [], $notice ?? null);
?>

<?=
  foot();
?>
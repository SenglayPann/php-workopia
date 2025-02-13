<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('banner');
  loadComponent('createJobListForm');
  loadComponent('buttom_banner');
  loadComponent('footer');
?>

<?=
  headComp('workopia/create-job-listing');
?>
<?=
  navbar();
?>
<?=
  banner();
?>
<?=
  createJobListingForm();
?>
<?=
  bottomBanner();
?>
<?=
  foot();
?>


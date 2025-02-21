<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('banner');
  loadComponent('createJobListForm');
  loadComponent('buttom_banner');
  loadComponent('footer');

  // inspectAndDie($filledData);
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
  createJobListingForm($errors ?? [], $filledData ?? []);
?>
<?=
  bottomBanner();
?>
<?=
  foot();
?>


<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('banner');
  loadComponent('editJobListForm');
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
  editJobListingForm($errors ?? [], $filledData ?? []);
?>
<?=
  bottomBanner();
?>
<?=
  foot();
?>


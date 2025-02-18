<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('banner');
  loadComponent('job_details');
  loadComponent('buttom_banner');
  loadComponent('footer');
  // inspectAsJson($job);
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
  jobDetails($job);
?>

<?=
  bottomBanner();
?>
<?=
  foot();
?>
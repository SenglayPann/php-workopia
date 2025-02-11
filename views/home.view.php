<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('search_area');
  loadComponent('banner');
  loadComponent('job_listing');
  loadComponent('buttom_banner');
  loadComponent('footer');
  require basePath('static_data.php');
?>

<?=
  headComp('workopia');
?>
  <?=
    navbar();
  ?>

  <!-- Showcase -->
  <?=
    searchArea();
  ?>
  
  <!-- Top Banner -->
  <?=
    banner(); 
  ?>

  <!-- Job Listings -->
  <?=
    jobList($jobsData);
  ?>

  <!-- bottom banner  -->
  <?=
    bottomBanner();
  ?>
<?=
  foot();
?>
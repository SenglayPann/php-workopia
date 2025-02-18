<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('search_area');
  loadComponent('banner');
  loadComponent('job_listing');
  loadComponent('see_all_jobs');
  loadComponent('buttom_banner');
  loadComponent('footer');
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
    jobList($listings, $callBack = 'seeAllJobs');
  ?>

  <!-- bottom banner  -->
  <?=
    bottomBanner();
  ?>
<?=
  foot();
?>
<?php
  loadComponent('header');
  loadComponent('navbar');
  loadComponent('search_area');
  loadComponent('banner');
  loadComponent('job_listing');
  loadComponent('see_all_jobs');
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
    jobList($jobsData, $callBack = 'seeAllJobs');
  ?>

  <!-- bottom banner  -->
  <?=
    bottomBanner();
  ?>
<?=
  foot();
?>
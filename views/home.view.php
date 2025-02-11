<?php
  require basePath('components/header.php');
  require basePath('components/navbar.php');
  require basePath('components/search_area.php');
  require basePath('components/banner.php');
  require basePath('components/job_listing.php');
  require basePath('components/buttom_banner.php');
  require basePath('components/footer.php');
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
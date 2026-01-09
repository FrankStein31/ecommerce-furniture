<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="" />
  <title><?= $title ?></title>
  <!-- plugins:css -->
  <?php include('layouts/theme_css.php') ?>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:header -->
    <?php include('layouts/theme_header.php') ?>
    <div class="page-body-wrapper">
      <!-- partial:sidebar -->
      <?php include('layouts/theme_sidebar.php') ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <?php include($content) ?>
        </div>
        <!-- partial:footer -->
        <?php include('layouts/theme_footer.php') ?>
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <?php include('layouts/theme_js.php') ?>
  <script>
    var base_url = "<?= site_url() ?>";
    var site_url = "<?= site_url() ?>";
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  </script>
</body>
</html>


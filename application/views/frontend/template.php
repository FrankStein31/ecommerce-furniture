<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="Anil z" name="author">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
  <meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">
  <title><?= $title ?></title>
   <!-- plugins:css -->
   <?php include('layouts/theme_css.php') ?>
</head>
<body>
  <!-- LOADER -->
  <?php //include('layouts/theme_loader.php') ?>
  <!-- END LOADER -->
  <!-- START HEADER -->
  <?php include('layouts/theme_header.php') ?>
  <!-- END HEADER -->
  <!-- START SECTION BANNER -->
  <?php include('layouts/theme_slider.php') ?>
  <!-- END SECTION BANNER -->
  <!-- END MAIN CONTENT -->
  <div class="main_content">
    <!-- START SECTION CATEGORIES -->
    <?php // include('layouts/theme_kategori.php') ?>
    <!-- END SECTION CATEGORIES -->
    <!-- START SECTION CONTENT -->
    <?php include($content) ?>
    <!-- END SECTION CONTENT -->
  </div>
  <!-- END MAIN CONTENT -->
  <!-- START FOOTER -->
  <?php include('layouts/theme_footer.php') ?>
  <!-- END FOOTER -->
  <!-- plugins:js -->
  <?php include('layouts/theme_js.php') ?>
  <script>
    var site_url = "<?= site_url() ?>";
  </script>
</body>
</html>
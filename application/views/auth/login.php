<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>E-commerce Furniture</title>
  <!-- plugins:css -->
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo--.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendors/feather/feather.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendors/ti-icons/css/themify-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/vertical-layout-light/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/all/sweetalert2/sweetalert2.min.css') ?>">
</head>

<body>
  <div class="container-scroller">
    <div class="page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-4 px-4 px-sm-5" style="border-top: 4px solid #8181c3;">
              <div class="brand-logo text-center">
                <h3 class="text-center">Login</h3>
              </div>
              <p class="font-weight-light mb-0" style="font-size:12pt;">Gunakan username / email dan password Anda untuk masuk ke dalam sistem!</p>
              <form id="form_login" class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password">
                </div>
                <div class="mt-3 mb-4">
                  <button type="submit" class="btn btn-block btn-primary font-weight-medium">Login</button>
                </div>
                <div class="my-3 text-center">
                  <!-- <a href="<?= site_url() ?>" class="auth-link text-black text-right">Home</a> -->
                  <!-- <a href="javascript:;" class="auth-link text-black text-right">Lupa password?</a> -->
                </div>
                <div class="text-center mt-5 font-weight-light" style="font-size:15px;">
                <a href="<?= site_url() ?>" class="auth-link text-black text-right">Home</a> |
                  Belum punya akun? <a href="<?= site_url('Auth/register') ?>" class="text-primary">Register</a>
                </div>
              </form>
            </div>
            <div class="text-center mt-1">
              <span class="text-muted text-sm-left d-block d-sm-inline-block" style="font-size:13px;">Copyright © 2022 Ecommerce Anggita Jaya</span> 
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
  <script src="<?= base_url('assets/all/sweetalert2/sweetalert2.all.min.js') ?>"></script>
  <script>
    var site_url = '<?= site_url() ?>';
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('#form_login').submit(function (event) {
        event.preventDefault();
        $.ajax({
          url: site_url + '/Auth/login',
          method: 'POST',
          dataType: 'json',	
          data: new FormData($('#form_login')[0]),
          async: true,
          processData: false,
          contentType: false,
          success: function (data) {
            if (data.success == true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });

              setTimeout(function(){ 
                  window.location.href = site_url + data.page;
              }, 1000);
            } else {
              Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
            }
          },
          fail: function (event) {
            console.log(event);
          }
      });
		  event.preventDefault();
    });
  </script>
</body>
</html>

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
      <div class="content-wrapper d-flex align-items-center px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-7 mx-auto">
            <div class="auth-form-light text-left py-4 px-4 px-sm-5"
              style="border-top: 4px solid #8181c3; background-color:#fff;">
              <div class="brand-logo text-center">
                <h3 class="text-center">Registrasi Akun</h3>
              </div>
              <hr>
              <!-- Meesage -->
              <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong><br>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
              <?php } ?>
              <form id="form-register" class="pt-3" method="POST">
                <div class="form-group">
                  <label for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="no_telp">No Telepon</label>
                      <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telepon"
                        required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <textarea class="form-control" name="alamat" id="alamat" rows="2" required></textarea>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-group mb-4">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    required>
                </div>
                <hr>
                <div class="mt-3 mb-4 text-right">
                  <button type="submit" class="btn btn-primary font-weight-medium">Daftar</button>
                </div>
                <div class="text-center mt-4 font-weight-light" style="font-size:15px;">
                  Sudah punya akun? <a href="<?= site_url('Auth') ?>" class="text-primary">Login</a>
                </div>
              </form>
            </div>
            <div class="text-center mt-1">
              <span class="text-muted text-sm-left d-block d-sm-inline-block" style="font-size:13px;">Copyright © 2022
                Ecommerce Anggita Jaya</span>
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

  $('#form-register').submit(function(event) {
    event.preventDefault();

    Swal.fire({
      title: "Simpan Registrasi",
      text: "Apakah Anda yakin menyimpan registrasi akun !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3498db',
      cancelButtonColor: '#95a5a6',
      confirmButtonText: 'Simpan',
      cancelButtonText: 'Batal',
      showLoaderOnConfirm: true,
      preConfirm: function() {
        return new Promise(function(resolve) {
          $.ajax({
            url: '<?= site_url() ?>' + '/Auth/daftar_akun',
            method: 'POST',
            dataType: 'json',
            data: new FormData($('#form-register')[0]),
            async: true,
            processData: false,
            contentType: false,
            success: function(data) {
              if (data.success == true) {
                setTimeout(function(){ 
                  swal.hideLoading()
                  location.reload()
                }, 1000);
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: data.message
                });
              }
            },
            fail: function(event) {
              alert(event);
            }
          });
        });
      },
      allowOutsideClick: false
    });
    event.preventDefault();
  });
  </script>
</body>

</html>
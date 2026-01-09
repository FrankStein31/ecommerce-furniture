<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>E-commerce Furniture</title>
  <!-- plugins:css -->
  <!-- SITE TITLE -->
  <!-- Favicon Icon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/logo--.png') ?>">
  <!-- Animation CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/animate.css') ?>">
  <!-- Latest Bootstrap min CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/frontend/bootstrap/css/bootstrap.min.css') ?>">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">
  <!-- Icon Font CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/themify-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/linearicons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/flaticon.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/simple-line-icons.css') ?>">>
  <!-- Style CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/frontend/css/responsive.css') ?>">
</head>

<body>
  <!-- START MAIN CONTENT -->
  <div class="main_content">
    <div class="section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div class="text-center order_complete">
                  <i class="fas fa-check-circle"></i>
                  <div class="heading_s1">
                    <h3>Verifikasi Akun Berhasil</h3>
                  </div>
                  <p>
                    Selamat <?= $user['nama'] ?>, akun Anda telah aktif.
                  </p>
                  <a href="<?= site_url('/Auth') ?>" class="btn btn-fill-out">Kembali Ke Halaman Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Content -->
  <!-- plugins:js -->
  <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
</body>

</html>
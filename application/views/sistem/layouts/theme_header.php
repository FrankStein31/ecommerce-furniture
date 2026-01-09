<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="<?= site_url('/') ?>"><img src="<?= base_url('assets/images/logo---.png') ?>" class="mr-2" alt="logo"/></a>
    <a class="navbar-brand brand-logo-mini" href="<?= site_url('/') ?>"><img src="<?= base_url('assets/images/logo--.png') ?>" alt="logo"/></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">
      <!-- <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="icon-bell mx-0"></i>
          <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="ti-info-alt mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Application Error</h6>
              <p class="font-weight-light small-text mb-0 text-muted">
                Just now
              </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="ti-settings mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Settings</h6>
              <p class="font-weight-light small-text mb-0 text-muted">
                Private message
              </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info">
                <i class="ti-user mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">New user registration</h6>
              <p class="font-weight-light small-text mb-0 text-muted">
                2 days ago
              </p>
            </div>
          </a>
        </div>
      </li> -->
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <?php if($this->session->userdata("auth_foto")!=""){ ?>
            <img src="<?=base_url()?>/<?= $this->session->userdata("auth_foto") ?>" class="image-responsive" alt="">
          <?php }else{ ?>
            <img style="border:1px solid #eee;" src="<?= base_url('assets/images/icons/user.png') ?>" alt="profile"/>
          <?php } ?>
          <span class="ml-1" style="font-size: 13px; font-weight:500; color:#333;"><?= $this->session->userdata("auth_nama_user"); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a href="<?= site_url('Profile') ?>" class="dropdown-item">
            <i class="ti-user text-primary"></i>
            Profile
          </a>
          <a class="dropdown-item" href="javascript:;" onclick="logout()">
            <i class="ti-power-off text-primary"></i>
            Logout
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>
<script>
  function logout() {
    Swal.fire({
        title: 'Keluar dari sistem ?',
        text: "Apakah Anda yakin keluar dari sistem !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    method: 'POST',
                    dataType: 'json',
                    url: '<?= site_url() ?>' + '/Auth/logout',
                    success: function (data) {
                        if (data.success == true) {
                            Swal.fire('Berhasil',data.message,'success');
                            swal.hideLoading()
                            setTimeout(function(){ 
                              window.location.href = '<?= site_url() ?>/' + data.page;
                            }, 1000);
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
                        }
                    },
                    fail: function (e) {
                        alert(e);
                    }
                });
            });
        },
        allowOutsideClick: false
    });
  }
</script>
<style>
.btn-ubah {
  text-transform: uppercase;
  font-size: 13px;
  font-weight: 600;
}

.tab-content {
  margin-top: -1px;
  background: #fff;
  border: 1px solid #c8ced3;
  padding: 12px;
}

/* Profile sidebar */
.profile-sidebar {
  padding: 20px 0 10px 0;
  background: #fff;
}

.profile-userpic img {
  width: 160px;
  height: 160px;
  -webkit-border-radius: 50% !important;
  -moz-border-radius: 50% !important;
  border-radius: 50% !important;
  border: 3px solid #e0d7d7;
  object-position: 50% 7%;
  object-fit: cover;
}

.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}

.profile-usertitle-name {
  color: #5a7391;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}

.profile-usertitle-job {
  text-transform: uppercase;
  color: #5b9bd1;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
}

.profile-userbuttons {
  text-align: center;
}

.profile-userbuttons .btn {
  text-transform: uppercase;
  font-size: 11px;
  font-weight: 600;
  padding: 6px 15px;
  margin-right: 5px;
}

.profile-userbuttons .btn:last-child {
  margin-right: 0px;
}

.profile-content {
  padding: 20px;
  background: #fff;
  min-height: 460px;
}

.nav-tabs .nav-link.active {
  color: #2f353a;
  background: #fff;
  border-color: #c8ced3;
  border-bottom-color: #fff;
}
</style>
<input type="hidden" name="id_user" id="id_user" value="<?= $this->session->userdata('auth_id_user'); ?>">
<div class="row">
  <div class="col-md-3">
    <div class="profile-sidebar card">
      <div class="profile-userpic">
        <center>
          <?php if($user['foto']!=""){ ?>
          <img src="<?=base_url()?>/<?= $user['foto'] ?>" class="image-responsive" alt="">
          <?php }else{ ?>
          <img src="<?=base_url()?>assets/images/icons/user.png" class="image-responsive" alt="">
          <?php } ?>
        </center>
      </div>
      <div class="profile-usertitle">
        <div class="profile-usertitle-name">
          <?= $user['nama'] ?>
        </div>
        <div class="profile-usertitle-job">
          <?=$this->session->userdata('auth_nama_role');?>
        </div>
      </div>
      <div class="profile-userbuttons">
        <a href="javascript:;" onclick="openModalFoto()" title="Ubah Foto" id="btn-ubah-foto"
          class="btn btn-success btn-sm"> <i class="fa fa-camera"></i> &nbsp; Ubah Foto</a>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        <span> <i class="fa fa-align-justify"></i> <strong>Profile</strong> </span>
      </div>
      <div class="card-body">
        <!--  -->
        <div class="mb-4">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item nav-tabs-item">
              <a class="nav-link nav-tabs-link active show" data-toggle="tab" href="#tab_profile" role="tab"
                aria-controls="home" aria-selected="true">
                <i class="fa fa-address-card"></i> Data User
              </a>
            </li>
            <li class="nav-item nav-tabs-item">
              <a class="nav-link nav-tabs-link" data-toggle="tab" href="#tab_ubah_password" role="tab"
                aria-controls="messages" aria-selected="false">
                <i class="fa fa-key"></i> Ubah Password</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active show" id="tab_profile" role="tabpanel">
              <!-- form Profile -->
              <form action="" id="form-profile">
                <div class="form-group">
                  <label class="control-label col-md-3">Nama User</label>
                  <div class="col-md-12">
                    <input type="text" id="nama_user" name="nama_user" class="form-control"
                      placeholder="Masukkan Nama User . . . " autocomplete="off"
                      value="<?= $user['nama'] ?>" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </form>
              <!-- end form Profile -->
            </div>
            <div class="tab-pane" id="tab_ubah_password" role="tabpanel">
              <!-- form ubah password -->
              <form action="" id="form-password">
                <div class="form-group">
                  <label class="control-label col-md-3">Password Baru</label>
                  <div class="col-md-12">
                    <input type="password" id="password" name="password" class="form-control"
                      placeholder="Masukkan Password Baru" autocomplete="off" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Ulang Password Baru</label>
                  <div class="col-md-12">
                    <input type="password" id="konfirm_password" name="konfirm_password" class="form-control"
                      placeholder="Masukkan Ulang Password Baru" autocomplete="off" onkeyup="validate_password()"
                      required>
                    <span id="pass-message" style=""></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  <button class="btn btn-primary" id="submit-reset" type="submit">Simpan</button>
                </div>
              </form>
              <!-- end form ubah password -->
            </div>
          </div>
        </div>
        <!--  -->
      </div>
    </div>
  </div>
</div>

<!-- Modal Foto -->
<div class="modal fade" id="modal-foto" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-foto" action="" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">Foto</label>
            <input type="file" class="form-control" id="upload_foto" name="upload_foto" accept="image/*" placeholder=""
              required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="div_modal"></div>
<script>
function openModalFoto() {
  $('#modal-foto').modal('show');
}

$('#form-password').submit(function(event) {
  event.preventDefault();
  var id_user = $('#id_user').val();
  var formData = new FormData($('#form-password')[0])
  formData.append('id_user', id_user);

  Swal.fire({
    title: 'Ubah Password',
    text: "Apakah Anda yakin mengubah password !",
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
          url: '<?= site_url() ?>' + '/Profile/update_password',
          method: 'POST',
          dataType: 'json',
          data: formData,
          async: true,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.success == true) {
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

              Toast.fire({
                icon: 'success',
                title: data.message
              })
              swal.hideLoading()
              setTimeout(function() {
                location.reload();
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

$('#form-profile').submit(function(event) {
  event.preventDefault();
  var id_user = $('#id_user').val();
  var formData = new FormData($('#form-profile')[0])
  formData.append('id_user', id_user);

  Swal.fire({
    title: 'Ubah Profile',
    text: "Apakah Anda yakin mengubah profile !",
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
          url: '<?= site_url() ?>' + '/Profile/update_profile',
          method: 'POST',
          dataType: 'json',
          data: formData,
          async: true,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.success == true) {
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

              Toast.fire({
                icon: 'success',
                title: data.message
              })
              swal.hideLoading()
              setTimeout(function() {
                location.reload();
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

$('#form-foto').submit(function(event) {
  event.preventDefault();
  var id_user = $('#id_user').val();
  var formData = new FormData($('#form-foto')[0])
  formData.append('id_user', id_user);

  $.ajax({
    url: '<?= site_url() ?>' + '/Profile/simpan_foto',
    method: 'POST',
    dataType: 'json',
    data: formData,
    async: true,
    processData: false,
    contentType: false,
    success: function(data) {
      if (data.success == true) {
        Toast.fire({
          icon: 'success',
          title: data.message
        });
        $('#modal-foto').modal('hide');
        swal.hideLoading();
        setTimeout(function() {
          location.reload();
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

function validate_password() {
  var pass = $('#password').val();
  var confirm_pass = $('#konfirm_password').val();
  if (pass != confirm_pass) {
    $('#pass-message').show();
    $('#pass-message').text('Password tidak cocok !');
    $('#pass-message').css('color', 'red');
    $('#submit-reset').prop('disabled', true);
  } else {
    $('#pass-message').hide();
    $('#pass-message').text('');
    $('#pass-message').css('color', 'white');
    $('#submit-reset').prop('disabled', false);
  }
}
</script>
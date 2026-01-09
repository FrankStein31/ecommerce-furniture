<!-- START MAIN CONTENT -->
<style>
  .tab-profile .nav-link.active {
    background: #dedede !important;
  }

  /* Service Tracking Styles */
  .tracking-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
  }

  .tracking-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
  }

  .status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
  }

  .status-diterima {
    background: #e3f2fd;
    color: #1976d2;
  }

  .status-inspeksi {
    background: #fff3e0;
    color: #f57c00;
  }

  .status-konfirmasi {
    background: #f3e5f5;
    color: #7b1fa2;
  }

  .status-pengerjaan {
    background: #e8f5e8;
    color: #388e3c;
  }

  .status-siap {
    background: #e0f2f1;
    color: #00796b;
  }

  .status-selesai {
    background: #e8f5e8;
    color: #2e7d32;
  }

  .timeline {
    position: relative;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
  }

  .timeline .d-flex {
    position: relative;
    z-index: 1;
  }

  .progress {
    border-radius: 10px;
  }

  .btn-track-now {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
  }

  .btn-track-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: white;
  }
</style>
<hr>
<input type="hidden" name="id_user" id="id_user" value="<?= $this->session->userdata('auth_id_user'); ?>">
<div class="main_content">
  <div class="section" style="padding: 30px 0 !important;">
    <div style="padding:0px 40px;">
      <div class="row">
        <div class="col-lg-3 col-md-4">
          <div class="dashboard_menu">
            <ul class="nav nav-tabs flex-column" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab"
                  aria-controls="dashboard" aria-selected="false"><i class="ti-layout-grid2"></i>Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders"
                  aria-selected="false"><i class="ti-shopping-cart-full"></i>Orders</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="service-track-tab" data-toggle="tab" href="#service-track" role="tab" aria-controls="service-track"
                  aria-selected="false"><i class="ti-search"></i>Lacak Layanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
                  aria-controls="address" aria-selected="true"><i class="ti-location-pin"></i>Alamat</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="account-detail-tab" data-toggle="tab" href="#account-detail" role="tab"
                  aria-controls="account-detail" aria-selected="true"><i class="ti-id-badge"></i>Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:;" onclick="logout()"><i class="ti-lock"></i>Logout</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-9 col-md-8">
          <div class="tab-content dashboard_content">
            <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
              <div class="card">
                <div class="card-header">
                  <h3>Dashboard</h3>
                </div>
                <div class="card-body">
                  <h3 class="font-weight-bold">Hallo <?= $this->session->userdata("auth_nama_user"); ?></h3>
                  <h6 class="font-weight-normal mb-0">Selamat datang di aplikasi E-Commerce Mebel Anggita Jaya.</span>
                  </h6>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
              <div class="card">
                <div class="card-header">
                  <h3>Orders</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Order</th>
                          <th>Tanggal</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($order) > 0) {
                          foreach ($order as $row) { ?>
                            <tr>
                              <td>#<?= $row->no_invoice ?></td>
                              <td><?= $row->tanggal ?></td>
                              <td><?= rupiah($row->total) ?></td>
                              <td><?= $row->nama_status ?></td>
                              <td class="text-center">
                                <?php if ($row->status == '1' && $row->tanggal_upload == "") { ?>
                                  <!-- Upload bukti bayar -->
                                  <a href="<?= site_url('Order/order_complete?id_order=' . $row->id) ?>" style="color:#fff;" class="btn btn-warning btn-sm">Upload Bukti</a>
                                <?php } else if ($row->status == '3') { ?>
                                  <!-- Dikirim -->
                                  <a href="<?= site_url('Rating/penilaian/' . $row->id) ?>" style="color:#fff;" class="btn btn-warning btn-sm">Terima</a>
                                <?php } ?>
                                <a href="<?= site_url('Order/order_detail/' . $row->id) ?>" class="btn btn-fill-out btn-sm">Lihat</a>
                              </td>
                            </tr>
                          <?php  }
                        } else { ?>
                          <tr>
                            <td colspan="5">Pesanan tidak ditemukan !</td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="service-track" role="tabpanel" aria-labelledby="service-track-tab">
              <div class="card">
                <div class="card-header">
                  <h3>Lacak Layanan Perbaikan</h3>
                </div>
                <div class="card-body">
                  <!-- Quick Track Form -->
                  <div class="row mb-4">
                    <div class="col-md-8">
                      <input type="text" id="quick-track-input" class="form-control"
                        placeholder="Masukkan Order ID (contoh: ORD-20250830-1234)">
                    </div>
                    <div class="col-md-4">
                      <button onclick="quickTrackOrder()" class="btn btn-track-now w-100">
                        <i class="ti-search"></i> Lacak Sekarang
                      </button>
                    </div>
                  </div>

                  <!-- My Service Orders -->
                  <hr>
                  <h5 class="mb-3">Riwayat Layanan Saya</h5>
                  <div id="service-orders-list">
                    <!-- Content will be loaded dynamically -->
                  </div>

                  <!-- Order Status Modal -->
                  <div class="modal fade" id="trackingModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Status Pesanan Layanan</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="trackingModalBody">
                          <!-- Content will be loaded here -->
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <a id="fullTrackingLink" href="#" target="_blank" class="btn btn-primary">
                            <i class="ti-external-link"></i> Buka Halaman Tracking
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
              <!-- Alamat -->
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-6">
                      <h3>Alamat</h3>
                    </div>
                    <div class="col-md-6 text-right">
                      <a class="btn btn-sm btn-primary" id="btn-add-alamat" href="javascript:;">Tambah</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div id="list-alamat"></div>
                </div>
              </div>
              <!-- End Alamat -->
            </div>
            <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
              <!-- Profile -->
              <div class="card">
                <div class="card-header">
                  <h3>Profile</h3>
                </div>
                <div class="card-body">
                  <!--  -->
                  <div class="mb-4">
                    <ul class="nav nav-tabs tab-profile" role="tablist">
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
                                placeholder="Masukkan Nama User . . . " autocomplete="off" value="<?= $user['nama'] ?>"
                                required>
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
                                placeholder="Masukkan Ulang Password Baru" autocomplete="off"
                                onkeyup="validate_password()" required>
                              <span id="pass-message"></span>
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
              <!-- End Profile -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="div_modal"></div>
<script>
  $(document).ready(function() {
    getAlamat();
    getServiceOrders();
  })

  /**
   * Function Alamat
   * 
   */
  function getAlamat() {
    $.ajax({
      url: "<?= site_url() ?>" + "/Account/get_alamat",
      type: 'GET',
      dataType: 'html',
      data: {},
      beforeSend: function() {},
      success: function(result) {
        $('#list-alamat').html(result);
      }
    });
  }

  /**
   * Function Service Orders
   */
  function getServiceOrders() {
    $.ajax({
      url: "<?= site_url() ?>" + "/Account/get_service_orders",
      type: 'GET',
      dataType: 'html',
      data: {},
      beforeSend: function() {
        $('#service-orders-list').html(`
          <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Memuat riwayat layanan...</p>
          </div>
        `);
      },
      success: function(result) {
        $('#service-orders-list').html(result);
      },
      error: function() {
        $('#service-orders-list').html(`
          <div class="text-center py-4">
            <i class="ti-alert" style="font-size: 48px; color: #f39c12;"></i>
            <p class="text-muted mt-2">Gagal memuat riwayat layanan</p>
            <button onclick="getServiceOrders()" class="btn btn-outline-primary btn-sm">
              <i class="ti-reload"></i> Coba Lagi
            </button>
          </div>
        `);
      }
    });
  }

  // Refresh service orders when tab is clicked
  $('#service-track-tab').on('click', function() {
    getServiceOrders();
  });

  $('#btn-add-alamat').on('click', function() {
    $.ajax({
      url: "<?= site_url() ?>" + "/Account/load_modal_alamat",
      type: 'POST',
      data: {},
      dataType: 'html',
      beforeSend: function() {},
      success: function(result) {
        $('#div_modal').html(result);
        $('#modalTitleAdd').show();
        $('#modeform').val('ADD');
        $('#modal-alamat').modal('show');
      }
    });
  });

  $(document).on('click', '.btn-edit-alamat', function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
      url: "<?= site_url() ?>" + "/Account/load_modal_alamat",
      type: 'POST',
      dataType: 'html',
      data: {
        id: id
      },
      beforeSend: function() {},
      success: function(result) {
        $('#div_modal').html(result);
        $('#modalTitleEdit').show();
        $('#modeform').val('UPDATE');
        $('#modal-alamat').modal('show');
      }
    });
  });

  $(document).on('click', '.btn-delete-alamat', function(e) {
    var id = $(this).attr('data-id');
    var title = $(this).attr('data-name');
    var page = $('#hidden_page').val();

    Swal.fire({
      title: 'Hapus Alamat',
      text: "Apakah Anda yakin menghapus alamat ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#95a5a6',
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      showLoaderOnConfirm: true,
      preConfirm: function() {
        return new Promise(function(resolve) {
          $.ajax({
            method: 'GET',
            dataType: 'json',
            url: "<?= site_url() ?>" + "/Account/delete_alamat/" + id,
            data: {},
            success: function(data) {
              if (data.success === true) {
                $('#modal-alamat').modal('hide');
                Toast.fire({
                  icon: 'success',
                  title: data.message
                });
                swal.hideLoading()
                getAlamat();
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: data.message
                });
              }
            },
            fail: function(e) {
              alert(e);
            }
          });
        });
      },
      allowOutsideClick: false
    });
    e.preventDefault();
  });

  $(document).on('submit', '#form-alamat', function(event) {
    event.preventDefault();
    var modeform = $('#modeform').val();
    var page = (modeform == 'UPDATE') ? $('#hidden_page').val() : 1;
    $.ajax({
      url: "<?= site_url() ?>" + "/Account/save_alamat",
      method: 'POST',
      dataType: 'json',
      data: new FormData($('#form-alamat')[0]),
      async: true,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.success == true) {
          Toast.fire({
            icon: 'success',
            title: data.message
          });
          $('#modal-alamat').modal('hide');
          getAlamat();
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

  /**
   * Function Profile
   * 
   */

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

  /**
   * Service Tracking Functions
   */
  function quickTrackOrder() {
    var orderId = $('#quick-track-input').val().trim();

    if (orderId === '') {
      Toast.fire({
        icon: 'warning',
        title: 'Silakan masukkan Order ID'
      });
      return;
    }

    // Show loading
    $('#trackingModalBody').html(`
      <div class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2">Mencari pesanan...</p>
      </div>
    `);

    $('#trackingModal').modal('show');

    // AJAX call to track order
    $.ajax({
      url: "<?= site_url('Home/api_track_order') ?>",
      type: 'POST',
      dataType: 'json',
      data: {
        order_id: orderId
      },
      success: function(response) {
        if (response.status === 'success') {
          displayTrackingResult(response.data);
          $('#fullTrackingLink').attr('href', "<?= site_url('track/') ?>" + orderId);
        } else {
          $('#trackingModalBody').html(`
            <div class="text-center py-4">
              <i class="ti-close" style="font-size: 48px; color: #e74c3c;"></i>
              <h5 class="mt-2">Pesanan Tidak Ditemukan</h5>
              <p class="text-muted">${response.message}</p>
            </div>
          `);
        }
      },
      error: function() {
        $('#trackingModalBody').html(`
          <div class="text-center py-4">
            <i class="ti-alert" style="font-size: 48px; color: #f39c12;"></i>
            <h5 class="mt-2">Koneksi Bermasalah</h5>
            <p class="text-muted">Silakan coba lagi nanti</p>
          </div>
        `);
      }
    });
  }

  function displayTrackingResult(orderData) {
    var serviceTypes = {
      'jok-motor': 'Perbaikan Jok Motor',
      'jok-mobil': 'Perbaikan Jok Mobil',
      'kursi-rumah': 'Perbaikan Kursi Rumah Tangga',
      'spring-bed': 'Perbaikan/Pemesanan Spring Bed'
    };

    var serviceMethods = {
      'antar-lokasi': 'Antar ke Lokasi Workshop',
      'antar-jemput': 'Layanan Antar & Jemput'
    };

    var statusOrder = [
      'pesanan_diterima',
      'inspeksi',
      'konfirmasi_biaya',
      'pengerjaan',
      'siap_diambil',
      'selesai'
    ];

    var statusNames = {
      'pesanan_diterima': 'Pesanan Diterima',
      'inspeksi': 'Inspeksi',
      'konfirmasi_biaya': 'Konfirmasi Biaya',
      'pengerjaan': 'Proses Pengerjaan',
      'siap_diambil': 'Siap Diambil',
      'selesai': 'Selesai'
    };

    var currentIndex = statusOrder.indexOf(orderData.status);
    var progressPercentage = ((currentIndex + 1) / statusOrder.length) * 100;

    var timelineHtml = '';
    statusOrder.forEach(function(status, index) {
      var isActive = index === currentIndex;
      var isCompleted = index < currentIndex;
      var statusClass = isCompleted ? 'text-success' : (isActive ? 'text-primary' : 'text-muted');
      var iconClass = isCompleted ? 'ti-check' : (isActive ? 'ti-time' : 'ti-circle-o');

      timelineHtml += `
        <div class="d-flex align-items-center mb-3">
          <div class="mr-3">
            <i class="${iconClass} ${statusClass}" style="font-size: 20px;"></i>
          </div>
          <div>
            <h6 class="mb-0 ${statusClass}">${statusNames[status]}</h6>
            <small class="text-muted">
              ${isCompleted ? 'Selesai' : (isActive ? 'Sedang Proses' : 'Menunggu')}
            </small>
          </div>
        </div>
      `;
    });

    var html = `
      <div class="row">
        <div class="col-md-6">
          <h6>Detail Pesanan</h6>
          <table class="table table-sm">
            <tr>
              <td width="40%">Order ID:</td>
              <td><strong>${orderData.order_id}</strong></td>
            </tr>
            <tr>
              <td>Nama:</td>
              <td>${orderData.customer_name}</td>
            </tr>
            <tr>
              <td>Layanan:</td>
              <td>${serviceTypes[orderData.service_type] || orderData.service_type}</td>
            </tr>
            <tr>
              <td>Metode:</td>
              <td>${serviceMethods[orderData.service_method] || orderData.service_method}</td>
            </tr>
            <tr>
              <td>Tanggal:</td>
              <td>${orderData.service_date} ${orderData.service_time}</td>
            </tr>
            <tr>
              <td>Estimasi:</td>
              <td>${orderData.estimated_cost || 'Belum ditentukan'}</td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <h6>Progress Status</h6>
          <div class="progress mb-3" style="height: 10px;">
            <div class="progress-bar bg-primary" role="progressbar" 
                 style="width: ${progressPercentage}%" aria-valuenow="${progressPercentage}" 
                 aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="timeline">
            ${timelineHtml}
          </div>
        </div>
      </div>
    `;

    $('#trackingModalBody').html(html);
  }

  // Allow Enter key for quick search
  $('#quick-track-input').on('keypress', function(e) {
    if (e.which === 13) {
      quickTrackOrder();
    }
  });
</script>
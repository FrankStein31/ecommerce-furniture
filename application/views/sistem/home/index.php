<?php $role = $this->session->userdata("auth_id_role"); ?>
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="row">
      <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Hallo <?= $this->session->userdata("auth_nama_user"); ?></h3>
        <h6 class="font-weight-normal mb-0">Selamat datang di aplikasi E-Commerce Furniture.</span></h6>
      </div>
      <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
          <!-- <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
              <a class="dropdown-item" href="#">January - March</a>
              <a class="dropdown-item" href="#">March - June</a>
              <a class="dropdown-item" href="#">June - August</a>
              <a class="dropdown-item" href="#">August - November</a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<?php if($role=='ADMIN' || $role=='OWNER'){ ?>
  <div class="row">
    <div class="col-md-3 mb-4 stretch-card transparent">
      <div class="card card-tale">
        <div class="card-body">
          <p class="mb-0">Total Pesanan</p>
          <p class="fs-30 mb-0"><?= $dashboard['total_pesanan'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
      <div class="card card-dark-blue">
        <div class="card-body">
          <p class="mb-0">Pesanan Selesai</p>
          <p class="fs-30 mb-0"><?= $dashboard['pesanan_selesai'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4 mb-lg-0 stretch-card transparent">
      <div class="card card-light-blue">
        <div class="card-body">
          <p class="mb-0">Total Produk</p>
          <p class="fs-30 mb-0"><?= $dashboard['total_produk'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3 stretch-card transparent">
      <div class="card card-light-danger">
        <div class="card-body">
          <p class="mb-0">Total Pelanggan</p>
          <p class="fs-30 mb-0"><?= $dashboard['total_pelanggan'] ?></p>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
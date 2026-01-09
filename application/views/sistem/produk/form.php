<style>
.img-produk {
  border: 1px solid #dedede;
  height: 140px;
  width: 140px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.img-produk-plus {
  border: 2px dotted #dedede;
  height: 140px;
  width: 140px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.img-produk img {
  width: 100%;
  height: 138px;
  object-fit: cover;
}

.img-icon-delete {
  position: absolute;
  padding-left: 2px;
  color: #333;
  font-size: 14pt;
}
</style>
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Tambah Produk</span>
      </div>
      <div class="card-body">
        <form id="formData">
          <input type="hidden" name="id" id="id" value="<?= (isset($data)) ?  $data['id'] : '' ?>">
          <input type="hidden" name="modeform" id="modeform" value="<?= $modeform ?>">
          <div class="row mb-2">
            <label for="kode" class="col-sm-2 col-form-label">Kode Produk</label>
            <div class="col-sm-4">
              <input type="text" class="form-control form-control" name="kode" id="kode"
                value="<?= (isset($data)) ?  $data['kode'] : $kode ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
              <input type="text" class="form-control form-control" name="nama" id="nama"
                value="<?= (isset($data)) ?  $data['nama'] : '' ?>" required>
            </div>
          </div>
          <div class="row mb-2">
            <label for="id_jenis" class="col-sm-2 col-form-label">Jenis Produk</label>
            <div class="col-sm-5">
              <select class="form-control form-control" name="id_jenis" id="id_jenis" required>
                <option value="">Pilih Jenis</option>
                <?php foreach ($jenis as $j){ ?>
                <option <?php 
                      if(isset($data)){
                        if($data['id_jenis_produk'] == $j->id){
                            echo 'selected';
                        }
                      }
                  ?> value="<?= $j->id ?>">
                  <?= $j->nama; ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <label for="id_kategori" class="col-sm-2 col-form-label">Kategori Produk</label>
            <div class="col-sm-5">
              <select class="form-control form-control" name="id_kategori" id="id_kategori" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori as $k){ ?>
                <option <?php 
                      if(isset($data)){
                        if($data['id_kategori_produk'] == $k->id){
                            echo 'selected';
                        }
                      }
                  ?> value="<?= $k->id ?>">
                  <?= $k->nama; ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <label for="id_satuan" class="col-sm-2 col-form-label">Satuan</label>
            <div class="col-sm-5">
              <select class="form-control form-control" name="id_satuan" id="id_satuan" required>
                <option value="">Pilih Satuan</option>
                <?php foreach ($satuan as $s){ ?>
                <option <?php 
                      if(isset($data)){
                        if($data['id_satuan'] == $s->id){
                            echo 'selected';
                        }
                      }
                  ?> value="<?= $s->id ?>">
                  <?= $s->nama; ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row mb-2">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-4">
              <input type="number" class="form-control form-control" name="harga" id="harga"
                value="<?= (isset($data)) ?  $data['harga'] : '' ?>" required>
            </div>
          </div>

          <div class="row mb-2">
            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-4">
              <input type="number" class="form-control form-control" name="stok" id="stok"
                value="<?= (isset($data)) ?  $data['stok'] : '' ?>" required>
            </div>
          </div>

          <div class="row mb-2">
            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="deskripsi" id="deskripsi" cols="2"
                rows="2"><?= (isset($data)) ?  $data['deskripsi'] : '' ?></textarea>
            </div>
          </div>
          <br>
          <?php if($modeform=='UPDATE'){ ?>
          <div>
            Foto Produk
            <hr>
            <div id="foto-produk"></div>
          </div>
          <?php } ?>

          <hr>
          <div class="text-right">
            <a href="<?= site_url('Produk') ?>" class="btn btn-secondary">Batal</a>
            <button id="btn-save" type="submit" class="btn btn-primary"><i id="loading" class=""></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="div_modal"></div>
<script>
$(document).ready(function() {
  getFotoProduk();
});

$("#id_jenis").select2({
  placeholder: "Pilih Jenis Produk",
  allowClear: true
});

$("#id_kategori").select2({
  placeholder: "Pilih Kategori Produk",
  allowClear: true
});

$("#id_satuan").select2({
  placeholder: "Pilih Satuan",
  allowClear: true
});

function getFotoProduk() {
  var id = $('#id').val();
  $.ajax({
    url: base_url + "/Produk/load_image",
    type: 'POST',
    dataType: 'html',
    data: {
      id_produk: id,
    },
    beforeSend: function() {},
    success: function(result) {
      $('#foto-produk').html(result);
    }
  });
}


$(document).on('submit', '#formData', function(event) {
  event.preventDefault();
  const modeform = $('#modeform').val();
  let title = '',
    desc = '';
  if (modeform == 'ADD') {
    title = 'Simpan Produk';
    desc = 'Apakah Anda yakin menyimpan data !';
  } else {
    title = 'Ubah Produk';
    desc = 'Apakah Anda yakin mengubah data !';
  }

  Swal.fire({
    title: title,
    text: desc,
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
          url: base_url + '/Produk/save',
          method: 'POST',
          dataType: 'json',
          data: new FormData($('#formData')[0]),
          async: true,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.success == true) {
              Toast.fire({
                icon: 'success',
                title: data.message
              });
              swal.hideLoading()

              setTimeout(function() {
                window.location.href = base_url + '/master/produk';
              }, 1000);
            } else {
              setTimeout(function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: data.message
                });
              }, 1000);
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
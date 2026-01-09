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
        <span class="card-title">Laporan Pengiriman</span>
      </div>
      <div class="card-body">
        <form id="formData">
          <input type="hidden" name="id" id="id" value="<?= (isset($data)) ?  $data['id'] : '' ?>">
          <input type="hidden" name="modeform" id="modeform" value="">
          <div class="row mb-2">
            <label for="id_order" class="col-sm-2 col-form-label">Invoice</label>
            <div class="col-sm-8">
              <select class="form-control form-control" name="id_order" id="id_order" required>
                <option value="">Pilih Invoice</option>
                <?php foreach ($order as $o){ ?>
                <option value="<?= $o->id ?>"><?= $o->no_invoice; ?> - <?= $o->nama_pelanggan ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <label for="peneriman" class="col-sm-2 col-form-label">Penerima</label>
            <div class="col-sm-8">
              <input type="text" class="form-control form-control" name="penerima" id="penerima"
                value="<?= (isset($data)) ?  $data['penerima'] : '' ?>" required>
            </div>
          </div>
          <div class="row mb-2">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="keterangan" id="keterangan" cols="2"
                rows="2"><?= (isset($data)) ?  $data['keterangan'] : '' ?></textarea>
            </div>
          </div>
          <div class="row mb-2">
            <label for="nama" class="col-sm-2 col-form-label">Foto Bukti</label>
            <div class="col-sm-8">
              <input type="file" accept="image/*" class="form-control form-control" name="foto_bukti" id="foto_bukti" required>
            </div>
          </div>
          <hr>
          <div class="text-right">
            <button id="btn-save" type="submit" class="btn btn-primary"><i id="loading" class=""></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="div_modal"></div>
<script>
$("#id_order").select2({
  placeholder: "Pilih Invoice",
  allowClear: true
});

$(document).on('submit', '#formData', function(event) {
  event.preventDefault();

  Swal.fire({
    title: "Simpan Laporan Pengiriman",
    text: "Apakah Anda yakin menyimpan data !",
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
          url: '<?= site_url() ?>' + '/Order/save_laporan_pengiriman',
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
                location.reload();
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
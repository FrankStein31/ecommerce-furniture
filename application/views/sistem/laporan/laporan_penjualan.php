<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Laporan Penjualan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-2">
            <input class="form-control date-picker" id="tgl_awal" name="tgl_awal" data-date-format='dd-mm-yyyy'
              autocomplete="off" onchange="pageLoad(1)" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
          </div>
          <div class="col-md-2">
            <input class="form-control date-picker" id="tgl_akhir" name="tgl_akhir" data-date-format='dd-mm-yyyy'
              autocomplete="off" onchange="pageLoad(1)" onkeypress="return false;" value="<?= date('d-m-Y') ?>">
          </div>
          <div class="col-md-4">
            <a class="btn btn-info" href="javascript:;" onclick="printReport()"><i class="fa fa-print"></i> Cetak</a>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" id="search" name="search" class="form-control" placeholder="Cari <Tekan Enter>">
              <div class="input-group-append cursor-pointer" onclick="pageLoad(1)">
                <span class="input-group-text">
                  <i class="ti-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div id="list"></div>
      </div>
    </div>
  </div>
</div>
<!-- DATA SORT -->
<input type="hidden" name="hidden_id_th" id="hidden_id_th" value="#column_tanggal">
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="tanggal">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc">
<div id="div_modal"></div>
<script>
  $('.date-picker').datepicker({
    autoclose: true,
  }) 

  function printReport() {
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();
    var link = "<?= site_url() ?>" + "/Laporan/cetak_laporan_penjualan?tanggal_awal=" + tgl_awal + "&tanggal_akhir=" + tgl_akhir;
    window.open(link, '_blank', 'width=1024, height=768')
  }
</script>
<script src="<?= base_url('assets/js/pages/laporan_penjualan.js') ?>"></script>
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
<input type="hidden" name="hidden_id_th" id="hidden_id_th" value="#column_jumlah">
<input type="hidden" name="hidden_page" id="hidden_page" value="1">
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="o.jumlah_terjual">
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc">
<div id="div_modal"></div>
<script>
$('.date-picker').datepicker({
  autoclose: true,
})

$(document).ready(function() {
  pageLoad(1)
})

$('#search').on('keypress', function(e) {
  if (e.which == 13) {
    pageLoad(1);
  }
});

function pageLoad(page = 1) {
  var search = $('#search').val();
  // var limit = $('#limit').val();
  var limit = 20;
  var id_th = $('#hidden_id_th').val();
  var column_name = $('#hidden_column_name').val();
  var sort_type = $('#hidden_sort_type').val();
  var tgl_awal = $('#tgl_awal').val();
  var tgl_akhir = $('#tgl_akhir').val();

  $.ajax({
    url: base_url + "/Laporan/fetch_laporan_produk_terjual",
    type: 'GET',
    dataType: 'html',
    data: {
      page: page,
      sortby: column_name,
      sorttype: sort_type,
      limit: limit,
      search: search,
      tanggal_awal: tgl_awal,
      tanggal_akhir: tgl_akhir,
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list').html(result);
      $('#hidden_page').val(page);
      sort_finish(id_th, sort_type);
    }
  });
}

function sort_table(id, column) {
  var sort = $(id).attr("data-sort");
  $('#hidden_id_th').val(id);
  $('#hidden_column_name').val(column);

  if (sort == "asc") {
    sort = 'desc';
  } else if (sort == "desc") {
    sort = 'asc';
  } else {
    sort = 'asc';
  }
  $('#hidden_sort_type').val(sort);
  $('#hidden_page').val(1);
  pageLoad(1);
}

function printReport() {
  var tgl_awal = $('#tgl_awal').val();
  var tgl_akhir = $('#tgl_akhir').val();
  var link = "<?= site_url() ?>" + "/Laporan/cetak_laporan_produk_terjual?tanggal_awal=" + tgl_awal + "&tanggal_akhir=" +
    tgl_akhir;
  window.open(link, '_blank', 'width=1024, height=768')
}
</script>
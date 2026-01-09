<hr>
<div class="section small_pb small_pt">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="heading_s1 text-center">
          <h2>Pencarian Produk</h2>
        </div>
      </div>
    </div>
    <div style="background-color:#f1f1f1; padding:15px 20px 0px 20px; border-radius:4px;">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="id_jenis">Jenis Produk</label>
            <select class="form-control" name="id_jenis" id="id_jenis" onchange="getProduk(1)">
              <option value="">All Jenis</option>
              <?php foreach ($jenis as $j) { ?>
              <option value="<?= $j->id ?>"><?= $j->nama ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="id_kategori">Kategori Produk</label>
            <select class="form-control" name="id_kategori" id="id_kategori" onchange="getProduk(1)">
              <option value="">All Kategori</option>
              <?php foreach ($kategori as $k) { ?>
              <option value="<?= $k->id ?>"><?= $k->nama ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="sortby">Sort By</label>
            <select class="form-control" name="sortby" id="sortby" onchange="getProduk(1)">
              <option value="created_at|desc" selected>Terbaru</option>
              <option value="nama|asc">Nama</option>
              <option value="harga|asc">Harga Terkecil</option>
              <option value="harga|desc">Harga Terbesar</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="row mt-4">
      <div class="col-12">
        <!-- List Produk -->
        <div id="list-produk"></div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="q_produk" value="<?= $keyword ?>">

<script>
$(document).ready(function() {
  getProduk(1);
})

$("#id_jenis").select2({
  placeholder: "Pilih Jenis Produk",
  allowClear: true
});

$("#id_kategori").select2({
  placeholder: "Pilih Kategori Produk",
  allowClear: true
});

$("#sortby").select2({
  placeholder: "Sort By",
  allowClear: true
});

function getProduk(pg) {
  var q = $('#q_produk').val();
  var id_jenis = $('#id_jenis').val();
  var id_kategori = $('#id_kategori').val();
  var sorting = $('#sortby').val();

  var split = sorting.split("|");
  var sortby = (split[0]) ? split[0] : 'created_at';
  var sorttype = (split[1]) ? split[1] : 'desc';

  $.ajax({
    url: site_url + "/Produk/fetch_data_produk",
    type: 'GET',
    dataType: 'html',
    data: {
      page: pg,
      search: q,
      sortby: sortby,
      sorttype: sorttype,
      id_jenis: id_jenis,
      id_kategori: id_kategori,
      limit: 16,
      func_name: 'getProduk'
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list-produk').html(result);
    }
  });
}
</script>
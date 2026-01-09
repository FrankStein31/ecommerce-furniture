<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h3>Order Detail</h3>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Order Detail</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- START MAIN CONTENT -->
<div class="main_content">
  <div class="section" style="padding: 30px 0 !important;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="tab-style3">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="order-tab" data-toggle="tab" href="#order-pane" role="tab"
                  aria-controls="order-pane" aria-selected="true">Detail Order</a>
              </li>
              <?php if($order['status']=='4'){ ?>
              <!-- Pesanan Selesai -->
              <li class="nav-item">
                <a class="nav-link" id="rating-tab" data-toggle="tab" href="#rating-pane" role="tab"
                  aria-controls="rating-pane" aria-selected="false">Ulasan</a>
              </li>
              <?php } ?>
            </ul>
          </div>

          <div class="tab-content shop_info_tab">
            <div class="tab-pane fade show active" id="order-pane" role="tabpanel" aria-labelledby="order-tab">
              <!-- Detail Produk -->
              <div class="order_review1" style="border:1px solid #dedede; padding:30px; border-radius:5px;">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="mb-4">Order</h5>
                  </div>
                  <div class="col-md-6 text-right">
                  <?php if($order['status']=='3'){ ?>
                    <!-- Beri penilaian -->
                    <a href="<?= site_url('Rating/penilaian/'.$order['id']) ?>" class="text-white btn btn-warning">Terima Pesanan</a>
                  <?php } ?>
                  </div>
                </div>
                <br>
                <div class="table-responsive">
                  <table class="table order-table">
                    <tr>
                      <td style="width:15%;">No Invoice </td>
                      <td style="width:3%;">: </td>
                      <td style="width:75%;"><?= $order['no_invoice'] ?></td>
                    </tr>
                    <tr>
                      <td>Nama</td>
                      <td>:</td>
                      <td><?= $order['nama_pelanggan'] ?> (<?= $order['kode_pelanggan'] ?>)</td>
                    </tr>
                    <tr>
                      <td>Tanggal</td>
                      <td>:</td>
                      <td><?= $order['tanggal'] ?></td>
                    </tr>
                    <tr>
                      <td>Catatan/Keterangan</td>
                      <td>:</td>
                      <td><?= $order['keterangan'] ?></td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>
                        <div class="badge badge-success">
                          <?= $order['nama_status'] ?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><b>Alamat Pengiriman</b></td>
                    </tr>
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td><?= $order['alamat'] ?></td>
                    </tr>
                    <tr>
                      <td>No Telepon</td>
                      <td>:</td>
                      <td><?= $order['no_telp'] ?></td>
                    </tr>
                    <tr>
                      <td>Kode Pos</td>
                      <td>:</td>
                      <td><?= $order['kode_pos'] ?></td>
                    </tr>
                    <tr>
                      <td>Penerima</td>
                      <td>:</td>
                      <td><?= $order['penerima'] ?></td>
                    </tr>
                    <tr>
                      <td>Keterangan Alamat</td>
                      <td>:</td>
                      <td><?= $order['keterangan'] ?></td>
                    </tr>
                    <?php if($order['tanggal_upload']!=""){ ?>
                      <tr>
                        <td colspan="3"><b>Bukti Pembayaran</b></td>
                      </tr>
                      <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= format_date($order['tanggal_upload'], 'd-m-Y H:i:s') ?></td>
                      </tr>
                      <tr>
                        <td>Bukti</td>
                        <td>:</td>
                        <td>
                          <a style="text-decoration:underline;" href="javascript:;"
                            onclick="previewDokumen('<?= $order['bukti_bayar'] ?>', 'Bukti Pembayaran')">Lihat</a>
                        </td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>

                <br>
                <h5>Produk Dibeli</h5>
                <br>
                <div class="table-responsive">
                  <table class="table" id="order-table">
                    <thead class="tr-head">
                      <tr>
                        <th class="text-center">No.</th>
                        <th>Produk</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no = 0;
                        $total = 0;
                        foreach ($order_detail as $row) { 
                          $no++; 
                          $total += ($row->qty*$row->harga);
                        ?>
                      <tr>
                        <td class="text-center"><?= $no ?>.</td>
                        <td><?= $row->nama_produk ?></td>
                        <td class="text-center"><?= $row->satuan ?></td>
                        <td class="text-center"><?= $row->qty ?></td>
                        <td class="text-right"><?= rupiah($row->harga) ?></td>
                        <td class="text-right"><?= rupiah($row->qty * $row->harga) ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td>
                        <td class="text-right"><b>Total</b></td>
                        <td class="text-right">
                          <span id="total-order"><?= rupiah($total) ?></span>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <!-- End Detail Produk -->
            </div>
            <div class="tab-pane fade" id="rating-pane" role="tabpanel" aria-labelledby="rating-tab">
              <!-- Ulasan -->
              <div class="order_review1">
                <h5 class="mb-4">Ulasan Produk</h5>
                <form action="" id="form-ulasan">
                  <input type="hidden" id="count_order" value="<?= count($order_detail) ?>">
                  <?php foreach ($order_detail as $row) { ?>
                  <div class="card mb-4">
                    <input type="hidden" name="id_produk[]" value="<?= $row->id_produk ?>">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-md-6">
                          <h5><?= $row->nama_produk ?></h5>
                          <h6>Total : <?= rupiah($row->qty*$row->harga) ?></h6>
                        </div>
                        <div class="col-md-6 text-right">
                          <span><?= $row->qty ?> x <?= rupiah($row->harga) ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group col-12">
                        <div style="color:#333;">
                          Rating :
                          <div class="rating_wrap">
                            <div class="rating">
                              <div class="product_rate" style="width:<?= $row->rating*20 ?>%"></div>
                            </div>
                          </div>
                          <br>
                          Ulasan :
                          <p><?= ($row->ulasan!="") ? $row->ulasan : '-' ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </form>
              </div>
              <!-- End Ulasan -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="div-modal-dokumen"></div>
<script>
  function previewDokumen(file, judul){
    $.ajax({
        url: '<?= site_url() ?>'+'/Order/preview_dokumen',
        type: 'post',
        dataType: 'html',
        data:{
          file:file,
          judul:judul,
        },
        beforeSend: function () {},
        success: function (result) {
          $('#div-modal-dokumen').html(result);
          $('#modal-preview').modal('show');
        }
    });
  }
</script>

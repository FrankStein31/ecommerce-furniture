<style>
.order-table tr,
td {
  padding: 8px !important;
}
.tr-head-order {
  background-color: #f8f8f9 !important;
  vertical-align: bottom;
  border-bottom: 3px solid #dee2e6;
}
</style>
<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Detail Order</span>
        <?php 
        $id_role = $this->session->userdata("auth_id_role");
        if($id_role=='ADMIN'){ ?>
        <a class="float-right btn btn-primary" onclick="loadModalStatus()" href="javascript:;">Update Status</a>
        <?php } ?>
      </div>
      <div class="card-body">
        <div class="order_review">
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
                <td><?= format_date($order['tanggal'], 'd-m-Y') ?></td>
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

              <!-- Upload Bukti Pembayaran -->
              <?php if($order['tanggal_upload']!=""){ ?>
                <tr>
                  <td colspan="3"><br></td>
                </tr>
                <tr class="tr-head-order">
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

              <!-- Laporan Pengiriman -->
              <?php if($order['tanggal_pengiriman']!=""){ ?>
                <tr>
                  <td colspan="3"><b>Laporan Pengiriman</b></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td>:</td>
                  <td><?= format_date($order['tanggal_pengiriman'], 'd-m-Y H:i:s') ?></td>
                </tr>
                <tr>
                  <td>Kurir / Pengirim</td>
                  <td>:</td>
                  <td><?= $order['nama_kurir'] ?></td>
                </tr>
                <tr>
                  <td>Penerima</td>
                  <td>:</td>
                  <td><?= $order['penerima_pengiriman'] ?></td>
                </tr>
                <tr>
                  <td>Keterangan</td>
                  <td>:</td>
                  <td><?= $order['keterangan_pengiriman'] ?></td>
                </tr>
                <tr>
                  <td>Foto</td>
                  <td>:</td>
                  <td>
                    <a style="text-decoration:underline;" href="javascript:;"
                      onclick="previewDokumen('<?= $order['foto_pengiriman'] ?>', 'Foto Bukti Pengiriman')">Lihat</a>
                  </td>
                </tr>
              <?php } ?>
            </table>
          </div>

          <br>
          <h5>Order</h5>
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

        <hr>
        <div class="text-right">
          <a href="<?= site_url('Order') ?>" class="btn btn-secondary">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Status -->
<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-status" action="" method="POST">
        <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id" value="<?= $order['id'] ?>"></input>
          <div class="form-group">
            <label for="nama">Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="">Pilih status</option>
              <?php foreach ($order_status as $st) { ?>
              <option value="<?= $st->id ?>"><?= $st->keterangan ?></option>
              <?php } ?>
            </select>
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

<div id="div-modal-dokumen"></div>
<script>
function previewDokumen(file, judul) {
  $.ajax({
    url: '<?= site_url() ?>' + '/Order/preview_dokumen',
    type: 'post',
    dataType: 'html',
    data: {
      file: file,
      judul: judul,
    },
    beforeSend: function() {},
    success: function(result) {
      $('#div-modal-dokumen').html(result);
      $('#modal-preview').modal('show');
    }
  });
}

function loadModalStatus() {
  $('#modal-status').modal('show');
}

$(document).on('submit', '#form-status', function(event) {
  event.preventDefault();
  $.ajax({
    url: base_url + "/Order/update_status",
    method: 'POST',
    dataType: 'json',
    data: new FormData($('#form-status')[0]),
    async: true,
    processData: false,
    contentType: false,
    success: function(data) {
      if (data.success == true) {
        Toast.fire({
          icon: 'success',
          title: data.message
        });
        $('#modal-status').modal('hide');
        location.reload();
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
</script>
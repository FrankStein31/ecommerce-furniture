<style>
.swal2-container {
  z-index: 99999 !important;
}
</style>
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1>Order Completed</h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Order Completed</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START MAIN CONTENT -->
<div class="main_content">
  <div class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="text-center order_complete">
            <input id="id_order" type="hidden" value="<?= $order['id'] ?>">
            <?php if($order['tanggal_upload']!=""){ ?>
            <i class="fas fa-check-circle"></i>
            <div class="heading_s1">
              <h3>Pesanan berhasil!</h3>
            </div>
            <p>
              Terima kasih atas pesanan Anda! Pesanan Anda akan segera diproses dan divalidasi, untuk bukti pembayaran
              Anda dapat melihatnya di detail order.
            </p>
            <a href="<?= site_url('/') ?>" class="btn btn-fill-out">Kembali ke Home</a>
            <?php }else{ ?>
            <div class="heading_s1">
              <h3>Menunggu Pembayaran!</h3>
            </div>
            <p>
              Pesanan Anda akan diproses dan divalidasi setelah Anda menyelesaikan
              pembayaran.
            </p>

            Note Pembayaran : <br>
            BANK BCA <br>
            Rekening : 56789067867
            AN. Anggita Jaya
            <br><br>
            <a href="javascript:;" onclick="loadModalUpload()" class="btn btn-fill-out">Upload Bukti Pembayaran</a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="div-upload"></div>
<script>
function loadModalUpload() {
  $.ajax({
    url: "<?= site_url() ?>" + "/Order/modal_upload",
    type: 'GET',
    data: {},
    dataType: 'html',
    beforeSend: function() {},
    success: function(result) {
      $('#div-upload').html(result);
      $('#modal-bukti-bayar').modal('show');
    }
  });
}

$(document).on('submit', '#form-upload', function(event) {
  event.preventDefault();
  var id_order = $('#id_order').val();
  var formData = new FormData($('#form-upload')[0]);
  formData.append('id_order', id_order);

  Swal.fire({
    text: "Simpan upload bukti pembayaran !",
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
          url: "<?= site_url() ?>" + "/Order/upload_bukti_pembayaran",
          method: 'POST',
          dataType: 'json',
          data: formData,
          async: true,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.success == true) {
              $('#modal-bukti-bayar').modal('hide');
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
});
</script>
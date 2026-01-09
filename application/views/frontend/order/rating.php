<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h3>Penilaian Produk</h3>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Penilaian Produk</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- START MAIN CONTENT -->
<div class="main_content">
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h5>Order</h5>
            </div>
            <div class="col-md-6 text-right">
              <a href="javascript:history.go(-1);" class="btn btn-fill-out">Kembali</a>
            </div>
          </div>

          <br>
          <div class="order_review1">
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
                  <td>Status</td>
                  <td>:</td>
                  <td><?= $order['nama_status'] ?></td>
                </tr>
              </table>
            </div>

            <br>
            <h5 class="mb-4">Ulasan Produk</h5>
            <form action="" id="form-ulasan">
              <input type="hidden" name="id_order" value="<?= $order['id'] ?>">
              <input type="hidden" id="count_order" value="<?= count($order_detail) ?>">
              <?php foreach ($order_detail as $row) { ?>
              <div class="card mb-4">
                <input type="hidden" name="id_produk_detail[]" value="<?= $row->id ?>">
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
                  <?php if($row->rating!=""){ ?>
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
                  <?php }else{ ?>
                  <div class="form-group col-12">
                    <div class="star_rating">
                      <span class="ratings" data-value="1"><i class="far fa-star"></i></span>
                      <span class="ratings" data-value="2"><i class="far fa-star"></i></span>
                      <span class="ratings" data-value="3"><i class="far fa-star"></i></span>
                      <span class="ratings" data-value="4"><i class="far fa-star"></i></span>
                      <span class="ratings" data-value="5"><i class="far fa-star"></i></span>
                      <input name="rating[]" class="input_rating" type="hidden" value="0">
                    </div>
                  </div>
                  <div class="form-group col-12">
                    <textarea placeholder="Ulasan produk . . ." class="form-control" name="ulasan[]"
                      rows="3"></textarea>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if($row->rating==""){ ?>
              <div class="text-right">
                <button class="btn btn-primary">Beri Ulasan</button>
              </div>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).on('click', '.ratings', function(event) {
  event.preventDefault();
  var value = $(this).attr('data-value');
  $(this).parents('.star_rating').find(".input_rating").val(value);
});

function getValidRating() {
  var countOrder = $("#count_order").val();
  var jml = 0;
  $(".input_rating").each(function() {
    let value = $(this).val();
    if (value > 0) {
      jml++;
    }
  });

  return (countOrder == jml) ? true : false;
}

$(document).on('submit', '#form-ulasan', function(event) {
  event.preventDefault();
  var formData = new FormData($('#form-ulasan')[0]);

  var valid = getValidRating();
  console.log("valid", getValidRating());
  if (valid) {
    $.ajax({
      url: site_url + '/Rating/save_ulasan',
      method: 'POST',
      dataType: 'json',
      data: formData,
      async: true,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.success == true) {
          Toast.fire({
            icon: 'success',
            title: data.message
          });
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
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: "Mohon untuk memberikan rating untuk setiap produk !"
    });
  }
});
</script>
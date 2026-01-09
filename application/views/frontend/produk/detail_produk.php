<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1>Product Detail</h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Pages</a></li>
          <li class="breadcrumb-item active">Product Detail</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- END SECTION BREADCRUMB -->
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
        <div class="product-image">
          <div class="product_img_box">
            <img id="product_img"
              src='<?= ($data['foto']!="") ? base_url($data['foto']) : base_url('assets/images/icons/no-product.png') ?>'
              data-zoom-image="<?= ($data['foto']!="") ? base_url($data['foto']) : base_url('assets/images/icons/no-product.png') ?>"
              alt="product_img1" />
            <a href="#" class="product_img_zoom" title="Zoom">
              <span class="linearicons-zoom-in"></span>
            </a>
          </div>
          <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4"
            data-slides-to-scroll="1" data-infinite="false">
            <?php 
            $no = 0;
            foreach ($foto_produk as $fp) { $no++; ?>
            <div class="item">
              <a href="#" class="product_gallery_item <?= ($no==1) ? 'active' : '' ?>"
                data-image="<?= base_url($fp->foto) ?>" data-zoom-image="<?= base_url($fp->foto) ?>">
                <img style="width:120px; height:120px; object-fit:cover;" src="<?= base_url($fp->foto) ?>"
                  alt="product_small_img1" />
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="pr_detail">
          <div class="product_description">
            <h4 class="product_title"><a href="#"><?= $data['nama'] ?></a></h4>
            <div class="product_price">
              <span class="price"><?= rupiah($data['harga']) ?></span>
            </div>
            <div class="rating_wrap">
              <div class="rating">
                <div class="product_rate" style="width:<?= $data['rata_rata_rating']*20 ?>%"></div>
              </div>
              <span class="rating_num">(<?= $data['total_rating'] ?>)</span>
            </div>
            <div class="pr_desc">
              <p> </p>
            </div>
          </div>
          <hr />
          <p><?= $data['deskripsi'] ?></p>
          <form id="form-cart">
            <div class="cart_extra">
              <input type="hidden" id="id_produk" name="id_produk" value="<?= $data['id'] ?>">
              <input type="hidden" id="stok_produk" name="stok_produk" value="<?= $data['stok'] ?>">
              <div class="cart-product-quantity">
                <div class="quantity">
                  <input type="button" value="-" class="minus">
                  <input type="text" id="qty_produk" name="qty" value="1" title="Qty" class="qty" size="4">
                  <input type="button" value="+" class="plus">
                </div>
              </div>
              <div class="cart_btn">
                <button type="submit" class="btn btn-fill-out btn-addtocart" type="button">
                  <i class="icon-basket-loaded"></i> Tambah ke keranjang
                </button>
              </div>
            </div>
          </form>
          <hr />
          <ul class="product-meta">
            <li><b>SKU:</b> <?= $data['kode'] ?></li>
            <li><b>Kategori:</b> <?= $data['kategori_produk'] ?></li>
            <li><b>Jenis:</b> <?= $data['jenis_produk'] ?></li>
            <li><b>Stok:</b> <?= $data['stok'] ?></li>
          </ul>

          <!-- <div class="product_share">
            <span>Share:</span>
            <ul class="social_icons">
              <li><a href="#"><i class="ion-social-facebook"></i></a></li>
              <li><a href="#"><i class="ion-social-twitter"></i></a></li>
              <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
              <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
              <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="large_divider clearfix"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="tab-style3">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab"
                aria-controls="Description" aria-selected="true">Deskripsi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews"
                aria-selected="false">Ulasan</a>
            </li>
          </ul>
          <div class="tab-content shop_info_tab">
            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
              <p><?= $data['deskripsi'] ?></p>
            </div>
            <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
              <div class="comments">
                <h5 class="product_tab_title">Review untuk <span><?= $data['nama'] ?></span></h5>
                <div id="list-ulasan"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="small_divider"></div>
        <div class="divider"></div>
        <div class="medium_divider"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="heading_s1">
          <h3>Produk Serupa</h3>
        </div>
        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20"
          data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
          <?php foreach ($produk_serupa as $ps) { ?>
          <div class="item">
            <div class="product_wrap">
              <!-- <span class="pr_flash">New</span> -->
              <div class="product_img">
                <a href="<?= site_url('Produk/detail/'.$ps->id) ?>">
                  <img style="height:290px; object-fit:cover;"
                    src="<?= ($ps->foto!="") ? base_url($ps->foto) : base_url('assets/images/icons/no-product.png') ?>"
                    alt="el_img3">
                  <img style="height:290px; object-fit:cover;" class="product_hover_img"
                    src="<?= ($ps->foto!="") ? base_url($ps->foto) : base_url('assets/images/icons/no-product.png') ?>"
                    alt="el_hover_img3">
                </a>
                <div class="product_action_box">
                  <ul class="list_none pr_action_btn">
                  </ul>
                </div>
              </div>
              <div class="product_info">
                <h6 class="product_title"><a href="<?= site_url('Produk/detail/'.$ps->id) ?>"><?= $ps->nama ?></a>
                </h6>
                <div class="product_price">
                  <span class="price"><?= rupiah($ps->harga) ?></span>
                </div>
                <div class="rating_wrap">
                  <div class="rating">
                    <div class="product_rate" style="width:<?= $ps->rata_rata_rating*20 ?>%"></div>
                  </div>
                  <span class="rating_num">(<?= $ps->total_rating ?>)</span>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  getUlasan(1);
})

function getUlasan(page = 1) {
  var limit = 5;
  var id_produk = $('#id_produk').val();
  $.ajax({
    url: "<?= site_url() ?>" + "/Rating/fetch_data_ulasan",
    type: 'GET',
    dataType: 'html',
    data: {
      page: page,
      sortby: 'created_at',
      sorttype: 'desc',
      limit: limit,
      id_produk: id_produk,
      func_name: 'getUlasan'
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list-ulasan').html(result);
    }
  });
}

$(document).on('submit', '#form-cart', function(event) {
  event.preventDefault();
  var stok = parseInt($('#stok_produk').val());
  var qty = parseInt($('#qty_produk').val());

  if(stok==0){
    Swal.fire({
      icon: 'error',
      title: 'Maaf...',
      text: "Stok produk saat ini kosong !"
    });
  } else if (qty > stok) {
    Swal.fire({
      icon: 'error',
      title: 'Maaf...',
      text: "Stok saat ini hanya tersisa "+ stok +" Item !"
    });
  } else {
    var formData = new FormData($('#form-cart')[0]);
    $.ajax({
      url: '<?= site_url() ?>' + '/Order/add_cart',
      method: 'POST',
      dataType: 'json',
      data: formData,
      async: true,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.success == true) {
          ToastFast.fire({
            icon: 'success',
            title: data.message
          });
          loadNotifikasiCart();
        } else {
          window.location.href = site_url + "/Auth";
        }
      },
      fail: function(event) {
        alert(event);
      }
    });
  }
});
</script>
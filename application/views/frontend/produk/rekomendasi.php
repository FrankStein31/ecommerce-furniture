<hr>
<div class="section small_pb small_pt">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="heading_s1 text-center">
          <h2>Rekomendasi Produk</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- List Produk -->
        <?php if(count($rekomendasi)>0){ ?>
        <div class="row">
          <?php foreach ($rekomendasi as $p) { ?>
          <div class="col-md-3 col-sm-6">
            <div class="item">
              <div class="product_wrap">
                <!-- <span class="pr_flash">New</span> -->
                <div class="product_img">
                  <a href="<?= site_url('Produk/detail/'.$p['id']) ?>">
                    <img style="height:290px; object-fit:cover;" src="<?= ($p['foto']!="") ? base_url($p['foto']) : base_url('assets/images/icons/no-product.png') ?>" alt="el_img3">
                    <img style="height:290px; object-fit:cover;" class="product_hover_img"
                      src="<?= ($p['foto']!="") ? base_url($p['foto']) : base_url('assets/images/icons/no-product.png') ?>" alt="el_hover_img3">
                  </a>
                  <div class="product_action_box">
                    <ul class="list_none pr_action_btn">
                    </ul>
                  </div>
                </div>
                <div class="product_info">
                  <h6 class="product_title"><a href="<?= site_url('Produk/detail/'.$p['id']) ?>"><?= $p['nama'] ?></a>
                  </h6>
                  <div class="product_price">
                    <span class="price"><?= rupiah($p['harga']) ?></span>
                    <!-- <del>$99.00</del> -->
                  </div>
                  <div class="rating_wrap">
                    <div class="rating">
                      <div class="product_rate" style="width:<?= $p['rata_rata_rating']*20 ?>%"></div>
                    </div>
                    <span class="rating_num">(<?= $p['total_rating'] ?>)</span>
                  </div>
                  <div class="pr_desc">
                    <p></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php }else{ ?>
        <div class="alert alert-warning">
          Data produk tidak ditemukan !
        </div>
        <?php } ?>
        <!-- End -->
      </div>
    </div>
  </div>
</div>

<script>
function getProduk() {
  $.ajax({
    url: site_url + "/Produk/fetch_data_produk",
    type: 'GET',
    dataType: 'html',
    data: {
      sortby: 'created_at',
      sorttype: 'desc',
      limit: 20,
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list-produk').html(result);
    }
  });
}
</script>
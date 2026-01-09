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
          <h3>Keranjang Belanja</h3>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Keranjang Belanja</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- END SECTION BREADCRUMB -->

<div class="main_content">
  <!-- Content -->
  <div class="section">
    <div class="container">
      <div id="div-cart"></div>
      <!-- Total -->
      <div class="row">
        <div class="col-12">
          <div class="medium_divider"></div>
          <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
          <div class="medium_divider"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
          <div class="border p-3 p-md-4">
            <div class="heading_s1 mb-3">
              <h6>Total Keranjang</h6>
            </div>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <td class="cart_total_label">Jumlah</td>
                    <td class="cart_total_amount">
                      <span id="total-items">0</span> Items
                    </td>
                  </tr>
                  <tr>
                    <td class="cart_total_label">Total</td>
                    <td class="cart_total_amount">
                      <strong><span id="total-cart">0</span></strong>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <a href="javascript:;" onclick="checkout()" class="btn btn-fill-out">CheckOut</a>
          </div>
        </div>
      </div>
      <!-- End Total -->
    </div>
  </div>
  <!-- End Content -->

  <!-- Modal Checkout -->
  <div class="modal fade" id="modal-checkout" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Checkout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-checkout" action="" method="POST">
          <div class="modal-body">
            <div class="order_review">
              <div class="heading_s1">
                <h4>Order</h4>
              </div>
              <div class="table-responsive">
                <table class="table" id="order-table">
                  <thead>
                    <tr>
                      <th>Produk</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total</th>
                      <td class="product-subtotal">
                        <span id="total-order">0</span>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <br>
              <div class="heading_s1">
                <h4>Detail Order</h4>
              </div>

              <div class="form-group">
                <label for="keterangan">Keterangan / Catatan</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="2"
                  placeholder="Catatan . . ."></textarea>
              </div>
              <hr>
              <!-- alamat -->
              <p class="mb-2">Alamat</p>
              <div class="payment_method">
                <div class="payment_option">
                  <?php
                  $no=0;
                  $utama="";
                  if(count($alamat)>0){
                    foreach ($alamat as $al) { 
                      $no++; 
                      if($al->is_utama=='1'){
                        $utama = $al->id;
                      }
                    ?>
                    <div class="custome-radio">
                      <input class="form-check-input check-alamat" type="radio" name="payment_option"
                        id="exampleRadios<?= $al->id ?>" value="<?= $al->id ?>"
                        <?= ($al->is_utama=='1') ? ' checked' : '' ?>>
                      <label class="form-check-label" for="exampleRadios<?= $al->id ?>"><?= $al->alamat ?>
                        <?= ($al->is_utama=='1') ? ' (Utama)' : '' ?></label>
                      <p data-method="<?= $al->id ?>" class="payment-text">
                        <span>Penerima : <?= $al->penerima ?></span><br>
                        <span>Keterangan : <?= $al->keterangan ?></span>
                      </p>
                    </div>
                  <?php }}else{ ?>
                    Jika Anda belum memiliki alamat Anda dapat menambahkan alamat <br> <i>di Account > Alamat <a style="text-decoration:underline;" href="<?= site_url('Account') ?>">account</a></i> 
                  <?php } ?>
                </div>
              </div>
              <input type="hidden" id="alamat-pengiriman" name="alamat_pengiriman" value="<?= $utama ?>">
              <!-- End alamat -->
            </div>
            <input id="order-detail-json" type="hidden">
            <!--  -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/pages/cart.js') ?>"></script>
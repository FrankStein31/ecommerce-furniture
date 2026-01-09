<div class="row">
  <div class="col-12">
    <div class="table-responsive shop_cart_table">
      <table class="table" id="cart-table">
        <thead>
          <tr>
            <th>
              <div class="form-check">
                <input class="form-check-input" id="check-all" type="checkbox" value="1">
                <label for="check-all">All</label>
              </div>
            </th>
            <th>&nbsp;</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          if(count($data)>0){
            foreach ($data as $row) { 
              $total += ($row->qty*$row->harga);
            ?>
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input product-check" type="checkbox" value="1">
                </div>
              </td>
              <td class="product-thumbnail">
                <a href="javascript:;"><img src="<?= base_url($row->foto) ?>" alt="product1"></a>
              </td>
              <td>
                <input class="cart-check-product" type="hidden">
                <input class="cart-id" type="hidden" value="<?= $row->id ?>">
                <input class="product-id" type="hidden" value="<?= $row->id_produk ?>">
                <input class="product-name" type="hidden" value="<?= $row->nama ?>">
                <a href="javascript:;"><?= $row->nama ?></a>
              </td>
              <td>
                <input type="hidden" class="product-price" value="<?= $row->harga ?>">
                <?= rupiah($row->harga) ?>
              </td>
              <td class="product-quantity" data-title="Jumlah">
                <div class="quantity">
                  <input type="button" value="-" class="minus">
                  <input type="text" name="quantity" value="<?= $row->qty ?>" title="Qty" class="qty" size="4" onkeypress='return isNumberKey(event)'>
                  <input type="button" value="+" class="plus">
                </div>
              </td>
              <td>
                <input class="product-subtotal-hidden" type="hidden" value="<?= $row->qty*$row->harga ?>">
                <span class="product-subtotal">
                  <?= rupiah($row->qty*$row->harga) ?>
                </span>
              </td>
              <td class="product-remove">
                <a href="javascript:;" class="btn-delete-cart" data-id="<?= $row->id ?>"><i class="ti-close"></i></a>
              </td>
            </tr>
          <?php }}else{ ?>
          <tr>
            <td colspan="6">Keranjang belanja kosong !</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <hr>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/frontend/js/scripts.js') ?>"></script>
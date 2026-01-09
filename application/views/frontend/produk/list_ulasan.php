<?php if($list->num_rows()!=0){ ?>
<ul class="list_none comment_list mt-4">
  <?php foreach ($list->result() as $row) { ?>
  <li>
    <div class="comment_img">
      <img style="width:80px;" src="<?= ($row->foto!="") ? base_url().'/'.$row->foto : base_url('assets/images/icons/no-profile.png') ?>" alt="user1" />
    </div>
    <div class="comment_block">
      <div class="rating_wrap">
        <div class="rating">
          <div class="product_rate" style="width:<?= $row->rating*20 ?>%"></div>
        </div>
      </div>
      <p class="customer_meta">
        <span class="review_author"><?= $row->nama ?></span>
        <span class="comment-date" style="font-size:13px;"><?= tgl_indo(format_date($row->created_at, 'd-m-Y')) ?> <?= format_date($row->created_at, 'H:m:s') ?></span>
      </p>
      <div class="description">
        <p><?= $row->ulasan ?></p>
      </div>
    </div>
  </li>
  <?php } ?>
</ul>
<?php }else{ ?>
<div class="alert alert-warning">
  Belum ada ulasan produk !
</div>
<?php } ?>
<br>
<?php 
  if($list->num_rows()>0){
?>
<div class="row">
  <br>
  <div class="col-xs-12 col-md-6" style="padding-top:5px; color:#333;">
    Menampilkan data
    <?php $batas_akhir = (($paging['current'])*$paging['limit']);
    if ($batas_akhir > $paging['count_row']) {
        $batas_akhir = $paging['count_row'];
    }
    echo ((($paging['current']-1)*$paging['limit'])+1).' - '.$batas_akhir.' dari total '.$paging['count_row']; ?>
    data
  </div>
  <br>
  <div class="col-xs-12 col-md-6">
    <div style="float:right;">
      <?php echo $paging['list']; ?>
    </div>
  </div>
</div>
<?php } ?>
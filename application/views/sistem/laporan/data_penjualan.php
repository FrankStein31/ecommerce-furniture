<?php
    $x = ($paging['limit']*$paging['current'])-$paging['limit'];
        
    if($x<=0)
    {
        $no=0;
    }
    else
    {
        $no = $x;
    }
    $no++;
?>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead class="tr-head">
      <tr>
        <th width="3%" class="text-center">No. </th>
        <th width="10%" class="sortable" id="column_invoice" data-sort="" onclick="sort_table('#column_invoice','no_invoice')">No Invoice </th>
        <th width="10%" class="sortable text-center" id="column_tanggal" data-sort="" onclick="sort_table('#column_tanggal','tanggal')">Tanggal </th>
        <th width="15%" class="sortable" id="column_nama_produk" data-sort="" onclick="sort_table('#column_nama_produk','nama_produk')">Produk </th>
        <th width="10%" class="sortable" id="column_pelanggan" data-sort="" onclick="sort_table('#column_pelanggan','nama_pelanggan')">Pelanggan </th>
        <th width="5%" class="text-center">Qty </th>
        <th width="10%" class="text-right">Harga </th>
        <th width="10%" class="text-right">Total </th>
      </tr>
      </thead>
      <tbody>
      <?php 
        if($list->num_rows()!=0){
        $no=($paging['current']-1)*$paging['limit']; 
        foreach ($list->result() as $row) { $no++; ?>
          <tr>
            <td class="text-center"><?= $no ?>.</td>
            <td><?= $row->no_invoice ?></td>
            <td class="text-center"><?= format_date($row->tanggal, 'd/m/Y') ?></td>
            <td><?= $row->nama_produk ?></td>
            <td><?= $row->nama_pelanggan ?></td>
            <td class="text-center"><?= $row->qty ?></td>
            <td class="text-right"><?= rupiah($row->harga) ?></td>
            <td class="text-right"><?= rupiah($row->qty*$row->harga) ?></td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="8">Data tidak ditemukan!</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
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
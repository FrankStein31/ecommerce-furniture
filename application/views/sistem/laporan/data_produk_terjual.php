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
        <th width="10%" class="sortable text-center" id="column_kode" data-sort="" onclick="sort_table('#column_kode','p.kode')">Kode Produk </th>
        <th width="40%" class="sortable" id="column_nama_produk" data-sort="" onclick="sort_table('#column_nama_produk','p.nama')">Produk </th>
        <th width="10%" class="text-center">Satuan </th>
        <th width="5%" class="text-center">Jumlah </th>
      </tr>
      </thead>
      <tbody>
      <?php 
        if($list->num_rows()!=0){
        $no=($paging['current']-1)*$paging['limit']; 
        foreach ($list->result() as $row) { $no++; ?>
          <tr>
            <td class="text-center"><?= $no ?>.</td>
            <td class="text-center"><?= $row->kode_produk ?></td>
            <td><?= $row->nama_produk ?></td>
            <td class="text-center"><?= $row->satuan ?></td>
            <td class="text-center"><?= $row->jumlah_terjual ?></td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="5">Data tidak ditemukan!</td>
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
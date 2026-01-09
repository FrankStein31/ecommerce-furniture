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
        <th width="10%" class="sortable" id="column_invoice" data-sort="" onclick="sort_table('#column_invoice','o.no_invoice')">No Invoice </th>
        <th width="10%" class="sortable" id="column_tanggal" data-sort="" onclick="sort_table('#column_tanggal','o.tanggal')">Tanggal </th>
        <th width="10%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','p.nama')">Nama </th>
        <th width="10%" >No Telp </th>
        <th width="10%" class="sortable" id="column_alamat" data-sort="" onclick="sort_table('#column_alamat','p.alamat')">Alamat </th>
        <th width="10%" class="text-right">Total </th>
        <th width="10%" class="text-center">Status </th>
        <th class="text-center" width="10%">Aksi</th>
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
            <td><?= format_date($row->tanggal, 'd/m/Y') ?></td>
            <td>
              <?= $row->nama_pelanggan ?> <small>(<?= $row->kode_pelanggan ?>)</small>
            </td>
            <td><?= $row->no_telp ?></td>
            <td><?= $row->alamat ?></td>
            <td class="text-right"><?= rupiah($row->total) ?></td>
            <td class="text-center"><b><?= $row->nama_status ?></b></td>
            <td class="text-center">
              <a href="<?= site_url('Order/detail_pesanan/'.$row->id) ?>" data-id="<?=$row->id?>" data-name="<?=$row->nama_pelanggan?>" class="btn btn-sm btn-info btn-detail" data-toggle="tooltip" title="Detail Order"><i class="fa fa-eye"></i></a>	    
            </td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="9">Data tidak ditemukan!</td>
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
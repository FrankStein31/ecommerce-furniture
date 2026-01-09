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
        <th width="10%" class="sortable" id="column_kode" data-sort="" onclick="sort_table('#column_kode','p.kode')">Kode </th>
        <th width="20%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','p.nama')">Nama </th>
        <th width="10%" class="sortable" id="column_jenis" data-sort="" onclick="sort_table('#column_jenis','jp.nama')">Jenis </th>
        <th width="10%" class="sortable" id="column_kategori" data-sort="" onclick="sort_table('#column_kategori','k.nama')">Kategori </th>
        <th width="10%" class="sortable" id="column_satuan" data-sort="" onclick="sort_table('#column_satuan','s.nama')">Satuan </th>
        <th width="10%" class="sortable" id="column_harga" data-sort="" onclick="sort_table('#column_harga','p.harga')">Harga </th>
        <th width="5%" class="sortable" id="column_stok" data-sort="" onclick="sort_table('#column_stok','p.stok')">Stok </th>
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
            <td><?= $row->kode ?></td>
            <td><?= $row->nama ?></td>
            <td><?= $row->jenis_produk ?></td>
            <td><?= $row->kategori_produk ?></td>
            <td><?= $row->satuan ?></td>
            <td><?= $row->harga ?></td>
            <td><?= $row->stok ?></td>
            <td class="text-center">
              <a href="<?= site_url('Produk/edit/'.$row->id) ?>" data-id="<?=$row->id?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Tipe Hafalan"><i style="color:#fff;" class="fa fa-edit"></i></a>
              <a href="javascript:;" data-id="<?=$row->id?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-danger btn-delete" data-toggle="tooltip" title="Hapus Tipe Hafalan"><i class="fa fa-trash"></i></a>	    
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
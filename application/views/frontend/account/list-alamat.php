<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>Alamat</th>
        <th>Penerima</th>
        <th>Utama</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php 
        if($alamat->num_rows()!=0){
        foreach ($alamat->result() as $row) { ?>
          <tr>
            <td><?= $row->alamat ?></td>
            <td><?= $row->penerima ?></td>
            <td>
              <?php if($row->is_utama=='1'){ ?>
                <div class="badge badge-success">Utama</div>
              <?php } ?>
            </td>
            <td class="text-center">
              <a href="javascript:;" data-id="<?=$row->id?>" style="padding: 4px 4px 6px 12px !important;" class="btn btn-sm btn-warning btn-edit-alamat" data-toggle="tooltip" title="Edit Alamat"><i style="color:#fff;" class="fa fa-edit"></i></a>
              <a href="javascript:;" data-id="<?=$row->id?>" style="padding: 4px 4px 6px 12px !important;" class="btn btn-sm btn-danger btn-delete-alamat" data-toggle="tooltip" title="Hapus Alamat"><i class="fa fa-trash"></i></a>	    
            </td>
          </tr>
        <?php 
          }
        }else{
        ?>
        <tr>
          <td colspan="4">Data tidak ditemukan!</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
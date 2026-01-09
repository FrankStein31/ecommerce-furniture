<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Kategori Jenis Perbaikan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <a href="<?= base_url('kategori_perbaikan/create') ?>" class="btn btn-success mr-1 mb-1">
              <i class="fa fa-plus-circle"></i> &nbsp;Tambah Kategori
            </a>
          </div>
          <div class="col-md-6">
            <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50" class="text-center">No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th width="100" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($kategori_list)): ?>
                <?php $no = 1; foreach($kategori_list as $row): ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= $row->nama_kategori ?></strong></td>
                    <td><?= $row->deskripsi ?></td>
                    <td class="text-center">
                      <?php if($row->status == '1'): ?>
                        <span class="badge badge-success">
                          <i class="fa fa-check"></i> Aktif
                        </span>
                      <?php else: ?>
                        <span class="badge badge-secondary">
                          <i class="fa fa-times"></i> Nonaktif
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('kategori_perbaikan/edit/'.$row->id) ?>" 
                         class="btn btn-sm btn-warning" 
                         data-toggle="tooltip" 
                         title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="javascript:void(0)" 
                         onclick="confirmDelete(<?= $row->id ?>, '<?= $row->nama_kategori ?>')" 
                         class="btn btn-sm btn-danger" 
                         data-toggle="tooltip" 
                         title="Hapus">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center">
                    <div class="alert alert-info mb-0">
                      <i class="fa fa-info-circle"></i> Belum ada data kategori
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Auto hide alert after 5 seconds
$(document).ready(function() {
  setTimeout(function() {
    $('#success-alert, #error-alert').fadeOut('slow');
  }, 5000);
});

function confirmDelete(id, nama) {
  Swal.fire({
    title: 'Hapus Kategori?',
    html: 'Anda yakin ingin menghapus kategori <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
    cancelButtonText: '<i class="fa fa-times"></i> Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('kategori_perbaikan/delete/') ?>' + id;
    }
  });
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

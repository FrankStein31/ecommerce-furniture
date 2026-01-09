<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Gejala Kerusakan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <a href="<?= base_url('gejala_kerusakan/create') ?>" class="btn btn-success mr-1 mb-1">
              <i class="fa fa-plus-circle"></i> &nbsp;Tambah Gejala Kerusakan
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
          <table class="table table-bordered table-striped table-hover" id="table-gejala">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50" class="text-center">No</th>
                <th width="120">Kode Gejala</th>
                <th width="250">Nama Gejala</th>
                <th>Jenis Perbaikan Terkait</th>
                <th width="100" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($gejala_list)): ?>
                <?php foreach($gejala_list as $row): ?>
                  <tr>
                    <td class="text-center"></td>
                    <td><span class="badge badge-primary"><?= $row->kode_gejala ?></span></td>
                    <td><strong><?= $row->nama_gejala ?></strong></td>
                    <td>
                      <?php if($row->jenis_perbaikan_list): ?>
                        <small class="text-muted"><?= $row->jenis_perbaikan_list ?></small>
                      <?php else: ?>
                        <span class="badge badge-warning">Belum ada relasi</span>
                      <?php endif; ?>
                    </td>
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
                      <a href="<?= base_url('gejala_kerusakan/edit/'.$row->id) ?>" 
                         class="btn btn-sm btn-warning" 
                         data-toggle="tooltip" 
                         title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="javascript:void(0)" 
                         onclick="confirmDelete(<?= $row->id ?>, '<?= addslashes($row->nama_gejala) ?>')" 
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
                  <td colspan="6" class="text-center">
                    <div class="alert alert-info mb-0">
                      <i class="fa fa-info-circle"></i> Belum ada data gejala kerusakan
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
  
  // Initialize DataTable with pagination
  $('#table-gejala').DataTable({
    "pageLength": 10,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    "order": [[1, 'asc']], // Sort by kode
    "language": {
      "lengthMenu": "Tampilkan _MENU_ data per halaman",
      "zeroRecords": "Data tidak ditemukan",
      "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
      "infoEmpty": "Tidak ada data yang tersedia",
      "infoFiltered": "(difilter dari _MAX_ total data)",
      "search": "Cari:",
      "paginate": {
        "first": "Pertama",
        "last": "Terakhir",
        "next": "Selanjutnya",
        "previous": "Sebelumnya"
      }
    },
    "columnDefs": [
      {
        "targets": 0,
        "orderable": false,
        "searchable": false,
        "render": function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        "targets": 5, // Kolom Aksi
        "orderable": false,
        "searchable": false
      }
    ]
  });
});

function confirmDelete(id, nama) {
  Swal.fire({
    title: 'Hapus Gejala Kerusakan?',
    html: 'Anda yakin ingin menghapus gejala <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
    cancelButtonText: '<i class="fa fa-times"></i> Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('gejala_kerusakan/delete/') ?>' + id;
    }
  });
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

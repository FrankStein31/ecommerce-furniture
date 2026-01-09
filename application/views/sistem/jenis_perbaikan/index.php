<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Jenis Perbaikan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <a href="<?= base_url('jenis_perbaikan/create') ?>" class="btn btn-success mr-1 mb-1">
              <i class="fa fa-plus-circle"></i> &nbsp;Tambah Jenis Perbaikan
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
        
        <!-- Filter Kategori -->
        <div class="row mb-3">
          <div class="col-md-4">
            <select class="form-control" id="filter_kategori">
              <option value="">-- Semua Kategori --</option>
              <?php foreach($kategori_list as $id => $nama): ?>
                <option value="<?= $id ?>"><?= $nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover" id="table-jenis">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50" class="text-center">No</th>
                <th width="200">Kategori</th>
                <th>Nama Jenis Perbaikan</th>
                <th>Deskripsi</th>
                <th width="100" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($jenis_list)): ?>
                <?php $no = 1; foreach($jenis_list as $row): ?>
                  <tr data-kategori="<?= $row->id_kategori ?>">
                    <td class="text-center"></td>
                    <td><span class="badge badge-info"><?= $row->nama_kategori ?></span></td>
                    <td><strong><?= $row->nama_jenis_perbaikan ?></strong></td>
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
                      <a href="<?= base_url('jenis_perbaikan/edit/'.$row->id) ?>" 
                         class="btn btn-sm btn-warning" 
                         data-toggle="tooltip" 
                         title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="javascript:void(0)" 
                         onclick="confirmDelete(<?= $row->id ?>, '<?= addslashes($row->nama_jenis_perbaikan) ?>')" 
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
                      <i class="fa fa-info-circle"></i> Belum ada data jenis perbaikan
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
  var table = $('#table-jenis').DataTable({
    "pageLength": 10,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    "order": [[1, 'asc']], // Sort by kategori
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
  
  // Filter by kategori
  $('#filter_kategori').on('change', function() {
    var kategoriId = $(this).val();
    
    if (kategoriId === '') {
      table.column(1).search('').draw();
    } else {
      // Search by kategori name in column 1
      var kategoriName = $('#filter_kategori option:selected').text();
      table.column(1).search(kategoriName).draw();
    }
  });
});

function confirmDelete(id, nama) {
  Swal.fire({
    title: 'Hapus Jenis Perbaikan?',
    html: 'Anda yakin ingin menghapus jenis perbaikan <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
    cancelButtonText: '<i class="fa fa-times"></i> Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('jenis_perbaikan/delete/') ?>' + id;
    }
  });
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

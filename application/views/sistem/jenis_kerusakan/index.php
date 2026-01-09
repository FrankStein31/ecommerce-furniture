<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Jenis Kerusakan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <a href="<?= base_url('jenis_kerusakan/create') ?>" class="btn btn-success mr-1 mb-1">
              <i class="fa fa-plus-circle"></i> &nbsp;Tambah Jenis Kerusakan
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
          <table class="table table-bordered table-striped table-hover" id="table-kerusakan">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50" class="text-center">No</th>
                <th width="100">Kode</th>
                <th width="250">Nama Jenis Kerusakan</th>
                <th>Gejala Terkait</th>
                <th width="120" class="text-center">Tingkat</th>
                <th width="80" class="text-center">Gambar</th>
                <th width="100" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($kerusakan_list)): ?>
                <?php foreach($kerusakan_list as $row): ?>
                  <tr>
                    <td class="text-center"></td>
                    <td><span class="badge badge-danger"><?= $row->kode_kerusakan ?></span></td>
                    <td><strong><?= $row->nama_jenis_kerusakan ?></strong></td>
                    <td>
                      <?php if($row->gejala_list): ?>
                        <small class="text-muted">
                          <i class="fa fa-check-circle text-success"></i> 
                          <?= $row->jumlah_gejala ?> gejala
                        </small>
                      <?php else: ?>
                        <span class="badge badge-warning">Belum ada gejala</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if($row->tingkat_kerusakan == 'ringan'): ?>
                        <span class="badge badge-info">
                          <i class="fa fa-info-circle"></i> Ringan
                        </span>
                      <?php elseif($row->tingkat_kerusakan == 'sedang'): ?>
                        <span class="badge badge-warning">
                          <i class="fa fa-exclamation-circle"></i> Sedang
                        </span>
                      <?php else: ?>
                        <span class="badge badge-danger">
                          <i class="fa fa-exclamation-triangle"></i> Berat
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if($row->ilustrasi_gambar): ?>
                        <a href="javascript:void(0)" 
                           onclick="showImage('<?= base_url($row->ilustrasi_gambar) ?>', '<?= addslashes($row->nama_jenis_kerusakan) ?>')"
                           data-toggle="tooltip" 
                           title="Lihat gambar">
                          <img src="<?= base_url($row->ilustrasi_gambar) ?>" 
                               alt="<?= $row->nama_jenis_kerusakan ?>" 
                               class="img-thumbnail" 
                               style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;">
                        </a>
                      <?php else: ?>
                        <span class="badge badge-light">
                          <i class="fa fa-image text-muted"></i> Tidak ada
                        </span>
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
                      <a href="<?= base_url('jenis_kerusakan/edit/'.$row->id) ?>" 
                         class="btn btn-sm btn-warning" 
                         data-toggle="tooltip" 
                         title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="javascript:void(0)" 
                         onclick="confirmDelete(<?= $row->id ?>, '<?= addslashes($row->nama_jenis_kerusakan) ?>')" 
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
                  <td colspan="8" class="text-center">
                    <div class="alert alert-info mb-0">
                      <i class="fa fa-info-circle"></i> Belum ada data jenis kerusakan
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

<!-- Modal untuk menampilkan gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="imageModalLabel">
          <i class="fa fa-image"></i> Ilustrasi Gambar Kerusakan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 70vh;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-times"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  setTimeout(function() {
    $('#success-alert, #error-alert').fadeOut('slow');
  }, 5000);
  
  $('#table-kerusakan').DataTable({
    "pageLength": 10,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    "order": [[1, 'asc']],
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
        "targets": [5, 7],
        "orderable": false,
        "searchable": false
      }
    ]
  });
});

function confirmDelete(id, nama) {
  Swal.fire({
    title: 'Hapus Jenis Kerusakan?',
    html: 'Anda yakin ingin menghapus jenis kerusakan <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
    cancelButtonText: '<i class="fa fa-times"></i> Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('jenis_kerusakan/delete/') ?>' + id;
    }
  });
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});

function showImage(imageUrl, namaKerusakan) {
  $('#modalImage').attr('src', imageUrl);
  $('#modalImage').attr('alt', namaKerusakan);
  $('#imageModalLabel').html('<i class="fa fa-image"></i> ' + namaKerusakan);
  $('#imageModal').modal('show');
}
</script>

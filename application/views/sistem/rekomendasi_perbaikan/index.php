<div class="row">
  <div class="col-12">
    <div class="card flat">
      <div class="card-header card-header-blue">
        <span class="card-title">Data Rekomendasi Perbaikan</span>
      </div>
      <div class="card-body">
        <div class="row" style="padding-top:12px;">
          <div class="col-md-6">
            <a href="<?= base_url('rekomendasi_perbaikan/create') ?>" class="btn btn-success mr-1 mb-1">
              <i class="fa fa-plus-circle"></i> &nbsp;Tambah Rekomendasi
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
          <table class="table table-bordered table-striped table-hover" id="table-rekomendasi">
            <thead class="bg-primary text-white">
              <tr>
                <th width="50" class="text-center">No</th>
                <th width="80">Kode</th>
                <th width="250">Nama Rekomendasi</th>
                <th width="100" class="text-center">MB</th>
                <th width="100" class="text-center">MD</th>
                <th width="100" class="text-center">CF</th>
                <th>Kerusakan Terkait</th>
                <th width="120" class="text-center">Prioritas</th>
                <th width="100" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($rekomendasi_list)): ?>
                <?php foreach($rekomendasi_list as $row): ?>
                  <tr>
                    <td class="text-center"></td>
                    <td><span class="badge badge-success"><?= $row->kode_rekomendasi ?></span></td>
                    <td>
                      <strong><?= $row->nama_rekomendasi ?></strong>
                      <?php if($row->biaya_estimasi > 0): ?>
                        <br><small class="text-muted">
                          <i class="fa fa-money"></i> Rp <?= number_format($row->biaya_estimasi, 0, ',', '.') ?>
                        </small>
                      <?php endif; ?>
                      <?php if($row->durasi_perbaikan > 0): ?>
                        <br><small class="text-muted">
                          <i class="fa fa-clock-o"></i> ~<?= $row->durasi_perbaikan ?> hari
                        </small>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <span class="badge badge-info">
                        <?= number_format($row->mb_value, 2) ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="badge badge-warning">
                        <?= number_format($row->md_value, 2) ?>
                      </span>
                    </td>
                    <td class="text-center">
                      <?php 
                        $cf_color = 'secondary';
                        if ($row->cf_value >= 0.7) $cf_color = 'success';
                        elseif ($row->cf_value >= 0.4) $cf_color = 'primary';
                        elseif ($row->cf_value >= 0) $cf_color = 'info';
                        else $cf_color = 'danger';
                      ?>
                      <span class="badge badge-<?= $cf_color ?>" data-toggle="tooltip" title="CF = MB - MD">
                        <?= number_format($row->cf_value, 2) ?>
                      </span>
                    </td>
                    <td>
                      <?php if($row->kerusakan_list): ?>
                        <small class="text-muted">
                          <i class="fa fa-wrench text-danger"></i> 
                          <?= $row->jumlah_kerusakan ?> kerusakan
                        </small>
                      <?php else: ?>
                        <span class="badge badge-warning">Belum ada kerusakan</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if($row->tingkat_prioritas == 'tinggi'): ?>
                        <span class="badge badge-danger">
                          <i class="fa fa-arrow-up"></i> Tinggi
                        </span>
                      <?php elseif($row->tingkat_prioritas == 'sedang'): ?>
                        <span class="badge badge-warning">
                          <i class="fa fa-minus"></i> Sedang
                        </span>
                      <?php else: ?>
                        <span class="badge badge-info">
                          <i class="fa fa-arrow-down"></i> Rendah
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
                      <a href="<?= base_url('rekomendasi_perbaikan/edit/'.$row->id) ?>" 
                         class="btn btn-sm btn-warning" 
                         data-toggle="tooltip" 
                         title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="javascript:void(0)" 
                         onclick="confirmDelete(<?= $row->id ?>, '<?= addslashes($row->nama_rekomendasi) ?>')" 
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
                  <td colspan="10" class="text-center">
                    <div class="alert alert-info mb-0">
                      <i class="fa fa-info-circle"></i> Belum ada data rekomendasi perbaikan
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
$(document).ready(function() {
  setTimeout(function() {
    $('#success-alert, #error-alert').fadeOut('slow');
  }, 5000);
  
  $('#table-rekomendasi').DataTable({
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
        "targets": [9],
        "orderable": false,
        "searchable": false
      }
    ]
  });
});

function confirmDelete(id, nama) {
  Swal.fire({
    title: 'Hapus Rekomendasi Perbaikan?',
    html: 'Anda yakin ingin menghapus rekomendasi <strong>' + nama + '</strong>?<br><small class="text-danger">Data yang sudah dihapus tidak dapat dikembalikan!</small>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
    cancelButtonText: '<i class="fa fa-times"></i> Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('rekomendasi_perbaikan/delete/') ?>' + id;
    }
  });
}

$(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
